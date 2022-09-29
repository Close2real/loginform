import {ObjectShape} from "yup/lib/object";

export interface SubmitError {
    message?: string;
    response: any;
}

export interface HookError extends SubmitError {

}

export type ObjectShapeValues = ObjectShape extends Record<string, infer V> ? V : never
export type YupSchemaShape<T extends Record<any, any>> = Partial<Record<keyof T, ObjectShapeValues>>

