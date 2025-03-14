import axios from "axios"

const BASE_URL = "http://localhost:3000/"

export const request = (method, route, data) => {
    const url = `${BASE_URL}${route}`
    return axios.request({ method, url, data })
        .then((response) => {
            console.log("Success:", response.data);
            return response.data
        })
        .catch((error) => {
            console.error("Error:", error);
            throw error
        })
};