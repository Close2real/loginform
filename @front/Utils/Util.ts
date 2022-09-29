import moment from 'moment';
import {AppRoute, AppRoutes, DynamicAppRoute, ROUTES} from "@Config/appRoutes";
import {ROLE_HIERARCHY, ROLE_NAMES, ROLE_VALUES, ROLES} from "@Models/role";
import {RouteChecker} from "../_ProtectedRoute";
import User from "@Models/users";
import ApiErrorResponse from "@Utils/exceptions/ApiErrorResponse";
import {MESSAGES} from "@Config/config";
import {SubmitError} from "@Models/misc";
// import {SlaLevels} from "@Components/Callcenter/TicketDetails/TicketDetails";

moment.locale('it');

/**
 * moment formats
 * https://momentjs.com/docs/#/parsing/string-format/
 */
export const DATE_FORMATS = {
    DATE_FORMAT_DEFAULT: "DD/MM/YYYY",
    DATETIME_FORMAT_DEFAULT: "DD/MM/YYYY HH:mm",
    DATE_FORMAT_VERBAL: "DD MMM, YYYY",
    DATETIME_FORMAT_VERBAL: "DD MMM, YYYY HH:mm",
    DATETIME_FORMAT_ISO: "YYYY-MM-DD HH:mm:ss",
    DATE_FORMAT_ISO: "YYYY-MM-DD",
}

export const ERRORS_CODE = {
    NOT_FOUND: 404
};

class Util {

    static readonly MATERIAL_TYPES = {
        DIGITAL: [2010, 2011, 2017, 2018, 2019],
        PHYSICAL: [2000]
    };

    public static sleep(ms: number) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    public static isEmptyObject = (obj: object | any): boolean => {

        return Object.keys(obj).length === 0 && obj.constructor === Object;

    }

    public static fullName = (f?: string, l?: string): string => {
        const fullName = (`${(f || '').toLowerCase()} ${(l || '').toLowerCase()}`).trim();
        return fullName !== "" ? fullName : "-";
    }

    public static displayRoleName = (roleKey: ROLE_VALUES): string => {
        return ROLE_NAMES[roleKey];
    }

    public static fullNameInitials = (fullName?: string) => {

        if (!fullName) {
            return "A";
        }

        return fullName.split(" ").reduce((prev, curr) => {
            prev += curr.charAt(0);
            return prev;
        }, "").toUpperCase();
    }

    public static randomIntegerInRange = (min: number = 0, max: number = 1000): number => {

        const minNr = Math.ceil(min);
        const maxNr = Math.floor(max);
        return Math.floor(Math.random() * (maxNr - minNr) + minNr);

    }

    public static isValidDate = (value: string): boolean => {

        if (!value || value === '')
            return false;

        const m = moment(value);

        return m.isValid();

    }

    public static constructDate = (value: string): Date | null => {

        if (!value || value === '')
            return null;

        return moment(value, 'YYYY-MM-DD HH:mm').toDate();

    }

    public static cdMacroList = (): object => {
        return {
            13764: 'ForYou Collection',
            13776: 'ForYou Win',
            13839: 'ForYou Benefit',
            /*            13765: 'ForYou Experience',*/
            13766: 'Presenta un amico',
            13932: 'Promo Selfy'
        };
    };

    public static checkCdMacro = (cdMacro: number): string => {

        const MacroSector = this.cdMacroList();

        return MacroSector[cdMacro] || '';
    };

    public static formatDate = (value?: string | Date, format: string = DATE_FORMATS.DATETIME_FORMAT_DEFAULT): string => {
        if (!value || value === '' || value === null)
            return '-';

        const m = moment(value);

        return m.isValid() ? m.format(format) : '-';

    }

    public static formatTimestamp = (value?: number, format: string = DATE_FORMATS.DATETIME_FORMAT_DEFAULT): string => {

        if (!value)
            return '-';

        const m = moment.unix(value);

        return m.isValid() ? m.format(format) : '-';

    };

    public static formatCurrency = (value?: number): string => {

        if (!value)
            return '0 €';

        const formatter = Intl.NumberFormat("it-IT", {
            style: 'currency',
            currency: 'EUR'
        });

        return formatter.format(value);

    };

    public static hasRole = (roleKey: ROLE_VALUES, user: User): boolean => {
        return user.role === roleKey;

    };

