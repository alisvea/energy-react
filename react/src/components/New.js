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
    }

    submitForm(e) {
        e.preventDefault();
        const title = this.refTitle.current.value;
        const description = this.refDescription.current.value;
        console.log(title, description);
        this.props.postsAddAction({title, description, author_id: 1});
        this.refTitle.current.value = '';
        this.refDescription.current.value = '';
    }

    render() {
        return (
            <section id="energy" className="container-fluid">
                <div className="box u-margin-top-big u-white-bg">
                    <div className="content">
                        <div className="row">
                            <Header />
                        </div>

                        <div className="row">
                            <div className="col-1-of-3">
                                <h1 className="u-left-text u-grey-text u-margin-top-big u-margin-bottom-big">BYT TILL <span
                                    className="u-green-text">GRÖN</span>
                                    ENERGI</h1>

                                <form action="">
                                    <div className="row">
                                        <div className="col-1-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="first-name"
                                                       placeholder="Förnamn" />
                                    <span id="first-name-error"
                                          className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                        <div className="col-2-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="last-name"
                                                       placeholder="Efternamn" />
                                    <span id="last-name-error"
                                          className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-1">
                                            <div className="form-group">
                                                <input type="email" className="form-control" id="email"
                                                       placeholder="E-post" />
                                                    <span id="email-error" className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="telephone"
                                                       placeholder="Telefon" />
                                    <span id="telephone-error"
                                          className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                        <div className="col-2-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="personummer"
                                                       placeholder="Personummer" />
                                                    <span id="email-error" className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-1">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="gata"
                                                       placeholder="Gata" />
                                                    <span id="gata-error" className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="postnumber"
                                                       placeholder="Postnummer" />
                                    <span id="postnumber-error"
                                          className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                        <div className="col-2-of-3">
                                            <div className="form-group">
                                                <input type="text" className="form-control" id="city" placeholder="Ort" />
                                                    <span id="city-error" className="help-inline">Detta är ett obligatoriskt fält.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row">
                                        <div className="col-1-of-1">
                                            <div className="form-group">
                                                <div style={{display: 'flex', width: '100%'}}>
                                                    <div style={{flex: 1, textAlign: 'left', paddingTop: '12px'}}>
                                                        <input type="checkbox" className="form-control" id="eula" />
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
                                            <input type="checkbox" id="toggle" className="checkbox" />
                                            <label htmlFor="toggle" className="switch"></label>
                                            <span className="u-left-text">Visa mig hur mycket jag kan spara på att installera solceller!</span>
                                        </div>


                                        <button id="send" className="btn btn-success">SKICKA</button>
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
                                                            <p className="title">Uppskattad Måndasförbruknin</p>
                                                            <span className="price">83 kWh</span>
                                                        </div>

                                                        <div className="item" style={{marginBottom: '12px'}}>
                                                            <p className="title"> Pris per kilowattimme </p>
                                                            <span className="price line">58.89 öre</span>
                                                        </div>


                                                        <div className="item">
                                                            <p className="title"> Spotpris </p>
                                                            <span className="price">39.21 öre</span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> Spotpåslag </p>
                                                            <span className="price">4.45 öre</span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> Elcertifikat </p>
                                                            <span className="price">3.45 öre</span>
                                                        </div>

                                                        <div className="item">
                                                            <p className="title"> MOMS </p>
                                                            <span className="price line">11.78 öre</span>
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
                                                            <span className="price u-center-text">90 öre / KwH</span>
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
