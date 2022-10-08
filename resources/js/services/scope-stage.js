
import axios from "../axios";

export const getStagesByScope =
    function () {
        return axios.get("scope-stages/list/byscope");
    }


export const getStagesByScopeProject =
    function (project_id) {
        return axios.get(`scope-stages/list/byscope/${project_id}`);
    }


