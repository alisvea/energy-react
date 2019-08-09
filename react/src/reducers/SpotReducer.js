import { SPOTPRICE_READ_SUCCESS } from '../types/Spot';

const initState = {
    spot : {
        zone: 'na',
        spot_price: 0
    }
};

const SpotReducer = (state = initState, action = {}) => {
    switch (action.type) {
        case SPOTPRICE_READ_SUCCESS:
            console.log('Inside SpotReducer', action.payload);
            return action.payload;
        default:
            return state;
    }
};

export default SpotReducer;
