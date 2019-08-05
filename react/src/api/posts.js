import axios from 'axios';
import {apiServer} from '../common/constants';

const endPoint = '/api/v1/posts';
const server = apiServer + endPoint;

export default {
    posts: {
        read: () =>
            axios.get(server).then(res => res.data).catch(error => {
                throw new Error(error);
                console.dir(error);
            }),
        add: (post) =>
            axios.post(server, post).then(res => res.data).catch(error => {
                throw new Error(error);
                console.dir(error);
            }),
        delete: (post) =>
            axios.delete(server + '/' +  post._id).then(res => res.data).catch(error => {
                throw new Error(error);
                console.dir(error);
            })
    }
}
