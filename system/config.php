<?php

class Config {

    // set main site
    const MAIN_SITE = "http://localhost/";
    // set app dir
    const APP_DIR = "user_management";
    const APP_SITE = "http://localhost/" . self::APP_DIR;
    // set database parameters
    const DB_HOST = "localhost";
    const DB_USERNAME = "root";
    const DB_PASSWORD = "";
    const DB_NAME = "thirdmillenniummedia";
    // set table parameters
    const USERS_TABLE_NAME = "users";
    // set variables parameters
    const ID_VARIABLE_NAME = "ID";
    const ROLE_VARIABLE_NAME = "groupid";
    const USERNAME_VARIABLE_NAME = "username";
    const PASSWORD_VARIABLE_NAME = "password";
    const EMAIL_VARIABLE_NAME = "email";
    const IS_ACTIVE_OR_NOT_VARIABLE_NAME = "active";
    const RESET_DATE_VARIABLE_NAME = "reset_date";
    const LAST_PASSWORD_DATE_VARIABLE_NAME = "last_password_date";
    const CREATED_AT_VARIABLE_NAME = "created_at";
    const UPDATED_AT_VARIABLE_NAME = "updated_at";
    // set role values
    const ADMIN_ROLE_VALUE = "<Admin>";
    // set user parameters
    const MIN_USERNAME_LENGTH = 6;
    const MAX_USERNAME_LENGTH = 32;
    // set password parameters
    const MIN_PASSWORD_LENGTH = 6;
    const MAX_PASSWORD_LENGTH = 32;
    const BCRYPT_COST = 10;
    // set email parameters
    const MAX_EMAIL_LENGTH = 255;
    // set is active value
    const ACTIVE_USER_BOOLEAN_VALUE = true;

}
