import {
    POSTS_READ,
    POSTS_READ_SUCCESS,
    POSTS_READ_FAIL,
    POSTS_ADD,
    POSTS_ADD_SUCCESS,
    POSTS_ADD_FAIL, POSTS_DELETE, POSTS_DELETE_SUCCESS, POSTS_DELETE_FAIL
} from '../types/Posts';

export const postsReadAction = () => {
    console.log('Inside postsReadAction');
    return {
        type: POSTS_READ,
        payload: {}
    }
};

export const postsReadSuccessAction = (science) => {
    return {
        type: POSTS_READ_SUCCESS,
        payload: {
            science
        }
    }
};

export const postsReadFailAction = (err) => {
    console.log(err);
    return {
        type: POSTS_READ_FAIL,
        payload: {err}
    }
};


export const postsAddAction = (post) => {
    console.log('Inside postsAddAction', post);
    return {
        type: POSTS_ADD,
        payload: {
            post
        }
    }
};

export const postsAddSuccessAction = (science) => {
    return {
        type: POSTS_ADD_SUCCESS,
        payload: {
            science
        }
    }
};

export const postsAddFailAction = (err) => {
    console.log(err);
    return {
        type: POSTS_ADD_FAIL,
        payload: {err}
    }
};



export const postsDeleteAction = (post) => {
    console.log('Inside postsAddAction', post);
    return {
        type: POSTS_DELETE,
        payload: {
            post
        }
    }
};

export const postsDeleteSuccessAction = (science) => {
    return {
        type: POSTS_DELETE_SUCCESS,
        payload: {
            science
        }
    }
};

export const postsDeleteFailAction = (err) => {
    console.log(err);
    return {
        type: POSTS_DELETE_FAIL,
        payload: {err}
    }
};

