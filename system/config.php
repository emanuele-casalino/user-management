<?php

class Config {

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
    const USERNAME_VARIABLE_NAME = "username";
    const PASSWORD_VARIABLE_NAME = "password";
    const EMAIL_VARIABLE_NAME = "email";
    const IS_ACTIVE_OR_NOT_VARIABLE_NAME = "active";
    const RESET_TOKEN_VARIABLE_NAME = "reset_token";
    const RESET_DATE_VARIABLE_NAME = "reset_date";
    // set user parameters
    const MIN_USERNAME_LENGTH = 6;
    const MAX_USERNAME_LENGTH = 32;
    // set password parameters
    const MIN_PASSWORD_LENGTH = 6;
    const MAX_PASSWORD_LENGTH = 32;
    const BCRYPT_COST = 10;
    // set email parameters
    const MAX_EMAIL_LENGTH = 255;
    // set reset token parameters
    const RESET_TOKEN_MAX_LENGTH = 50;
    // set is active value
    const ACTIVE_USER_BOOLEAN_VALUE = true;

}
