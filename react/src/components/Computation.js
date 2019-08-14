class Computation {

    constructor() {
        const consumption = {
            monthly_consumption: {value: 83, unit: 'kWh'},
            price_per_kw_hour: {value: 0, unit: 'öre'},
            spot_price: {value: 39.21, unit: 'öre'},
            spot_start: {value: 4.45, unit: 'öre'},
            el_certificate: {value: 4.45, unit: 'öre'},
            moms: {value: 0, unit: 'öre'},
            total: {value: 0, unit: 'öre'}
        };

        const production = {
            monthly_consumption: {value: 83, unit: 'kWh'},
            price_per_kw_hour: {value: 0, unit: 'öre'},
            spot_price: {value: 39.21, unit: 'öre'},
            spot_start: {value: 4.45, unit: 'öre'},
            el_certificate: {value: 4.45, unit: 'öre'},
            moms: {value: 0, unit: 'öre'},
            total: {value: 0, unit: 'öre'}
        };

        console.log(consumption, production);
    }
}

export default Computation;