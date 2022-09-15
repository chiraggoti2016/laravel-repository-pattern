
import axios from "../axios";


export const getQuestionsListByCategory =
    function (scope, params) {
        return axios.post(`questions/list/bycategory/${scope}`, params);
    }



