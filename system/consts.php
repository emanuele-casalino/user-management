<?php

class Consts {

    // directories
    const SYS_DIR = "system/";
    const DICTIONARY_DIR = self::SYS_DIR . "dictionary/";
    const TEMPLATES_DIR = self::SYS_DIR . "templates/";
    const VIEWS_DIR = self::SYS_DIR . "views/";
    // pages
    const CHANGE_PASSWORD_PAGE_NAME = "change_password";
    const CHANGE_USERNAME_PAGE_NAME = "change_username";
    const HOME_PAGE_NAME = "home";
    const HTTP_401_PAGE_NAME = "http_401";
    const HTTP_404_PAGE_NAME = "http_404";
    const INFO_PAGE_NAME = "info";
    const LOGIN_PAGE_NAME = "login";
    const LOGOUT_PAGE_NAME = "logout";
    const PASSWORD_RECOVERY_PAGE_NAME = "password_recovery";
    const REQUEST_ACTIVATION_LINK_PAGE_NAME = "request_activation_link";
    const SET_PASSWORD_PAGE_NAME = "set_password";
    const SIGN_UP_ON_THE_SITE_PAGE_NAME = "sign_up_on_the_site";
    const UNSUBSCRIBE_FROM_THE_SITE_PAGE_NAME = "unsubscribe_from_the_site";
    const VIEW_USER_INFO_PAGE_NAME = "view_user_info";
    // templates
    const PAGE_TEMPLATE_FILENAME = self::TEMPLATES_DIR . "page.php";
    const REDIRECT_TO_HOME_TEMPLATE_FILENAME = self::TEMPLATES_DIR . "redirect_to_home.php";
    // views
    const ERROR_401_PAGE_FILENAME = self::VIEWS_DIR . self::HTTP_401_PAGE_NAME . ".php";
    const ERROR_404_PAGE_FILENAME = self::VIEWS_DIR . self::HTTP_404_PAGE_NAME . ".php";
    // languages
    const DEFAULT_LANGUAGE = "en";
    const LANGUAGES = ["it", "en"];
    // lengths
    const MAX_LOGIN_SESSION_LENGTH = 60 * 60;
    const MAX_EMAIL_WAITING_LENGTH = 60 * 60;
    const MAX_PASSWORD_LIFETIME_LENGTH = 30 * 24 * 60 * 60;
    // sessions
    const USER_SESSION_VARIABLE_NAME = "emanuele_auth_session_user";

}
