import {
    SPOTPRICE_READ,
    SPOTPRICE_READ_SUCCESS,
    SPOTPRICE_READ_FAIL,
} from '../types/Spot';

export const spotReadAction = (zone) => {
    console.log('Inside spotReadAction');
    return {
        type: SPOTPRICE_READ,
        payload: {
            zone
        }
    }
};

export const spotReadSuccessAction = (spot) => {
    console.log('Inside spotReadSuccessAction');
    return {
        type: SPOTPRICE_READ_SUCCESS,
        payload: spot
    }
};

export const spotReadFailAction = (err) => {
    console.log('Inside spotReadFailAction');
    console.log(err);
    return {
        type: SPOTPRICE_READ_FAIL,
        payload: {err}
    }
};

