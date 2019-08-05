import axios from 'axios';
import {apiServer} from '../common/constants';

const endPoint = '/api/v1/search';
const server = apiServer + endPoint;

export default {
    show: {
        search: (str) =>
            axios.get(server + '/' + str.str).then(res => res.data).catch(error => {
                throw new Error(error);
                console.dir(error);
            })
    }
}
