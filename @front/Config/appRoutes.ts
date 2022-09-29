import {ROLE_VALUES, ROLES} from "@Utils/models/role";
import {Location, Params} from "react-router-dom";

export enum ROUTES {
    LOGIN = "/login",
    USERS_VIEW = "/users/:ndg",
}

export type ROUTE_KEYS = keyof typeof ROUTES;
type ROUTES_PATHS = Record<ROUTES, string>;
type ROUTES_PATHS_KEYS = keyof ROUTES_PATHS;

export interface LayoutProps {
    showHeaderMenu: boolean;
}

export type AppRoutes =
    { path: ROUTES.LOGIN }
    | { path: ROUTES.USERS_VIEW, params: { ndg: string } }

export type DynamicAppRoute = Extract<AppRoutes, { path: string; params: any }>;

export interface AppRoute {
    key: ROUTE_KEYS;
    path: ROUTES_PATHS_KEYS;
    layoutProps?: LayoutProps;
    role: ROLE_VALUES[];
}

export const APP_ROUTES: AppRoute[] = [
    {
        key: "LOGIN",
        path: ROUTES.LOGIN,
        role: [ROLES.ANON],
        layoutProps: {
            showHeaderMenu: false,
        }
    }
];

const getRoutePath = (location: Location, params: Params): string => {
    const {pathname} = location;

    if (!params || !Object.keys(params).length) {
        return pathname;
    }
    let path = pathname;
    Object.entries(params).forEach(([paramName, paramValue]) => {
        if (paramValue) {
            path = path.replace(paramValue, `:${paramName}`);
        }
    });
    return path;
};

const getMatchedRoute = (path: string): AppRoute => {

    const matchedRoute = APP_ROUTES.find(r => r.path === path);

    if (matchedRoute) {
        return matchedRoute;
    }

    // const notFoundRoute = APP_ROUTES.find(r => r.key === "NOT_FOUND");

    // if (notFoundRoute) {
    //     return notFoundRoute;
    // }

    throw new Error(`No matching route and no 404 route found`);
}

export const getMatchedRouteByLocation = (location: Location, params: Params): AppRoute => {

    const path = getRoutePath(location, params);

    return getMatchedRoute(path);
}

export const getMatchedRouteByPathname = (pathname: string): AppRoute => {

    return getMatchedRoute(pathname);

}


