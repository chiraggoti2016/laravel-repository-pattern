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

axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    if (error.response.status === 401 || error.response.status === 500) {
        localStorage.removeItem("token");
        store.dispatch("user", null);
        router.push('/')
    }
    return Promise.reject(error)
})

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

console.log("$.fn.dataTable", $.fn)
// $.fn.dataTable.ext.errMode = 'none';

export default axios;  