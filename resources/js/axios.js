import axios from "axios";
import router from './router';
import store from './vuex';

// axios.interceptors.request.use(
//     (config) => {
//         let token = localStorage.getItem('token');
//         if (token) {
//             config.headers['Authorization'] = 'Bearer ' + token;
//         }
//         config.headers['Accept'] = 'application/json';

//         return config;
//     },

//     (error) => {
//         return Promise.reject(error);
//     }
// );

// axios.interceptors.response.use(function (response) {
//     return response
// }, function (error) {
//     debugger
//     if (error.response.status === 401) {
//         store.dispatch('logout')
//         router.push('/')
//     }
//     return Promise.reject(error)
// })

axios.defaults.baseURL = "/api/"; // change this if you want to use a different url for APIs
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
window.axiosHeaders = {
    Authorization: 'Bearer ' + localStorage.getItem('token'),
};

window.setAuthToken = function () {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
    window.axiosHeaders = {
        Authorization: 'Bearer ' + localStorage.getItem('token'),
    }
};

export default axios;  