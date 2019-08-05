import {call, put} from 'redux-saga/effects';
import api from '../api/search';
import {
    videoSearchSuccessAction, videoSearchFailAction,
} from "../actions/VideoAction";

export function* videoSearchSaga(action) {
    try {
        const resp = yield call(api.show.search, action.payload);

        if (Array.isArray(resp)) {
            console.log('Inside interestingReadSaga', action, resp);
            yield put(videoSearchSuccessAction(resp));
        } else {
            yield put(videoSearchFailAction(resp));
        }
    } catch (err) {
        yield put(videoSearchFailAction(err));
    }
}
