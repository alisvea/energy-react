import axios from 'axios';
import {apiServer} from '../common/constants';

const endPoint = '/api/v1/shows';
const server = apiServer + endPoint;

export default {
    video: {
        read: () =>
            axios.get(server).then(res => res.data).catch(error => {
                throw new Error(error);
                console.dir(error);
            }),
        add: (show) =>
            axios.post(server, show).then(res => res.data).catch(error => {
                throw new Error(error);
                console.dir(error);
            }),
        delete: (show) =>
            axios.delete(server + '/' + show._id).then(res => res.data).catch(error => {
                throw new Error(error);
                console.dir(error);
            }),
        update: async (show) => {
            console.log('Inside axios put ,' , show);
            await axios.put(server + '/' + show.id, show.formData).then(res => {console.log('Update response: ', res); return res.data; }).catch(error => {
                throw new Error(error);
                console.dir(error);
            })
        }
    }
}
