import React from "react";

export interface FormFieldProps {
    label?: string;
    labelFor?: string;
    labelHint?: string;
    errorMessage?: string;
}

const FormField: React.FC<FormFieldProps> = ({label, labelFor, labelHint, errorMessage, children}) => {

    return (

        <div className="form__field">
            {label && <label htmlFor={labelFor} className="form__label">{label}
                {labelHint && <span className={"form__label--hint"} dangerouslySetInnerHTML={{ __html: labelHint }}/>}
            </label>}
            {children}
            {errorMessage && <div className={"form__error"}>{errorMessage}</div>}
        </div>

    );

}

export default FormField;