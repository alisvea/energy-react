import {call, put} from 'redux-saga/effects';
import api from '../api/spot';
import {
    postsReadAction,
    postsReadSuccessAction,
    postsReadFailAction,
    postsAddSuccessAction,
    postsAddFailAction, postsDeleteSuccessAction, postsDeleteFailAction,
} from "../actions/PostsAction";

export function* postsReadSaga(action) {
    try {
        const resp = yield call(api.posts.read, action.payload);

        if (Array.isArray(resp)) {
            console.log('Inside interestingReadSaga', action, resp);
            yield put(postsReadSuccessAction(resp));
        } else {
            yield put(postsReadFailAction(resp));
        }
    } catch (err) {
        yield put(postsReadFailAction(err));
    }
}

export function* postsAddSaga(action) {
    console.log('Inside postsAddSaga ', action);
    try {
        const resp = yield call(api.posts.add, action.payload.post);

        if (Array.isArray(Object.keys(resp))) {
            console.log('Inside postsAddSaga isArray', action, resp);
            yield put(postsAddSuccessAction(resp));
            yield put(postsReadAction());
        } else {
            yield put(postsAddFailAction(resp));
        }
    } catch (err) {
        yield put(postsAddFailAction(err));
    }
}


export function* postsDeleteSaga(action) {
    console.log('Inside postsDeleteSaga ', action);
    try {
        const resp = yield call(api.posts.delete, action.payload.post);

        if (Array.isArray(Object.keys(resp))) {
            console.log('Inside postsAddSaga isArray', action, resp);
            yield put(postsDeleteSuccessAction(resp));
            yield put(postsReadAction());
        } else {
            yield put(postsDeleteFailAction(resp));
        }
    } catch (err) {
        yield put(postsDeleteFailAction(err));
    }
}
