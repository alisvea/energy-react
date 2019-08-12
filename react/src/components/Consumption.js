import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";


class Consumption extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            bill: {
                monthly_consumption: {value: 83, unit: 'kWh'},
                price_per_kw_hour: {value: 0, unit: 'öre'},

                spot_price: {value: 39.21, unit: 'öre'},
                spot_start: {value: 4.45, unit: 'öre'},
                el_certificate: {value: 4.45, unit: 'öre'},
                moms: {value: 0, unit: 'öre'},

                total: {value: 0, unit: 'öre'}
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
        const {search} = this.props.location; // ?cons=4000&prod=888&v=1
        const params = search.split('&');
        console.log(params);
        const paramsArray = {};
        params.forEach(param => {
            let a = param.split('=');
            let key = a[0].replace('?', '');
            paramsArray[key] = a[1];
        });

        const {bill} = this.state;
        bill.monthly_consumption.value = paramsArray.cons;
        console.log(paramsArray);
        this.setState({bill, version: paramsArray.v});
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
        const {bill} = this.state;
        const total =  Number(bill.monthly_consumption.value) * Number(bill.price_per_kw_hour.value) * 0.100;

        console.log('bill.monthly_consumption.value', bill.monthly_consumption.value);
        console.log('bill.price_per_kw_hour.value', bill.price_per_kw_hour.value);


        return (
            <div className="calculator">
                <div className="calculator-header">
                    <h2 className="u-center-text u-grey-text">RÖRLIGT</h2>
                    <p className="heading u-grey-text u-center-text">FÖRBRUKNINGSAVTAL</p>
                </div>

                <div className="calculator-content" style={{borderRight: this.props.contentBorderRight === false ? 'none' : '1px solid #d3d3d3'}}>

                    <div className="item">
                        <p className="title">Uppskattad Måndasförbrukning</p>
                        <span className="price">
                                                                {bill.monthly_consumption.value} {bill.monthly_consumption.unit}
                                                            </span>
                    </div>

                    <div className="item" style={{marginBottom: '12px'}}>
                        <p className="title"> Pris per kilowattimme </p>
                        <span className="price line bolder">
                                                                {bill.price_per_kw_hour.value} öre
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
                        <p className="total-price">{total} kr / månad</p>
                        <p className="total-text">
                            *Det rorliga elpriset/spotpriser andras hela tiden och
                            följer
                            nordiska elbörsen (nordpool).
                            Elcertifikatskostnaden varierar måndasvis.
                        </p>
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

export default withRouter(connect(mapStateToProps, mapActionsToProps)(Consumption));
