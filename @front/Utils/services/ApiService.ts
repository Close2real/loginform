import apiClient from "@Config/apiClient";
import axios from "axios";
import {ApiResponse} from "@Models/response";
import ApiErrorResponse from "@Utils/exceptions/ApiErrorResponse";
import ApiClientException from "@Utils/exceptions/ApiClientException";
import Util from "@Utils/Util";
import {CUSTOM_CODES} from "@Config/config";

const CUSTOM_SUCCESS_ERROR_CODES = [200, 201];

class ApiService {

    protected static get = async <T>(url: string): Promise<T> => {

        try {

            const apiResponse = await apiClient.get<T>(url);

            return apiResponse.data;

        } catch (ex) {

            throw this.createApiErrorException(ex);

        }

    };

    protected static post = async <T>(url: string, data?: object|FormData): Promise<T> => {

        try {

            const payload = data instanceof FormData ? data : Util.objectToFormData(data);

            const apiResponse = await apiClient.post<T>(url, payload);

            return apiResponse.data;

        } catch (ex) {

            throw this.createApiErrorException(ex);

        }

    };

    protected static put = async <T>(url: string, data?: any): Promise<T> => {

        try {

            const apiResponse = await apiClient.put<T>(url, data);

            return apiResponse.data;

        } catch (ex) {

            throw this.createApiErrorException(ex);

        }

    };

    protected static patch = async <T>(url: string, data?: any): Promise<T> => {

        try {

            const apiResponse = await apiClient.patch<T>(url, data);

            return apiResponse.data;

        } catch (ex) {

            throw this.createApiErrorException(ex);

        }

    };

    protected static delete = async <T>(url: string, data?: any): Promise<T> => {

        try {

            const apiResponse = await apiClient.delete<T>(url, data);

            return apiResponse.data;

        } catch (ex) {

            throw this.createApiErrorException(ex);

        }

    };

    protected static parseResponse = <T>(response: ApiResponse<T>): T => {

        if (!response) {
            throw new ApiErrorResponse("No api response", CUSTOM_CODES.NO_SERVICE_RESPONSE);
        }

        if (!response.code) {
            throw new ApiErrorResponse("No api response code", CUSTOM_CODES.NO_SERVICE_RESPONSE_CODE);
        }

        if (!CUSTOM_SUCCESS_ERROR_CODES.includes(response.code)) {
            throw new ApiErrorResponse(response.errorMessage || "Code exception", response.code);
        }

        return response.data;
    }

    private static createApiErrorException = (ex: any): ApiErrorResponse | ApiClientException | any => {

        if (axios.isAxiosError(ex)) {

            if (ex.response?.data && this.isApiError(ex.response?.data)) {
                return new ApiErrorResponse(ex.response.data.errorMessage, ex.response.data.code, ex.response.data.data);
            }

            return new ApiClientException(ex.message, ex?.response?.status);
        }

        return ex;

    };

    private static isApiError = (data: any): boolean => {

        return 'code' in data && data.code !== 200 && 'hasError' in data && data.hasError;

    }
}

export default ApiService;