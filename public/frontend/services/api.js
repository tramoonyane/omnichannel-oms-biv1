import { API_BASE_URL } from "../utils/constants.js";
import { getToken, clearAuth } from "../utils/storage.js";


async function request(
    endpoint,
    options = {}
) {

    const token = getToken();


    const config = {

        ...options,

        headers: {

            "Content-Type": "application/json",

            ...options.headers

        }

    };


    if (token) {

        config.headers.Authorization =
            `Bearer ${token}`;

    }


    const response = await fetch(
        `${API_BASE_URL}${endpoint}`,
        config
    );


    // Handle expired or invalid token first
    if (response.status === 401) {

        clearAuth();

        alert(
            "Your session has expired. Please log in again."
        );

        window.location.href =
            "../pages/login.html";

        return;

    }


    const data = await response.json();


    if (!response.ok) {

        throw new Error(

            data.message ||

            "API request failed"

        );

    }


    return data;

}



async function get(endpoint) {

    return request(
        endpoint,
        {
            method: "GET"
        }
    );

}



async function post(
    endpoint,
    body
) {

    return request(
        endpoint,
        {

            method: "POST",

            body: JSON.stringify(body)

        }
    );

}



async function put(
    endpoint,
    body
) {

    return request(
        endpoint,
        {

            method: "PUT",

            body: JSON.stringify(body)

        }
    );

}



async function remove(endpoint) {

    return request(
        endpoint,
        {

            method: "DELETE"

        }
    );

}



export default {

    get,

    post,

    put,

    delete: remove

};