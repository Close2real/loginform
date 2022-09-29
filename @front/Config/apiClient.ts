import axios from "axios";
import ApiClientException from "../Utils/exceptions/ApiClientException";

const apiClient = axios.create({
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        "Access-Control-Allow-Origin": "*",
        "Content-type": "application/json",
    }
});

apiClient.interceptors.request.use((config) => {

    return config;

}, () => new ApiClientException("Api client configuration error"));

apiClient.interceptors.response.use(response => response, (error) => {
    throw error;
});

export default apiClient;