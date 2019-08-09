import {SPOTPRICE_READ} from "../types/Spot";

import {takeLatest, takeEvery} from 'redux-saga/effects';

import {spotReadSaga} from "./spotSagas";


export default function* rootSaga() {
    yield takeLatest(SPOTPRICE_READ, spotReadSaga);
}
