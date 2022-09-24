
import axios from "./../axios";

export const uploadFile =
    function (formdata) {
        return axios.post("uploads/file", formdata, {
            headers: {
                "Content-Type": "multipart/form-data",
            }
        });
    }


