import React, {useEffect, useState} from "react";
import Util from "@Utils/Util";
import {getMatchedRouteByLocation, ROUTES} from "@Config/appRoutes";
import {useLocation, useNavigate, useParams} from "react-router-dom";
import {useAtomValue, useSetAtom} from "jotai";
import {loadingAtom} from "@Store/store";
import {logoutAtom, userAtom} from "@Store/userStore";

export interface RouteChecker {
    canAccess: boolean;
    redirectPath: string | null;
}

const ProtectedRoute: React.FC = ({children}) => {

    const navigate = useNavigate();

    const setIsLoading = useSetAtom(loadingAtom);
    const setLogout = useSetAtom(logoutAtom);
    const user = useAtomValue(userAtom);

    const location = useLocation();
    const params = useParams();

    const [checkFinished, setCheckFinished] = useState<boolean>(false);

    useEffect(() => {

        (async () => {

            try {

                const matchedRoute = getMatchedRouteByLocation(location, params);

                if (Util.isPublicRoute(matchedRoute)) {
                    setCheckFinished(true);
                    return;
                }

                setIsLoading(true);

                /**
                 * check this route roles
                 */
                const {redirectPath} = Util.checkRouteRoles(user, matchedRoute);

                if (redirectPath !== null) {
                    navigate(redirectPath);
                    return;
                }

                setCheckFinished(true);

            } catch (ex) {

                /**
                 * any exception -> logout
                 * redirect to login page
                 */
                await setLogout();
                navigate(Util.generatePath({
                    path: ROUTES.LOGIN
                }));

            } finally {
                setIsLoading(false);
            }

        })();

        return () => setCheckFinished(false);

    }, [location.pathname]);

    if (!checkFinished) {
        return null;
    }

    return <>{children}</>;
}

export default ProtectedRoute;