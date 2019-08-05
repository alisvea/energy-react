import { VIDEO_SEARCH_SUCCESS } from '../types/Video';

const initState = [];

const SearchReducer = (state = initState, action = {}) => {
    switch (action.type) {
        case VIDEO_SEARCH_SUCCESS:
            console.log('Inside VideoReducer', action.payload);
            return action.payload.result;

        default:
            return state;
    }
};

export default SearchReducer;
