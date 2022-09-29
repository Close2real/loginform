import {ROLE_VALUES} from "@Models/role";

export default interface User {
    logged: boolean;
    username: string;
    firstName?: string;
    lastName?: string;
    role: ROLE_VALUES;
    roles: ROLE_VALUES[];
}

/**
 * request
 */
export interface LoginParameters {
    username: string;
    password: string;
}