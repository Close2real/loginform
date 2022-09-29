import {Pagination} from "@Models/response";

export const CONFIG = {
    PAGINATION_PER_PAGE: 10,
    PAGINATION_INFINITE: 999999,
    GENERIC_TICKET_USERNAME: "bmed_generic_ticket"
};

export const DEFAULT_PAGINATION: Pagination = {
    page: 1,
    pageElements: CONFIG.PAGINATION_PER_PAGE,
    totalPage: 0,
    totalElements: 0
};

export const CUSTOM_CODES = {
    BAD_REQUEST: 400,
    NOT_FOUND: 404,
    FORM_VALIDATION_ERROR_CODE: 499,
    NO_SERVICE_RESPONSE: 999,
    NO_SERVICE_RESPONSE_CODE: 998
}

export enum MESSAGES {
    "GENERIC_ERROR" = "Si è verificato un errore, riprovare."
}
