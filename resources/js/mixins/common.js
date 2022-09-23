import axios from './../axios';
import store from './../vuex';

export default {
    methods: {
        async callApi(method, url, dataObj, headers = null, responseType = null) {
            try {
                let configObject = {
                    method: method,
                    url: url,
                    data: dataObj,
                };
                if (headers) {
                    configObject.headers = headers
                }
                if (responseType) {
                    configObject.responseType = responseType
                }
                return await axios(configObject);
            } catch (e) {
                return e.response;
            }
        },
        isAdmin() {
            if (store.state.user && store.state.user.role == 'admin') {
                return true;
            }
            return false;
        },
        isPartner() {
            if (store.state.user && store.state.user.role == 'partner') {
                return true;
            }
            return false;
        },
        getScopes() {
            return this.callApi('get', 'scopes');
        },
    },
}