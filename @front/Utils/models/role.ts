export enum ROLES {
    ADMIN = "ROLE_ADMIN",
    BMED = "ROLE_BMED",
    USER = "ROLE_USER",
    READ_ONLY = "ROLE_READ_ONLY",
    ANON = "ROLE_ANONYMOUS"
}

export enum ROLE_NAMES {
    ROLE_ADMIN = "Admin",
    ROLE_BMED = "Bmed",
    ROLE_USER = "Utente",
    READ_ONLY = 'Solo lettura',
    ROLE_ANONYMOUS = "Anonimo"
}

export const ROLE_HIERARCHY = {
    [ROLES.ADMIN]: [ROLES.ADMIN],
    [ROLES.BMED]: [ROLES.ADMIN, ROLES.BMED],
    [ROLES.USER]: [ROLES.ADMIN, ROLES.BMED, ROLES.USER, ROLES.READ_ONLY]
};

export type ROLE_KEYS = Lowercase<keyof typeof ROLES>;
export type ROLE_VALUES = keyof typeof ROLE_NAMES;