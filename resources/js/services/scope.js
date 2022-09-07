
import axios from "./../axios";

export const getScopesBySlug =
    function () {
        return axios.get("scopes/list/byslug");
    }


