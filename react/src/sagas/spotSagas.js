import {call, put} from 'redux-saga/effects';
import api from '../api/spot';
import {
    spotReadAction,
    spotReadSuccessAction,
    spotReadFailAction,
} from "../actions/SpotAction";

export function* spotReadSaga(action) {
    try {
        const resp = yield call(api.spot.read, action.payload);
        console.log('spotReadSaga', resp);

        if (Array.isArray(Object.keys(resp))) {
            console.log('Inside spotReadSaga', action, resp);
            yield put(spotReadSuccessAction(resp));
        } else {
            yield put(spotReadFailAction(resp));
        }
    } catch (err) {
        yield put(spotReadFailAction(err));
    }
}

