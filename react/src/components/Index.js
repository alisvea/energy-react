import React from 'react';
import axios from 'axios'
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";
import {postsAddAction} from "../actions/PostsAction";
import Header from "./Header";
import Form from "./Form/Form";

import {apiServer} from '../common/constants';


const endPoint = '/v2/calculator/api/?zone=';
const server = apiServer + endPoint;


class Index extends React.Component {
    constructor(props) {
        super(props);
        this.submitForm = this.submitForm.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.onKeyDown = this.onKeyDown.bind(this);

        this.state = {
            sendLabel: 'SKICKA',
            bill: {
                monthly_consumption: {value: 83, unit: 'kWh'},
                price_per_kw_hour: {value: 0, unit: 'öre'},

                spot_price: {value: 39.21, unit: 'öre'},
                spot_start: {value: 4.45, unit: 'öre'},
                el_certificate: {value: 4.45, unit: 'öre'},
                moms: {value: 0, unit: 'öre'}
            },
            production: {
                monthly_production: {value: 204, unit: 'kWh'},
                price_per_kw_hour: {value: 0, unit: 'öre'},

                spot_price: {value: 41.34, unit: 'öre'},
                svea_energy_price: {value: 5, unit: 'öre'},
                skatt_reduction: {value: 60, unit: 'öre'},
            },
            form: this.getCleanForm(),
            errors: {},
        }
    }

    onKeyDown(e) {
        const keyCode = e.keyCode;
        this.setState({keyCode});
    }

    getCleanForm() {
        return {
            first_name: '',
            last_name: '',
            email: '',
            telephone: '',
            personummer: '',
            address: '',
            postNumber: '',
            city: '',
            eula: false
        }
    }

    validatePnr(v, e) {
        if (v && isNaN(v)) {
            const vNoHyphen = v.replace(/-/g, '');
            if (isNaN(vNoHyphen)) {
                return v.substring(0, v.length - 1);
            }
        }

        if (v && v.length == 6 && this.state.keyCode !== 8) {
            return v + '-';
        }

        if (v && v.length > 11) {
            return v.substring(0, 11);
        }
        return v;
    }

    handleValidation() {
        let fields = this.state.form;
        let errors = {};
        let formIsValid = true;

        if (!fields['first_name']) {
            formIsValid = false;
            errors['first_name'] = 'Cannot be empty';
        }

        if (!fields['last_name']) {
            formIsValid = false;
            errors['last_name'] = 'Cannot be empty';
        }

        if (!fields['email']) {
            formIsValid = false;
            errors['email'] = 'Detta är ett obligatoriskt fält.';
        } else {
            if (/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[A-Za-z]+$/.test(fields['email'])) {
            } else {
                errors['email'] = 'Bör vara giltigt e-postmeddelande';
            }
        }

        if (!fields['telephone']) {
            formIsValid = false;
            errors['telephone'] = 'telephone cannot be empty';
        }

        if (!fields['personummer']) {
            formIsValid = false;
            errors['personummer'] = 'Personnummer cannot be empty';
        }

        if (!fields['address']) {
            formIsValid = false;
            errors['address'] = 'Address cannot be empty';
        }

        if (!fields['postNumber']) {
            formIsValid = false;
            errors['postNumber'] = 'postnummer cannot be empty';
        }

        if (!fields['city']) {
            formIsValid = false;
            errors['city'] = 'city cannot be empty';
        }

        if (fields['eula'] == false) {
            formIsValid = false;
            errors['eula'] = 'Please accept EULA';
        }

        this.setState({errors});

        return errors;
    }

    handleChange(e) {
        const {form} = this.state;
        if (e.target.id == 'eula') {
            form[e.target.id] = !form.eula;
        } else {
            form[e.target.id] = e.target.id == 'personummer' ? this.validatePnr(e.target.value, e) : e.target.value;
        }

        this.setState({form});
    }

    async getSpotPrice(zone) {
        axios.get(server + zone).then(res => {
                const {bill, production} = this.state;
                bill.spot_price = {value: Number(res.data.spot_price), unit: 'öre', zone: res.data.zone};
                production.spot_price.value = Number(res.data.spot_price);
                this.setState({bill, production});
                this.computeAll();
            }
        ).catch(error => {
            throw new Error(error);
            console.dir(error);
        });
    }

