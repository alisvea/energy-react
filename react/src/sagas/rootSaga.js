import {POSTS_ADD, POSTS_DELETE, POSTS_READ} from "../types/Posts";
import {VIDEO_ADD, VIDEO_DELETE, VIDEO_READ, VIDEO_SEARCH, VIDEO_UPDATE} from "../types/Video";

import {takeLatest, takeEvery} from 'redux-saga/effects';

import {postsReadSaga, postsAddSaga, postsDeleteSaga} from "./postsSagas";
import {videoReadSaga, videoAddSaga, videoDeleteSaga, videoUpdateSaga} from "./videoSagas";
import {videoSearchSaga} from "./searchSagas";


export default function* rootSaga() {
    yield takeLatest(POSTS_READ, postsReadSaga);
    yield takeLatest(POSTS_ADD, postsAddSaga);
    yield takeLatest(POSTS_DELETE, postsDeleteSaga);

    yield takeLatest(VIDEO_ADD, videoAddSaga);
    yield takeLatest(VIDEO_READ, videoReadSaga);
    yield takeLatest(VIDEO_DELETE, videoDeleteSaga);
    yield takeEvery(VIDEO_UPDATE, videoUpdateSaga);

    yield takeLatest(VIDEO_SEARCH, videoSearchSaga);
}
