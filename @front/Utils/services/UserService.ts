import ApiService from "./ApiService";
import User, {LoginParameters} from "@Models/users";
import ApiRouter from "@Config/apiRouter";
import {ApiResponse} from "@Models/response";

type UserApiRoutes = "login" | "logout" | "user" | "bmedUsers" | "bmedUserBalance" | "bmedUserCapabilities" | "bmedIwUserBets" | "resendVoucher";

class UserService extends ApiService {

    private static routes: Record<UserApiRoutes, string> = {
        login: "app.login",
        logout: "app.logout",
        user: "api.logged_user",
        bmedUsers: "api.users.search",
        bmedUserBalance: "api.users.bmed_user_balance",
        bmedUserCapabilities: "api.users.bmed_capabilities_user",
        bmedIwUserBets: "api.users.bmed_bets_user",
        resendVoucher: "api.users.resend.voucher"
    };

    static login = async (params: LoginParameters): Promise<User> => {

        const url = ApiRouter.generate(this.routes.login);

        const response = await this.post<ApiResponse<User>>(url, params);

        const user: User = this.parseResponse<User>(response);

        user.logged = true;

        return user;
    };


    static logout = async (): Promise<any> => {

        const url = ApiRouter.generate(this.routes.logout);

        const response = await this.post<ApiResponse<User>>(url);

        console.log("UserService.logout done, returning");

        return this.parseResponse<any>(response);
    };
}

export default UserService;