    async submitForm(e) {
        e.preventDefault();

        console.log('Before checking validation ');
        const errors = this.handleValidation();

        if ((Object.keys(errors)).length > 0 || this.state.sendLabel == 'BEARBETNING') {
            console.log(errors);
            return false;
        }

        this.setState({sendLabel: 'BEARBETNING'});
        const urlLive = 'https://www.sveasolar.se/wp-content/themes/xpro-child/calculatorv2/solarcalc-extras/submitform.php';
        const proxyUrl = "https://cors-anywhere.herokuapp.com/";

        const response = await fetch(proxyUrl + urlLive, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(this.state.form)
        });

        const result = await response;
        const form = this.getCleanForm();
        this.setState({form, sendLabel: 'SKICKA'});
        console.log(result);
    }

    computeAll() {
        this.computeMoms();
        this.computePerKwHour('consumption');
        this.computePerKwHour('production');
    }

    componentWillMount() {
        this.getSpotPrice('SE1');
        console.log('Index - componentWillMount');
        this.setParams();
        this.computeAll();
    }

    setParams() {
        const {search} = this.props.location; // ?cons=4000&prod=888&v=1
        const params = search.split('&');
        console.log(params);
        const paramsArray = {};
        params.forEach(param => {
            let a = param.split('=');
            let key = a[0].replace('?', '');
            paramsArray[key] = a[1];
        });

        const {bill, production} = this.state;
        bill.monthly_consumption.value = paramsArray.cons;
        production.monthly_production.value = paramsArray.prod;
        console.log(paramsArray);
        this.setState({bill, production, version: paramsArray.v});
    }

    computeMoms() {
        const {spot_price, spot_start, el_certificate} = this.state.bill;
        const moms = Number(((spot_price.value + spot_start.value + el_certificate.value) * 0.25).toFixed(2));
        const {bill} = this.state;
        bill.moms = moms;
        this.setState({bill});
    }

    computePerKwHour(type) {
        if(type === 'consumption') {
            let {spot_price, spot_start, el_certificate, moms} = this.state.bill;
            const { bill } = this.state;
            let price_per_kw_hour = (Number.parseFloat(spot_price.value + spot_start.value + el_certificate.value + moms)).toFixed(2);
            bill.price_per_kw_hour = price_per_kw_hour;
            this.setState({bill});
        }

        if(type === 'production') {
            let {production} = this.state;
            let price_per_kw_hour = Number(production.spot_price.value) + production.svea_energy_price.value + production.skatt_reduction.value;
            production.price_per_kw_hour = price_per_kw_hour;
            this.setState({production});
        }

    }

    render() {
        console.log('Index - render ');
        const {bill, production} = this.state;
        let comparison_price = (parseFloat(((39 / bill.monthly_consumption.value) * 100) + bill.price_per_kw_hour)).toFixed(2);


        return (
            <section id="energy" className="container-fluid">
                <div className="box u-margin-top-big u-white-bg">
                    <div className="content">
                        <div className="row">
                            <Header/>
                        </div>
                        <div className="row">
                            <div className="col-1-of-3">
                                <h1 className="u-left-text u-grey-text u-margin-top-big u-margin-bottom-big">BYT
                                    TILL <span className="u-green-text">GRÖN</span> ENERGI</h1>

                                <Form saving={false} />
                            </div>

                            <div className="col-2-of-3">

                                <div className="solar-customers">
                                    <div className="bill">

                                        <div className="bill-top">
                                            <div className="bill-top-col">
                                                <div className="calculator">
                                                    <div className="calculator-header">
                                                        <h2 className="u-center-text u-grey-text">RÖRLIGT</h2>
                                                        <p className="heading u-grey-text u-center-text">FÖRBRUKNINGSAVTAL</p>
                                                    </div>

                                                    <div className="calculator-content">

                                                        <div className="item">
                                                            <p className="title">Uppskattad Måndasförbrukning</p>
                                                            <span className="price">
                                                                {bill.monthly_consumption.value} {bill.monthly_consumption.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item" style={{marginBottom: '12px'}}>
                                                            <p className="title"> Pris per kilowattimme </p>
                                                            <span className="price line bolder">
                                                                {bill.price_per_kw_hour} öre
                                                            </span>
                                                        </div>


                                                        <div className="item">
                                                            <p className="title"> Spotpris </p>
                                                            <span className="price">
                                                                {bill.spot_price.value} {bill.spot_price.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> Spotpåslag </p>
                                                            <span className="price">
                                                                {bill.spot_start.value} {bill.spot_start.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> Elcertifikat </p>
                                                            <span className="price">
                                                                {bill.el_certificate.value} {bill.el_certificate.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> MOMS </p>
                                                            <span className="price line">
                                                                {bill.moms} öre
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div className="calculator-footer">
                                                        <div className="total">
                                                            <p className="total-price">88 kr / månad</p>
                                                            <p className="total-text">
                                                                *Det rorliga elpriset/spotpriser andras hela tiden och
                                                                följer
                                                                nordiska elbörsen (nordpool).
                                                                Elcertifikatskostnaden varierar måndasvis.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div className="bill-top-col">
                                                <div className="calculator">
                                                    <div className="calculator-header">
                                                        <h2 className="u-center-text u-grey-text">RÖRLIGT</h2>
                                                        <p className="heading u-grey-text u-center-text">PRODUKTIONSAVTAL</p>
                                                    </div>

                                                    <div className="calculator-content" style={{minHeight: '350px'}}>

                                                        <div className="item">
                                                            <p className="title">Uppskattad Månadsproduktion</p>
                                                            <span className="price">
                                                                {production.monthly_production.value} {production.monthly_production.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item" style={{marginBottom: '12px'}}>
                                                            <p className="title"> Pris per kilowattimme </p>
                                                            <span
                                                                className="price line bolder">{production.price_per_kw_hour} öre</span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> Spotpris </p>
                                                            <span className="price">
                                                                {production.spot_price.value} {production.spot_price.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> SVEA Energy pris </p>
                                                            <span className="price">
                                                                {production.svea_energy_price.value} {production.svea_energy_price.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> Skattereduktion </p>
                                                            <span className="price line"
                                                                  style={{paddingBottom: '80px'}}>
                                                                {production.skatt_reduction.value} {production.skatt_reduction.unit}
                                                            </span>
                                                        </div>

                                                    </div>

                                                    <div className="calculator-footer">
                                                        <div className="total">
                                                            <p className="total-price">88 kr / månad</p>
                                                            <p className="total-text">
                                                                *Det rorliga elpriset/spotpriser andras hela tiden och
                                                                följer
                                                                nordiska elbörsen (nordpool).
                                                                Elcertifikatskostnaden varierar måndasvis.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div className="bill-top-col">
                                                <div className="calculator">
                                                    <div className="calculator-header">
                                                        <h2 className="u-center-text u-grey-text">INGEN</h2>
                                                        <p className="heading u-grey-text u-center-text">Bindningstid</p>
                                                    </div>

                                                    <div className="calculator-content"
                                                         style={{
                                                             border: 'none',
                                                             minHeight: '412px',
                                                             paddingRight: '25px'
                                                         }}>

                                                        <div className="item">
                                                            <p className="title" style={{textAlign: 'center'}}>Vi tycker
                                                                att bindningstid har passerat
                                                                sitt
                                                                utgångsdatum</p>
                                                        </div>

                                                        <div className="item" style={{marginBottom: '12px'}}>
                                                            <p className="title" style={{textAlign: 'center'}}> Ingen
                                                                gillar bindningstider - Det gör
                                                                inte vi heller!
                                                                Hos oss är det du some bestämmer om vi är bra nog,
                                                                därför utesluter vi bindningstid.</p>
                                                            <b style={{
                                                                textAlign: 'center',
                                                                display: 'block',
                                                                marginTop: '12px'
                                                            }}>Du kan säga upp avtalet när du vill.</b>
                                                        </div>


                                                        <div className="item" style={{textAlign: 'center'}}>
                                                            <p className="compare"> DITT JÄMFÖRELSE </p>
                                                            <p className="small u-center-text"> PRIS </p>
                                                            <span className="price u-center-text">{comparison_price} / KwH</span>
                                                        </div>

                                                    </div>

                                                    <div className="calculator-footer">
                                                        <button className="btn-thin btn-success small">SE
                                                            JÄMFÖRELSEPRISER
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="bill-bottom">
                                            <div className="bill-source">

                                                <div className="col-1-of-1">
                                                    <div className="circle"></div>
                                                    <div className="rectangle">
                                                        <div className="col-1-of-3"></div>
                                                        <div className="col-2-of-3">
                                                            <div className="rectangle-image">
                                                                <h1>ENERGIKÄLLA</h1>
                                                                <img className="energy-sources"
                                                                     src="images/rectangle.png" alt="ENERGIKÄLLA"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style={{clear: 'both'}}></div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </section>

        )
    }
}

/**
 * Get data from store
 * @param state
 */
const mapStateToProps = state => ({
    posts: state.posts,
});

/**
 * Import action from dir action above - but must be passed to connect method in order to trigger reducer in store
 * @type {{UserUpdate: UserUpdateAction}}
 */
const mapActionsToProps = {
    postsAddAction
};

export default withRouter(connect(mapStateToProps, mapActionsToProps)(Index));
