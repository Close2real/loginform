import {atom} from "jotai";
import UserService from "@Services/UserService";
import {atomWithStorage, RESET} from "jotai/utils";
import User from "@Models/users";
import {ROLE_VALUES, ROLES} from "@Models/role";
import {loadingAtom} from "@Store/store";

export const initialUserState: User = {
    logged: false,
    username: "",
    role: ROLES.ANON,
    roles: []
}

export const userAtom = atomWithStorage<User>("user", initialUserState);

export const userRoleAtom = atom(
    (get) => get(userAtom).roles.find((userRoles: ROLE_VALUES) => userRoles !== ROLES.USER) ?? ROLES.ANON
);

export const loginAtom = atom(
    null,
    async (get, set, user: User) => {
        set(userAtom, user)
    }
)
export const logoutAtom = atom(
    null,
    async (get, set, arg) => {
        set(loadingAtom, true);
        await UserService.logout();
        set(userAtom, RESET);
    }
);