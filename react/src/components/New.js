import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";
import ListPost from './ListPost';
import {postsAddAction} from "../actions/PostsAction";
import Sidebar from "./Sidebar";
import Header from "./Header";

class New extends React.Component {
    constructor(props) {
        super(props);
        this.refTitle = React.createRef();
        this.refDescription = React.createRef();
        this.submitForm = this.submitForm.bind(this);

        this.state = {
            sendLabel: 'SKICKA',
            bill: {
                monthly_consumption: {value: 83, unit: 'kWh'},
                spot_price: {value: 39.21, unit: 'öre'},
                spot_start: {value: 4.45, unit: 'öre'},
                el_certificate: {value: 4.45, unit: 'öre'},
            },
            form: this.getCleanForm()
        };

        this.refSaving = React.createRef();
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
            eula: false,
            saving: false
        }
    }

    validatePnr(v) {
        if(v && isNaN(v)) {
            const vNoHyphen = v.replace(/-/g, '');
            if(isNaN(vNoHyphen)) {
                return  v.substring(0, v.length - 1);
            }
        }

        if(v && v.length == 6) {
            return v + '-';
        }

        if(v && v.length > 11) {
            return v.substring(0, 11);
        }
        return v;
    }

    handleValidation() {
        let fields = this.state.form;
        let errors = {};
        let formIsValid = true;

        if(!fields['first_name']) {
            formIsValid = false;
            errors['firts_name'] = 'Cannot be empty';
        }

        if(!fields['last_name']) {
            formIsValid = false;
            errors['last_name'] = 'Cannot be empty';
        }

        if(!fields['email']) {
            formIsValid = false;
            errors['email'] = 'Email cannot be empty';
        }

        if(!fields['telephone']) {
            formIsValid = false;
            errors['telephone'] = 'telephone cannot be empty';
        }

        if(!fields['personummer']) {
            formIsValid = false;
            errors['personummer'] = 'Personnummer cannot be empty';
        }

        if(!fields['address']) {
            formIsValid = false;
            errors['address'] = 'Address cannot be empty';
        }

        if(!fields['postNumber']) {
            formIsValid = false;
            errors['postNumber'] = 'postnummer cannot be empty';
        }

        if(!fields['city']) {
            formIsValid = false;
            errors['city'] = 'city cannot be empty';
        }

        if(fields['eula'] == false) {
            formIsValid = false;
            errors['eula'] = 'Please accept EULA';
        }

        return errors;
    }

    handleChange(e) {
        const { form } = this.state;

        if(e.target.id == 'saving') {
            form.saving =  this.refSaving.current.checked == true ? true : false;
            form.savings = !!! this.refSaving.current.checked;
            console.log('Saving: ', e.target.id, this.refSaving.current.checked, form.saving);
        }

        if(e.target.id == 'eula') {
            form[e.target.id] = ! form.eula;
        } else {
            form[e.target.id] = e.target.id == 'personummer' ? this.validatePnr(e.target.value) : e.target.value;
        }

        this.setState({form});
        console.log(form);
    }

    async submitForm(e) {
        e.preventDefault();
        console.log('Before checking validation ');
        const errors = this.handleValidation();

        if((Object.keys(errors)).length > 0) {
            console.log(errors);
            return false;
        }

        const urlLive = 'https://www.sveasolar.se/wp-content/themes/xpro-child/calculatorv2/solarcalc-extras/submitform.php';
        const proxyUrl = "https://cors-anywhere.herokuapp.com/";

        this.setState({sendLabel: 'BEARBETNING'});

        const response = await fetch(proxyUrl + urlLive, {
            method: 'POST',
            headers: {
                'Accept' : 'application/json',
                'Content-Type' : 'application/json'
            },
            body : JSON.stringify(this.state.form)
        });

        const result = await response;
        const form = this.getCleanForm();
        this.setState({form, sendLabel: 'SKICKA'});
        console.log(result);
    }

    render() {
        const {spot_price, spot_start, el_certificate, monthly_consumption} = this.state.bill;
        const moms = Number(((spot_price.value + spot_start.value + el_certificate.value) * 0.25).toFixed(2));
        const price_per_kw_hour = (Number.parseFloat(spot_price.value + spot_start.value + el_certificate.value + moms)).toFixed(2);

        let comparison_price = ((39 / this.state.bill.monthly_consumption.value) * 100) + price_per_kw_hour;
        comparison_price = Number.parseFloat(comparison_price).toFixed(2);

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
                                    TILL <span
                                        className="u-green-text">GRÖN</span> ENERGI</h1>

                                <form action="">
                                    <div className="row">
                                        <div className="col-1-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="first_name"
                                                       placeholder="Förnamn" value={this.state.form.first_name} onChange={(e)=>this.handleChange(e)} />
                                                <span id="first-name-error"
                                                      className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                        <div className="col-2-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="last_name"
                                                       placeholder="Efternamn" value={this.state.form.last_name} onChange={(e)=>this.handleChange(e)}/>
                                                <span id="last-name-error"
                                                      className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-1">
                                            <div className="form-group">
                                                <input type="email" className="form-control" id="email"
                                                       placeholder="E-post" value={this.state.form.email} onChange={(e)=>this.handleChange(e)}/>
                                                <span id="email-error" className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="telephone"
                                                       placeholder="Telefon" value={this.state.form.telephone} onChange={(e)=>this.handleChange(e)}/>
                                                <span id="telephone-error"
                                                      className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                        <div className="col-2-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="personummer"
                                                       placeholder="xxxxxx-xxxx" value={this.state.form.personummer} onChange={(e)=>this.handleChange(e)} />
                                                <span id="email-error" className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-1">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="address"
                                                       placeholder="Gata" value={this.state.form.address} onChange={(e)=>this.handleChange(e)} />
                                                <span id="gata-error" className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="postNumber"
                                                       placeholder="Postnummer" value={this.state.form.postNumber} onChange={(e)=>this.handleChange(e)} />
                                                <span id="postnumber-error"
                                                      className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                        <div className="col-2-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="city"
                                                       placeholder="Ort" value={this.state.form.city} onChange={(e)=>this.handleChange(e)} />
                                                <span id="city-error" className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-1">
                                            <div className="form-group">
                                                <div style={{display: 'flex'}}>
                                                    <div style={{flex: 1, textAlign: 'left', paddingTop: '12px'}}>
                                                        <input type="checkbox"  checked={this.state.form.eula} onChange={(e)=>this.handleChange(e)} className="form-control" id="eula" />
                                                    </div>
                                                    <div style={{flex: 10}}>
                                                        <label htmlFor="eula" className="eula">
                                                            Jag accepterar SVEA Energy allmänna vilkor samt ger
                                                            tillstånd behandla min personliga information enligt de
                                                            lagar som rådar.
                                                            Svea Energy har även tillstånd att hämta
                                                            min förbrukningsdata från min nätägare.
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div className="vertical-buttons u-margin-bottom-big">
                                        <div style={{display: 'flex', flexDirection: 'row', width: '100%'}}>
                                            <input type="checkbox" ref={this.refSaving} id="toggle" className="checkbox" />
                                            <label htmlFor="toggle" className="switch" id="saving" onClick={(e)=>this.handleChange(e)}></label>
                                            <span className="u-left-text">Visa mig hur mycket jag kan spara på att installera solceller!</span>
                                        </div>
                                        <button onClick={this.submitForm} id="send" className="btn btn-success">{this.state.sendLabel}</button>
                                    </div>
                                </form>
                            </div>


                            <div className="col-2-of-3">

                                <div className="solar-customers">
                                    <div className="bill">

                                        <div className="bill-top">
                                            <div className="bill-top-left">
                                                <div className="calculator">
                                                    <div className="calculator-header">
                                                        <h2 className="u-center-text u-grey-text">RÖRLIGT</h2>
                                                        <p className="heading u-grey-text u-center-text">FÖRBRUKNINGSAVTAL</p>
                                                    </div>

                                                    <div className="calculator-content" style={{border: 'none'}}>

                                                        <div className="item">
                                                            <p className="title">Uppskattad Måndasförbrukning</p>
                                                            <span className="price">
                                                                {monthly_consumption.value} {monthly_consumption.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item" style={{marginBottom: '12px'}}>
                                                            <p className="title"> Pris per kilowattimme </p>
                                                            <span className="price line">
                                                                {price_per_kw_hour} öre
                                                            </span>
                                                        </div>


                                                        <div className="item">
                                                            <p className="title"> Spotpris </p>
                                                            <span className="price">
                                                                {spot_price.value} {spot_price.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> Spotpåslag </p>
                                                            <span className="price">
                                                                {spot_start.value} {spot_start.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> Elcertifikat </p>
                                                            <span className="price">
                                                                {el_certificate.value} {el_certificate.unit}
                                                            </span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> MOMS </p>
                                                            <span className="price line">
                                                                {moms} öre
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

                                            <div className="bill-top-right">
                                                <div className="calculator">
                                                    <div className="calculator-header">
                                                        <h2 className="u-center-text u-grey-text">RÖRLIGT</h2>
                                                        <p className="heading u-grey-text u-center-text">FÖRBRUKNINGSAVTAL</p>
                                                    </div>

                                                    <div className="calculator-content">

                                                        <div className="item">
                                                            <p className="title"><strong>Vi tycker att bindningstid har
                                                                passerat sitt
                                                                utgångsdatum</strong></p>
                                                        </div>

                                                        <div className="item" style={{marginBottom: '12px'}}>
                                                            <p className="title"> Ingen gillar bindningstider - Det gör
                                                                inte vi heller!
                                                                Hos oss är det du some bestämmer om vi är bra nog,
                                                                därför utesluter
                                                                vi bindningstid.</p>
                                                            <b>Du kan säga upp avtalet när du vill.</b>
                                                        </div>
                                                    </div>

                                                    <div className="calculator-footer">
                                                        <div className="item" style={{textAlign: 'center'}}>
                                                            <p className="compare"> DITT JÄMFÖRELSE </p>
                                                            <p className="small u-center-text"> PRIS </p>
                                                            <span className="price u-center-text">{comparison_price} / KwH</span>
                                                        </div>

                                                        <div className="item u-margin-top-big">
                                                            <button className="btn btn-success small">SE
                                                                JÄMFÖRELSEPRISER
                                                            </button>
                                                        </div>
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

export default withRouter(connect(mapStateToProps, mapActionsToProps)(New));
