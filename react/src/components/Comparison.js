import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";


class Comparison extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            bill: {
                monthly_consumption: {value: 83, unit: 'kWh', display: 0},
                price_per_kw_hour: {value: 0, unit: 'öre'},

                spot_price: {value: 39.21, unit: 'öre'},
                spot_start: {value: 4.45, unit: 'öre'},
                el_certificate: {value: 4.45, unit: 'öre'},
                moms: {value: 0, unit: 'öre'},

                total: {value: 0, unit: 'öre'}
            },
            production: {
                monthly_production: {value: 204, unit: 'kWh', display: 0},
                price_per_kw_hour: {value: 0, unit: 'öre'},

                spot_price: {value: 41.34, unit: 'öre'},
                svea_energy_price: {value: 5, unit: 'öre', bindingTime: 'INGEN'},
                skatt_reduction: {value: 60, unit: 'öre'},
            },
        }
    }

    computeAll() {
        this.computeMoms();
        this.computePerKwHour('consumption');
    }

    componentWillMount() {
        this.setParams();
        this.computeAll();
    }

    componentDidMount() {
        console.log('Consumption - componentDidMount : spot', this.props.spot);
        if (!this.props.spot) return;
        const {spot} = this.props;
        const {bill} = this.state;
        bill.spot_price = {value: Number(spot.spot_price), unit: 'öre', zone: spot.zone};
        this.setState({bill});
        this.computeAll();
    }

    componentWillReceiveProps(nextProps, nextContext) {
        console.log('Consumption - componentWillReceiveProps : spot', nextProps.spot);
        if (!nextProps.spot) return;
        const {spot} = nextProps;
        const {bill} = this.state;
        bill.spot_price = {value: Number(spot.spot_price), unit: 'öre', zone: spot.zone};
        this.setState({bill});
        this.computeAll();
    }

    setParams() {
        const {search} = this.props.location; // ?cons=4000&prod=888&v=1 - divide by 12
        const params = search.split('&');
        console.log(params);
        const paramsArray = {};
        params.forEach(param => {
            let a = param.split('=');
            let key = a[0].replace('?', '');
            paramsArray[key] = a[1];
        });

        const {bill, production} = this.state;
        bill.monthly_consumption.value = (Number(paramsArray.cons) / 12);
        console.log('Rounding: ', paramsArray.cons, paramsArray.cons / 12);
        production.monthly_production.value = (Number(paramsArray.prod) / 12);
        bill.monthly_consumption.display = Math.round(bill.monthly_consumption.value - (0.65 * production.monthly_production.value));
        this.setState({bill, version: paramsArray.v, production});
    }

    computeMoms() {
        const {spot_price, spot_start, el_certificate} = this.state.bill;
        const moms = Number(((spot_price.value + spot_start.value + el_certificate.value) * 0.25).toFixed(2));
        const {bill} = this.state;
        bill.moms = moms;
        this.setState({bill});
    }

    computePerKwHour(type) {
        if (type === 'consumption') {
            let {spot_price, spot_start, el_certificate, moms} = this.state.bill;
            const {bill} = this.state;
            let price_per_kw_hour = (Number.parseFloat(spot_price.value + spot_start.value + el_certificate.value + moms)).toFixed(2);
            bill.price_per_kw_hour.value = price_per_kw_hour;
            this.setState({bill});
        }
    }

    render() {
        console.log('Index - render ');
        const {bill, production} = this.state;
        /*let total = (Number(bill.monthly_consumption.value) * Number(bill.price_per_kw_hour.value) * 0.100).toFixed(2);
        total = Math.ceil(total); */
        const total = bill.monthly_consumption ?
            Math.round(((bill.monthly_consumption.value - (production.monthly_production.value * 0.65)) * bill.price_per_kw_hour.value / 100) + 39)
            : 0;

        let comparison_price =  (parseFloat(bill.price_per_kw_hour.value + (0.39 / bill.monthly_consumption.value))).toFixed(2);

        return (
            <div className="item" style={{textAlign: 'center'}}>
                <p className="compare"> DITT JÄMFÖRELSE </p>
                <p className="small u-center-text"> PRIS </p>
                <span className="price u-center-text">{comparison_price} / KwH</span>
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

export default withRouter(connect(mapStateToProps, mapActionsToProps)(Comparison));
