import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";


class Production extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            production: {
                monthly_production: {value: 204, unit: 'kWh', display: ''},
                price_per_kw_hour: {value: 0, unit: 'öre'},

                spot_price: {value: 41.34, unit: 'öre'},
                svea_energy_price: {value: 5, unit: 'öre', bindingTime: 'INGEN'},
                skatt_reduction: {value: 60, unit: 'öre'},
            },
        }
    }

    componentWillMount() {
        //this.getSpotPrice('SE1');
        // console.log('Index - componentWillMount');
        this.setParams();
        this.computeAll();
    }

    componentDidMount() {
        console.log('Production - componentDidMount : spot', this.props.spot);
        if (!this.props.spot) return;
        const {spot} = this.props;
        const {production} = this.state;
        production.spot_price = {value: Number(spot.spot_price), unit: 'öre', zone: spot.zone};
        this.setState({production});
        this.computeAll();
    }

    componentWillReceiveProps(nextProps, nextContext) {
        console.log('Production - componentWillReceiveProps : spot', nextProps.spot);
        if (!nextProps.spot) return;
        const {spot} = nextProps;
        const {production} = this.state;
        production.spot_price.value = Number(spot.spot_price);
        this.setState({production});
        this.computeAll();
        this.setVersion(nextProps);
    }

    computeAll() {
        this.computePerKwHour('production');
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
        production.monthly_production.value = (Number(paramsArray.prod) / 12);
        production.monthly_production.display = Math.round(production.monthly_production.value * 0.35);
        console.log(paramsArray);
        this.setState({bill, production, version: paramsArray.v});

        // Set the price for
        // 1 - SVEA Energy
        // 2 - Bindningstid
        this.setVersion();
    }


    setVersion(nextProps) {
        const props = nextProps ? nextProps : this.props;
        const {pathname} = props.location;
        const {production} = this.state;

        // There are four version for the svea energy price - based on the uri part as follows
        // 1 - byt-elavtal    2 - erbjudande20   3 - employee-discount   4 - erbjudande19
        const uri = pathname ? pathname.replace(/\//g, '') : '/byt-elavtal2';

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

    computePerKwHour(type) {
        if (type === 'production') {
            let {production} = this.state;
            let price_per_kw_hour = Number(production.spot_price.value) + production.svea_energy_price.value + production.skatt_reduction.value;
            production.price_per_kw_hour.value = price_per_kw_hour;
            this.setState({production});
        }
    }

    render() {
        console.log('Index - render ');
        const {production} = this.state;
        /*let total = (Number(production.monthly_production.value) * Number(production.price_per_kw_hour.value) * 0.100).toFixed(2);
        total = Math.ceil(total); */
        const total = production.monthly_production ? Math.round(production.monthly_production.value * 0.35 *
            production.price_per_kw_hour.value / 100) : 0;


        return (
            <div className="bill-top-col">
                <div className="calculator">
                    <div className="calculator-header">
                        <h2 className="u-center-text u-grey-text">RÖRLIGT</h2>
                        <p className="heading u-grey-text u-center-text">PRODUKTIONSAVTAL</p>
                    </div>

                    <div className="calculator-content" style={{minHeight: '480px'}}>

                        <div className="item">
                            <p className="title">Uppskattad Månadsproduktion</p>
                            <span className="price">
                                                                {production.monthly_production.display} {production.monthly_production.unit}
                                                            </span>
                        </div>

                        <div className="item" style={{marginBottom: '12px'}}>
                            <p className="title"> Pris per kilowattimme </p>
                            <span
                                className="price line bolder">{production.price_per_kw_hour.value} öre</span>
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
                                  style={{paddingBottom: '146px'}}>
                                                                {production.skatt_reduction.value} {production.skatt_reduction.unit}
                                                            </span>
                        </div>

                    </div>

                    <div className="calculator-footer">
                        <div className="total">
                            <p className="total-price">{total} kr / månad</p>
                            <p className="total-text">
                                *Det rörliga elpriset/spotpriser andras hela tiden och
                                följer
                                nordiska elbörsen (nordpool).
                                Elcertifikatskostnaden varierar måndasvis.
                            </p>
                        </div>
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
const mapActionsToProps = {};

export default withRouter(connect(mapStateToProps, mapActionsToProps)(Production));
