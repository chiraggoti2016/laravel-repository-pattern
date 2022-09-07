
import axios from "./../axios";

export const getCountries =
    function () {
        return axios.get("countries/list");
    }

export const getAllCountries =
    function () {
        return axios.get("countries");
    }



