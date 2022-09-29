import {BrowserRouter, Route, Routes} from "react-router-dom";
import React from "react";
import {APP_ROUTES, ROUTE_KEYS} from "@Config/appRoutes";
import LoginPage from "./Pages/Login/LoginPage";

const PAGE_COMPONENTS: Record<ROUTE_KEYS, JSX.Element> = {
    LOGIN: <LoginPage/>,
    USERS_VIEW: <></>,
};

const Router = () => {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/">
                    {APP_ROUTES.map(route =>
                        <Route
                            key={route.key}
                            path={route.path}
                            element={PAGE_COMPONENTS[route.key]}/>
                    )}
                    <Route path={"*"}/>
                </Route>
            </Routes>
        </BrowserRouter>
    );

}

export default Router;
