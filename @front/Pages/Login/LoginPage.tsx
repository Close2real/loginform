import React, {useCallback, useState} from "react";
import FormRow from "../../Components/Form/FormRow";
import FormField from "../../Components/Form/FormField";
import {useForm} from "react-hook-form";
import {useSetAtom} from "jotai";
import UserService from "@Services/UserService";

interface LoginForm {
    username: string;
    password: string;
}

// const loginDisplayableErrorCodes: ErrorToastErrorCodes = [CUSTOM_CODES.NOT_FOUND, CUSTOM_CODES.FORM_VALIDATION_ERROR_CODE];

const LoginPage: React.FC = () => {

    // const setLogin = useSetAtom(loginAtom);

    // const [errorResponse, setErrorResponse] = useState<SubmitError | null>(null);
    // useErrorToast(errorResponse, loginDisplayableErrorCodes);

    const {register, handleSubmit, formState: {errors}} = useForm<LoginForm>({
        // resolver: yupResolver(LoginFormValidationSchema)
    });

    const submit = useCallback( async(formState: LoginForm) => {

        try {

            // setErrorResponse(null);
            // setLoading(true);
            await UserService.login(formState);
            // await setLogin(await UserService.login(formState));
            // Util.redirect(Util.generatePath({
            //     path: ROUTES.HOME
            // }));

        } catch (ex) {
            console.log(ex);
            // setLoading(false);
            // setErrorResponse(Util.serviceExceptionToState(ex));

        }

    }, []);

    return (
        <div className={`content size--smaller login-page-content`}>
            <form className="form" onSubmit={handleSubmit(submit)}>
                <FormRow>
                    <FormField label={"Username"} labelFor={"username"}>
                        <input id={"username"} className={"form__input"}
                               placeholder={"Username"} {...register("username")} />
                    </FormField>
                </FormRow>

                <FormRow>
                    <FormField label={"Password"} labelFor={"password"}>
                        <input type={"password"} id={"password"} className={"form__input"}
                               placeholder={"Password"} {...register("password")} />
                    </FormField>
                </FormRow>

                <div className="flex flex-center form__section form__actions">
                    <button className="btn btn--big" type={"submit"}>Login</button>
                </div>
            </form>
        </div>
    );
}

export default LoginPage;