    public static hasMinimumRole = (roleKey: ROLE_VALUES, userRole: ROLE_VALUES): boolean => {
        return ROLE_HIERARCHY[roleKey].includes(userRole);
    };

    public static generatePath = (args: AppRoutes): string => {
        const basePath = args.path;

        if (!args.hasOwnProperty('params')) return basePath;

        const pathParams = Object.entries((args as DynamicAppRoute).params);

        return pathParams.reduce((previousValue: string, [param, value]) => {
            return previousValue.replace(`:${param}`, '' + value)
        }, basePath);
    }

    public static redirect = (path: string): void => {
        window.location.href = path;
        return;
    }

    public static openNewTab = async (path: string): Promise<void> => {

        window.open(path, "_blank")?.focus();

        return;

    }

    public static isPublicRoute = (matchedRoute: AppRoute): boolean => {
        const {role: routeRoles} = matchedRoute;

        return routeRoles.length === 1 && routeRoles.includes(ROLES.ANON);
    };

    public static checkRouteRoles = (user: User, matchedRoute: AppRoute): RouteChecker => {

        const {roles: userRoles, logged} = user;
        const {role: routeRoles} = matchedRoute;

        /**
         * public route, do nothing
         */
        if (this.isPublicRoute(matchedRoute)) {
            return {
                canAccess: true,
                redirectPath: null
            }
        }

        /**
         * route is protected, redirect to /login if not logged-in
         */
        if (!logged) {
            return {
                canAccess: false,
                redirectPath: Util.generatePath({
                    path: ROUTES.LOGIN
                })
            }
        }

        /**
         * route only requires logged-in user (ROLE_USER), no additional role check necessary, do nothing
         */
        if (routeRoles.length === 1 && routeRoles.includes(ROLES.USER)) {
            return {
                canAccess: true,
                redirectPath: null
            }
        }

        const userRole = userRoles.find(role => role !== ROLES.USER) ?? ROLES.ANON;

        /**
         * user does not have necessary roles, redirect to /unauthorized
         */
        if (routeRoles.includes(userRole)) {
            return {
                canAccess: true,
                redirectPath: null
            }
        }

        // return {
        //     canAccess: false,
        //     redirectPath: Util.generatePath({
        //         path: ROUTES.UNAUTHORIZED
        //     })
        // }

        return {
            canAccess: false,
            redirectPath: Util.generatePath({
                path: ROUTES.LOGIN
            })
        }
    }

    static createPreCompiledNotes = (paragraphs: any[][]): string => {
        return paragraphs.reduce<string>((str, curr: string[]) => {
            str += `%P% %SPAN%${curr[0]}%SPAN_END% %STRONG%${curr[1]}%STRONG_END% %P_END%`;
            return str;
        }, "");
    }

    static parseMixedNotes = (notes: string): { realNotes: string; preCompiledNotes: string } => {
        const [realNotes, preCompiledMotes] = notes.split("%NOTES_END%");

        return {
            realNotes,
            preCompiledNotes: this.parsePreCompiledNotes(preCompiledMotes)
        }
    };

    static replace_string_with_url(notes: string) {
        const exp_match = /(\b(https?|):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
        const element_content = notes.replace(exp_match, "<a class='link-show' href='$1' target='_blank'>vedi allegato</a>");
        const new_exp_match = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
        return element_content.replace(new_exp_match, '$1<a class="link-show" target="_blank" href="http://$2">vedi allegato</a>');
    }


    static parsePreCompiledNotes = (notes: string): string => {
        notes = Util.replace_string_with_url(notes);
        return notes
            .replaceAll("%P%", "<p>")
            .replaceAll("%P_END%", "</p>")
            .replaceAll("%SPAN%", "<span>")
            .replaceAll("%SPAN_END%", "</span>")
            .replaceAll("%STRONG%", "<strong>")
            .replaceAll("%STRONG_END%", "</strong>")
    };

    static normalizeList = <OT, NT>(data: OT[], normalizeCallback: (record: OT) => NT): NT[] => {

        return data.map(record => normalizeCallback(record));

    }

    static removeEmptyKeys = (obj: object): object => {

        return Object.keys(obj).reduce((acc, k) => {
            if (obj[k] !== "" && obj[k] !== undefined && obj[k] !== null) {
                acc[k] = obj[k];
            }
            return acc;
        }, {});

    };

    static serviceExceptionToState = <T = SubmitError>(ex: any): T => {
        return {
            response: ex instanceof ApiErrorResponse ? ex as ApiErrorResponse : ex,
            message: ex instanceof ApiErrorResponse ? ex.message : MESSAGES.GENERIC_ERROR
        } as unknown as T
    }

    static jsonToFormData(data: any) {
        const formData = new FormData();

        this.buildFormData(formData, data);

        return formData;
    }

    private static buildFormData(formData: { append: (arg0: any, arg1: any) => void; }, data: { [x: string]: any; } | null, parentKey: any = undefined) {
        if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
            Object.keys(data).forEach(key => {
                this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
            });
        } else {
            const value = data == null ? '' : data;

            formData.append(parentKey, value);
        }
    }

