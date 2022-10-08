import axios from "../axios";

export const stageUpdate =
    function (data) {
        return axios.post(`projects/stage-update`, data);
    }



