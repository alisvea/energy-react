import React from 'react';
import axios from 'axios';

class Form extends React.Component {
    constructor(props) {
        super(props);
        this.submitForm = this.submitForm.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.onKeyDown = this.onKeyDown.bind(this);
        this.getCleanForm = this.getCleanForm.bind(this);
        this.handleValidation = this.handleValidation.bind(this);

        this.state = {
            sendLabel: 'SKICKA',
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
            phone: '',
            personummer: '',
            address: '',
            postNumber: '',
            city: '',
            eula: false,
            oid : '00D58000000IHRE',
            retURL :  'https://sveasolar.se/tack_sk/',
            lead_source : 'Website',
            company : 'x',
            Energy_Supplier__c : 'Sjogerstads Energi AB',
            Property_Type__c : 'Bostadrättsförening',
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

        if (!fields['phone']) {
            formIsValid = false;
            errors['phone'] = 'phone cannot be empty';
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

    sendRequest() {

        var params = this.state.form;
        params.oid = '00D58000000IHRE';
        params.retURL =  'https://sveasolar.se/tack_sk/';
        params.lead_source = 'Website';
        params.company = 'x';
        params.Energy_Supplier__c = 'Sjogerstads Energi AB';
        params.Property_Type__c = 'Bostadrättsförening';

        var urlEncodeParams = this.urlEncoded(params);
        var http = new XMLHttpRequest();
        var urlLive = 'https://www.sveasolar.se/wp-content/themes/xpro-child/calculatorv2/solarcalc-extras/submitform.php';
        var url = 'https://www.sveasolar.se/v2/calculator/api/submitform.php';
        const proxyurl = "https://cors-anywhere.herokuapp.com/";
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        http.onreadystatechange =  () => {
            if (http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                const form = this.getCleanForm();
                this.setState({form, sendLabel: 'SKICKA'});
            }
            if (http.status == 429) {
                console.log(http.responseText);
                alert('An error has occurred, please refresh the page.');
            }
        };

        console.log('Before checking validation ');
        const errors = this.handleValidation();

        if ((Object.keys(errors)).length > 0 || this.state.sendLabel == 'BEARBETNING') {
            console.log(errors);
            return false;
        }

        this.setState({sendLabel: 'BEARBETNING'});
        http.send(urlEncodeParams);
    }

    urlEncoded(obj) {
        var params = '';
        Object.keys(obj).forEach(function (key) {
            params = params + key + '=' + obj[key] + '&'
        });

        return params;
    }

    async submitForm(e) {
        e.preventDefault();
        this.sendRequest();
        return ;
        console.log('Before checking validation ');
        const errors = this.handleValidation();

        if ((Object.keys(errors)).length > 0 || this.state.sendLabel == 'BEARBETNING') {
            console.log(errors);
            return false;
        }

        this.setState({sendLabel: 'BEARBETNING'});
        const urlLive = 'https://www.sveasolar.se/wp-content/themes/xpro-child/calculatorv2/solarcalc-extras/submitform.php';
        const proxyUrl = "https://cors-anywhere.herokuapp.com/";
        const submitForm = 'http://localhost:8081/submitform.php';

        console.log('Posting to ' , proxyUrl + urlLive);

        axios.post(proxyUrl + urlLive, this.state.form).then(res => res.data).catch(error => {
            throw new Error(error);
            console.dir(error);
        });

        /*const response = await axios.post(submitForm, {
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
        console.log(result); */
    }

    render() {
        return (
            <form action="">
                <div className="row">
                    <div className="col-1-of-3">
                        <div className="form-group">
                            <input type="text" className="form-control" id="first_name"
                                   placeholder="Förnamn" value={this.state.form.first_name}
                                   onChange={(e) => this.handleChange(e)}/>
                            <span id="first-name-error"
                                  style={{display: this.state.errors.first_name ? 'block' : 'none'}}
                                  className="help-inline">Detta är ett obligatoriskt fält.</span>
                        </div>
                    </div>
                    <div className="col-2-of-3">
                        <div className="form-group">
                            <input type="text" className="form-control" id="last_name"
                                   placeholder="Efternamn" value={this.state.form.last_name}
                                   onChange={(e) => this.handleChange(e)}/>
                            <span id="last-name-error"
                                  style={{display: this.state.errors.last_name ? 'block' : 'none'}}
                                  className="help-inline">Detta är ett obligatoriskt fält.</span>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-1-of-1">
                        <div className="form-group">
                            <input type="email" className="form-control" id="email"
                                   placeholder="E-post" value={this.state.form.email}
                                   onChange={(e) => this.handleChange(e)}/>
                            <span id="email-error"
                                  style={{display: this.state.errors.email ? 'block' : 'none'}}
                                  className="help-inline">{this.state.errors.email}</span>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-1-of-3">
                        <div className="form-group">
                            <input type="text" className="form-control" id="phone"
                                   placeholder="Telefon" value={this.state.form.phone}
                                   onChange={(e) => this.handleChange(e)}/>
                            <span id="phone-error"
                                  style={{display: this.state.errors.phone ? 'block' : 'none'}}
                                  className="help-inline">Detta är ett obligatoriskt fält.</span>
                        </div>
                    </div>
                    <div className="col-2-of-3">
                        <div className="form-group">
                            <input type="text" className="form-control" id="personummer"
                                   placeholder="xxxxxx-xxxx" value={this.state.form.personummer}
                                   onChange={(e) => this.handleChange(e)}
                                   onKeyDown={this.onKeyDown}/>
                            <span id="personummer-error"
                                  style={{display: this.state.errors.personummer ? 'block' : 'none'}}
                                  className="help-inline">Detta är ett obligatoriskt fält.</span>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-1-of-1">
                        <div className="form-group">
                            <input type="text" className="form-control" id="address"
                                   placeholder="Gata" value={this.state.form.address}
                                   onChange={(e) => this.handleChange(e)}/>
                            <span id="gata-error"
                                  style={{display: this.state.errors.address ? 'block' : 'none'}}
                                  className="help-inline">Detta är ett obligatoriskt fält.</span>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-1-of-3">
                        <div className="form-group">
                            <input type="text" className="form-control" id="postNumber"
                                   placeholder="Postnummer" value={this.state.form.postNumber}
                                   onChange={(e) => this.handleChange(e)}/>
                            <span id="postnumber-error"
                                  style={{display: this.state.errors.postNumber ? 'block' : 'none'}}
                                  className="help-inline">Detta är ett obligatoriskt fält.</span>
                        </div>
                    </div>
                    <div className="col-2-of-3">
                        <div className="form-group">
                            <input type="text" className="form-control" id="city"
                                   placeholder="Ort" value={this.state.form.city}
                                   onChange={(e) => this.handleChange(e)}/>
                            <span id="city-error"
                                  style={{display: this.state.errors.city ? 'block' : 'none'}}
                                  className="help-inline">Detta är ett obligatoriskt fält.</span>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-1-of-1">
                        <div className="form-group" style={{marginBottom: 0}}>
                            <div style={{display: 'flex'}}>
                                <div style={{flex: 1, textAlign: 'left', paddingTop: '12px'}}>
                                    <input type="checkbox" checked={this.state.form.eula}
                                           onChange={(e) => this.handleChange(e)}
                                           className="form-control" id="eula"/>
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

                        <div style={{display: 'block'}}>
                                                        <span id="city-error"
                                                              style={{display: this.state.errors.eula ? 'block' : 'none'}}
                                                              className="help-inline">Detta är ett obligatoriskt fält.</span>
                        </div>

                    </div>
                </div>

                <div className="vertical-buttons u-margin-bottom-big">
                    {
                        this.props.saving
                            ?
                            <div style={{display: 'flex', flexDirection: 'row', width: '100%'}}>
                                <input type="checkbox" ref={this.refSaving} id="toggle" className="checkbox"/>
                                <label htmlFor="toggle" className="switch" id="saving"
                                       onClick={(e) => this.handleChange(e)}></label>
                                <span className="switch-text u-left-text">Visa mig hur mycket jag kan spara på att installera solceller!</span>
                            </div>
                            :
                            null
                    }
                    <button onClick={this.submitForm} id="send"
                            className="btn btn-success u-margin-top-big">{this.state.sendLabel}</button>
                </div>
            </form>
        )
    }
}

export default Form;