    public static objectToFormData = (obj: any = {}, removeUndefinedValues: boolean = true): FormData => {

        if (!obj)
            return new FormData();

        const object = this.removeEmptyKeys(obj);

        return Object.keys(object).reduce((formData, key) => {

            const current = object[key];

            if (removeUndefinedValues) {
                if (current !== undefined && typeof current !== 'undefined') {
                    if (Array.isArray(current)) {
                        for (let i = 0; i < current.length; i++) {
                            if (current[i] && current[i] !== null && typeof current[i] === 'object') {
                                Object.keys(current[i]).forEach(k2 => {
                                    formData.append(`${key}[${i}][${k2}]`, current[i][k2]);
                                })
                            } else {
                                formData.append(`${key}[]`, current[i]);
                            }
                        }
                    } else {
                        formData.append(key, current);
                    }
                }
            } else {
                if (Array.isArray(current)) {
                    for (let i = 0; i < current.length; i++) {
                        if (current[i] && current[i] !== null && typeof current[i] === 'object') {
                            Object.keys(current[i]).forEach(k2 => {
                                formData.append(`${key}[${i}][${k2}]`, current[i][k2]);
                            })
                        } else {
                            formData.append(`${key}[]`, current[i]);
                        }
                    }
                } else {
                    formData.append(key, current);
                }
            }
            return formData;
        }, new FormData());

    }

    public static filtersToQueryParams = (obj: object): string => {

        const qP: string[] = [];

        Object.keys(obj).forEach((k) => {
            const kValue = obj[k];

            if (!kValue)
                return;

            if (Array.isArray(kValue)) {
                const arr = obj[k].map(encodeURIComponent);
                qP.push(`${k}[]=${arr.join('&' + k + '[]=')}`);

            } else {
                qP.push(`${k}=${kValue}`)
            }

        });

        return qP.join('&');
    };

    // public static calculateCriticalTickets = (ticketDate: string): SlaLevels => {
    //
    //     const moment = require('moment-business-days');
    //
    //     const currentYear = moment(new Date()).format('YYYY');
    //
    //     moment.updateLocale('it', {
    //         holidays: [
    //             "01/01/" + currentYear, //Capodanno
    //             "06/01/" + currentYear, //Epifania
    //             "25/04/" + currentYear, //Liberazione
    //             "01/05/" + currentYear, //Festa Lavoratori
    //             "02/06/" + currentYear, //Festa della Repubblica
    //             "15/08/" + currentYear, //Ferragosto
    //             "01/11/" + currentYear, //Tutti Santi
    //             "08/12/" + currentYear, //Immacolata
    //             "25/12/" + currentYear, //Natale
    //             "26/12/" + currentYear, //Santo Stefano
    //         ],
    //         holidayFormat: DATE_FORMATS.DATE_FORMAT_DEFAULT,
    //         workingWeekdays: [1, 2, 3, 4, 5],
    //     });
    //
    //     const currentDate = moment(new Date()).format(DATE_FORMATS.DATE_FORMAT_DEFAULT);
    //     const diff = moment(currentDate, DATE_FORMATS.DATE_FORMAT_DEFAULT).businessDiff(moment(ticketDate, DATE_FORMATS.DATE_FORMAT_DEFAULT), true);
    //
    //     switch (true) {
    //         case diff < 3: {
    //             return 'green';
    //         }
    //         case diff >= 3 && diff < 5: {
    //             return 'orange';
    //         }
    //         case diff >= 5: {
    //             return 'red';
    //         }
    //         default: {
    //             return 'green';
    //         }
    //     }
    // };

}

export default Util;