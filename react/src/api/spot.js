import axios from 'axios';
import {apiServer} from '../common/constants';

const endPoint = '/v2/calculator/api/?zone=';
const server = apiServer + endPoint;

export default {
    spot: {
        read: (zone) =>
            axios.get(server + zone.zone).then(res => res.data).catch(error => {
                throw new Error(error);
                console.dir(error);
            })
    }
}
