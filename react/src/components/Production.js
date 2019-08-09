import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";


class Production extends React.Component {
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

    componentWillMount() {
        //this.getSpotPrice('SE1');
        // console.log('Index - componentWillMount');
        this.setParams();
        this.computeAll();
    }

    componentDidMount() {
        console.log('Production - componentDidMount : spot', this.props.spot);
        if( ! this.props.spot) return;
        const { spot } = this.props;
        const {bill, production} = this.state;
        bill.spot_price = {value: Number(spot.spot_price), unit: 'öre', zone: spot.zone};
        production.spot_price.value = Number(spot.spot_price);
        this.setState({bill, production});
        this.computeAll();
    }

    componentWillReceiveProps(nextProps, nextContext) {
        console.log('Production - componentWillReceiveProps : spot', nextProps.spot);
        if( ! nextProps.spot) return;
        const { spot } = nextProps;
        const {bill, production} = this.state;
        bill.spot_price = {value: Number(spot.spot_price), unit: 'öre', zone: spot.zone};
        production.spot_price.value = Number(spot.spot_price);
        this.setState({bill, production});
        this.computeAll();
    }

    computeAll() {
        this.computeMoms();
        this.computePerKwHour('consumption');
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

export default withRouter(connect(mapStateToProps, mapActionsToProps)(Production));
