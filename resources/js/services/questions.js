
import axios from "../axios";


export const getQuestionsListByCategory =
    function (scope) {
        return axios.get(`questions/list/bycategory/${scope}`);
    }



