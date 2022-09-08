
import axios from "../axios";

export const getQuestionCategories =
    function () {
        return axios.get("question/categories/list");
    }

export const getAllQuestionCategories =
    function () {
        return axios.get("question/categories");
    }

