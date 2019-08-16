import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";
import Header from "./Header";
import Form from "./Form/Form";
import Consumption from "./Consumption";
import Comparison from "./Comparison";

class New extends React.Component {
    constructor(props) {
        super(props);
        this.refTitle = React.createRef();
        this.refDescription = React.createRef();
        this.submitForm = this.submitForm.bind(this);
        this.onKeyDown = this.onKeyDown.bind(this);

        this.state = {
            sendLabel: 'SKICKA',
            bill: {
                monthly_consumption: {value: 83, unit: 'kWh'},
                spot_price: {value: 39.21, unit: 'öre'},
                spot_start: {value: 4.45, unit: 'öre'},
                el_certificate: {value: 4.45, unit: 'öre'},
            },
            form: this.getCleanForm(),
            errors: {}
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

    onKeyDown(e) {
        const keyCode = e.keyCode;
        this.setState({keyCode});
    }

    validatePnr(v) {
        if(v && isNaN(v)) {
            const vNoHyphen = v.replace(/-/g, '');
            if(isNaN(vNoHyphen)) {
                return  v.substring(0, v.length - 1);
            }
        }

        if(v && v.length == 6 && this.state.keyCode !== 8) {
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
            errors['first_name'] = 'Cannot be empty';
        }

        if(!fields['last_name']) {
            formIsValid = false;
            errors['last_name'] = 'Cannot be empty';
        }

        if(!fields['email']) {
            formIsValid = false;
            errors['email'] = 'Detta är ett obligatoriskt fält.';
        } else {
            if (/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[A-Za-z]+$/.test(fields['email'])) {
                console.log('EMail',true);
            } else {
                console.log('EMail',true);
                errors['email'] = 'Bör vara giltigt e-postmeddelande';
            }
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

        this.setState({errors});
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

        if((Object.keys(errors)).length > 0 || this.state.sendLabel == 'BEARBETNING') {
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
        const {spot_price, spot_start, el_certificate} = this.state.bill;
        const moms = Number(((spot_price.value + spot_start.value + el_certificate.value) * 0.25).toFixed(2));
        const price_per_kw_hour = (Number.parseFloat(spot_price.value + spot_start.value + el_certificate.value + moms)).toFixed(2);

        let comparison_price = ((39 / this.state.bill.monthly_consumption.value) * 100) + price_per_kw_hour;
        comparison_price = Number.parseFloat(comparison_price).toFixed(2);

        return (
            <section id="energy" className="container-fluid">
                <div className="box u-white-bg">
                    <div className="content">

                        <div className="row">
                            <div className="col-1-of-3">
                                <h1 className="u-left-text u-grey-text u-margin-top-big u-margin-bottom-big">BYT
                                    TILL <span
                                        className="u-green-text">GRÖN</span> ENERGI</h1>

                                 <Form saving={true} />
                            </div>


                            <div className="col-2-of-3">

                                <div className="solar-customers">
                                    <div className="bill">

                                        <div className="bill-top">
                                            <div className="bill-top-left">
                                                <Consumption contentBorderRight={false} />
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

                                                    <div className="calculator-footer" style={{display: 'flex', alignItems: 'center', justifyContent: 'center'}}>
                                                        <Comparison />
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
                                                                <img className="energy-sources" src="images/rectangle.png" alt="ENERGIKÄLLA" />
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
};

export default withRouter(connect(mapStateToProps, mapActionsToProps)(New));
