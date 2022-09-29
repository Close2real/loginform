import React from "react";

export interface FormRowProps {
    multiple?: boolean;
}

const FormRow: React.FC<FormRowProps> = ({multiple, children}) => {

    return <div className={`form__row`}>{children}</div>

}

export default FormRow;