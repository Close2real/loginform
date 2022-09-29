<?php

namespace App\Utils;

/**
 * @package App\Utils
 */
class Constants
{

    /**
     * http codes
     */
    public const HTTP_OK = 200;
    public const HTTP_ACCEPTED = 202;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_SERVER_ERROR = 500;

    /**
     * custom codes
     */
    public const FORM_VALIDATION_ERROR_CODE = 499;

    /**
     * types
     */
    public const JSON_TYPE = 'json';
    public const ARRAY_TYPE = 'array';
    public const HTTP_GET = "GET";
    public const HTTP_POST = "POST";
    public const HTTP_PUT = "PUT";
    public const HTTP_PATCH = "PATCH";
    public const HTTP_DELETE = "DELETE";
    public const HTTP_OPTIONS = "OPTIONS";

    /**
     * date time formats
     */
    public const DATE_FORMAT_DISPLAY = "d/m/Y";
    public const DATETIME_FORMAT_DISPLAY = "d/m/Y H:i";
    public const DATE_FORMAT_ISO = "Y-m-d";
    public const DATETIME_FORMAT_ISO = "Y-m-d H:i:s";
    public const FIRST_DAY_TIME = "00:00:00";
    public const LAST_DAY_TIME = "23:59:59";

    public const ADD_FIRST_DAY_TIME = ["startDate", "dtstart_ini"];
    public const ADD_LAST_DAY_TIME = ["endDate", "dtstart_fin"];

    /**
     * default app. settings
     */
    public const DEFAULT_APPLICATION_LANGUAGE = 'it';
    public const APPLICATION_LANGUAGE_PARAMETER_NAME = 'lang';
    public const APPLICATION_LANGUAGE_COOKIE_NAME = '__bmedbo_language';

    /**
     * default messages
     */
    public const DEFAULT_ERROR_MESSAGE = "Si è verificato un errore durante la tua richiesta. Ti preghiamo di riprovare più tardi.";

    /**
     * pagination
     */
    public const DEFAULT_PAGINATION_SIZE = 10;
    public const INFINITE_PAGINATION_SIZE = 9999999;

    /**
     * auth
     */
    public const ROLE_ADMIN = "ROLE_ADMIN";
    public const ROLE_BMED = "ROLE_BMED";
    public const ROLE_USER = "ROLE_USER";
    public const ROLE_READ_ONLY = "ROLE_READ_ONLY";

    public const JAVA_ROLES_MAPPING = [
        'ADMIN' => 'ROLE_ADMIN',
        'BMED' => 'ROLE_BMED',
        'READ_ONLY' => 'ROLE_READ_ONLY'
    ];

    public const ALLOWED_AUTH_ROLES = [self::ROLE_ADMIN, self::ROLE_USER, self::ROLE_READ_ONLY];

    public const ROLE_HIERARCHY = [
        self::ROLE_ADMIN => [self::ROLE_ADMIN],
        self::ROLE_BMED => [self::ROLE_ADMIN, self::ROLE_BMED],
        self::ROLE_USER => [self::ROLE_ADMIN, self::ROLE_BMED, self::ROLE_USER, self::ROLE_READ_ONLY]
    ];

    public const INS = 'In attesa';
    public const CNF = 'Confermato';
    public const ANN = 'Annullato';
    public const SPC = 'Spedito';
    public const GCN = 'In giacenza';
    public const CNS = 'Consegnato';
    public const SSP = 'Sospeso';
    public const NNE = 'Sospeso';
    public const NAP = 'Da approvare';
    public const INL = 'In preparazione';
    public const DSA = 'Da inviare alla logistica';
    public const TSP = 'Da confermare';

    public const ORDER_STATUSES = [
        'INS' => self::INS,
        'CNF' => self::CNF,
        'GCN' => self::GCN,
        'ANN' => self::ANN,
        'SPC' => self::SPC,
        'CNS' => self::CNS,
        'SPP' => self::SSP,
        'NNE' => self::NNE,
        'NAP' => self::NAP,
        'INL' => self::INL,
        'DSA' => self::DSA,
        'TSP' => self::TSP
    ];


    /**
     * orders
     */
    public const ORDER_STATUS = [
        "INS" => "Inserito",
        "CNF" => "Confermato",
        "ANN" => "Annullato"
    ];

    /**
     * callcenter
     */
    public const EX_TYPES = [
        'generic' => 'generic',
        'visit' => 'visit',
        'trouble' => 'trouble',
        'logistic' => 'logistic',
        'points' => 'points',
        'informations' => 'informations',
        'claims' => 'claims',
        'automated' => 'automated',
        'irregular' => 'irregular',
        'unknow' => 'unknow'
    ];

    public const EX_CATEGORY_GENERAL = 'bmed_generale';
    public const EX_CATEGORY_COLLECTION_ORDERS = 'bmed_transazioni_collection';
    public const EX_CATEGORY_FORYOUWIN_ORDERS = 'bmed_transazioni_win';
    public const EX_CATEGORY_MGM_ORDERS = 'bmed_transazioni_mgm';
    public const EX_CATEGORY_BENEFIT_ORDERS = 'bmed_transazioni_benefit';
    public const EX_CATEGORY_PROMOSELFY_ORDERS = 'bmed_transazioni_promoselfy';


    public const EX_CATEGORIES = [
        self::EX_CATEGORY_GENERAL => 'Generico',
        self::EX_CATEGORY_COLLECTION_ORDERS => 'Transazioni ForYou Collection',
        self::EX_CATEGORY_FORYOUWIN_ORDERS => 'Transazioni ForYou Win',
        self::EX_CATEGORY_MGM_ORDERS => 'Transazioni Presenta un amico',
        self::EX_CATEGORY_BENEFIT_ORDERS => 'Transazioni Benefit',
        self::EX_CATEGORY_PROMOSELFY_ORDERS => 'Transazioni PromoSelfy'
    ];

    public const STATUS_TICKET_OPENED = 'opened';
    public const STATUS_TICKET_CLOSED = 'closed';
    public const STATUS_TICKET_FORWARDING = 'forwarding';
    public const STATUS_TICKET_WAITING = 'waiting';
    public const STATUS_TICKET_PROCESSED = 'processed';


    public const BMED_GENERIC_USERNAME = 'bmed_generic_ticket';

    /**
     * BMED TRANSACTIONS TYPE
     */
    public const TRANSACTION_TYPE_GLD = 'gold';


    public const BENEFIT_CD_MACRO = 13839;

    public const CD_MACRO_DESCRIPTION = [
        13764 => 'ForYou Collection',
        13776 => 'ForYou Win',
        13839 => 'ForYou Benefit',
        /*        13765 => 'ForYou Experience',*/
        13766 => 'Presenta un amico',
        13932 => 'Promo Selfy'
    ];

}