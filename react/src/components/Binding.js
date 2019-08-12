import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";
import Comparison from './Comparison';


class Binding extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
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
        }
    }

    computeAll(nextProps) {
        this.computeMoms();
        this.computePerKwHour('consumption');
        this.computePerKwHour('production');
        this.setParams(nextProps);
    }

    componentWillMount() {
        this.setParams();
        this.computeAll();
    }

    componentWillReceiveProps(nextProps, nextContext) {
        console.log('Bindningstid - componentWillReceiveProps : spot', nextProps.spot);
        console.log('Bindningstid - componentWillReceiveProps :  prev props spot', this.props.spot);
        if( ! nextProps.spot) return;

        const { spot } = nextProps;

        const {bill, production} = this.state;
        bill.spot_price = {value: Number(spot.spot_price), unit: 'öre', zone: spot.zone};
        production.spot_price.value = Number(spot.spot_price);
        this.setState({bill, production});
        this.computeAll(nextProps);

        this.setVersion(nextProps);
    }

    setParams(nextProps) {
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

        // Set the price for
        // 1 - SVEA Energy
        // 2 - Bindningstid
        this.setVersion(nextProps);
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

    componentDidMount() {
        console.log('componentDidMount Binding');
    }

    setVersion(nextProps) {
        const props = nextProps ? nextProps : this.props;
        const { pathname } = props.location;
        const { production } = this.state;

        // There are four version for the svea energy price - based on the uri part as follows
        // 1 - byt-elavtal    2 - erbjudande20   3 - employee-discount   4 - erbjudande19
        const uri = pathname ? pathname.replace(/\//g, ''): '/byt-elavtal2';

        console.log('Bindningstid - setVersion : pathname', uri);

        switch (uri) {
            case 'byt-elavtal' :
                production.svea_energy_price.value = 5;
                production.svea_energy_price.bindingTime = 'INGEN';
                break;

            case 'erbjudande20' :
                production.svea_energy_price.value = 20;
                production.svea_energy_price.bindingTime = '3 år';
                break;

            case 'employee-discount' :
                production.svea_energy_price.value = 5;
                production.svea_energy_price.bindingTime = 'INGEN';
                break;

            case 'erbjudande19' :
                production.svea_energy_price.value = 30;
                production.svea_energy_price.bindingTime = '3 år';
                break;
        }

        this.setState({production});
    }

    render() {
        console.log('Index - render ');
        const {bill, production} = this.state;
        let comparison_price = (parseFloat(((39 / bill.monthly_consumption.value) * 100) + bill.price_per_kw_hour)).toFixed(2);


        return (
            <div className="bill-top-col">
                <div className="calculator">
                    <div className="calculator-header">
                        <h2 className="u-center-text u-grey-text">{production.svea_energy_price.bindingTime}</h2>
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


                        <Comparison />

                    </div>

                    <div className="calculator-footer">
                        <button className="btn-thin btn-success small">SE
                            JÄMFÖRELSEPRISER
                        </button>
                    </div>
                </div>
            </div>
        )
    }
}

/**
 * Get data from store
 * @param state
 */
const mapStateToProps = state => ({
    spot: state.spot,
});

/**
 * Import action from dir action above - but must be passed to connect method in order to trigger reducer in store
 * @type {{UserUpdate: UserUpdateAction}}
 */
const mapActionsToProps = {
};

export default withRouter(connect(mapStateToProps, mapActionsToProps)(Binding));
