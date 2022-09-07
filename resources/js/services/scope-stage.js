
import axios from "../axios";

export const getStagesByScope =
    function () {
        return axios.get("scope-stages/list/byscope");
    }


