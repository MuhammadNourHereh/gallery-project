import axios from "axios"

export const BASE_URL = "http://localhost:3000/gallery-server/"

export const request = (method, route, data, params) => {
    const url = `${BASE_URL}${route}`
    return axios.request({ method, url, data, params })
        .then((response) => {
            console.log("Success:", response.data);
            return response.data
        })
        .catch((error) => {
            console.error("Error:", error);
            throw error
        })
};