<?php

require_once("system/config.php");
require_once("system/consts.php");
require_once("system/libraries/languages.php");
require_once("system/libraries/mail.php");
require_once("system/libraries/users.php");
require_once("system/models/users.php");

class Controller {

    /**
     * 
     * @param array $referenced_page_variables
     * @return void
     */
    private static function setLoginValues(array &$referenced_page_variables): void {
        $referenced_page_variables["messages"] = [];
        $referenced_page_variables["redirect_to_home_filename"] = null;
        //
        if (filter_input(INPUT_SERVER, "REQUEST_METHOD") != "POST") {
            return;
        }
        // get username and password values
        $username = trim(filter_input(INPUT_POST, "username"));
        $password = filter_input(INPUT_POST, "password");
        // check username and password values
        if (empty($username)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "empty_username",
                        "parameters" => null
            ];
        } else {
            $referenced_page_variables["messages"] = array_merge($referenced_page_variables["messages"], UsersLibrary::checkUsername($username));
        }
        if (empty($password)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "empty_password",
                        "parameters" => null
            ];
        } else {
            $referenced_page_variables["messages"] = array_merge($referenced_page_variables["messages"], UsersLibrary::checkPassword($password, "password"));
        }
        //
        if (!empty($referenced_page_variables["messages"])) {
            return;
        }
        //
        $user = UsersModel::getUserGivenUsername($username);
        if ($user && UsersLibrary::isUserActive($user) && password_verify($password, $user[Config::PASSWORD_VARIABLE_NAME])) {
            UsersModel::storeIntoSession($user);
            $referenced_page_variables["redirect_to_home_filename"] = Consts::REDIRECT_TO_HOME_TEMPLATE_FILENAME;
        } else {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "authentication_error",
                        "parameters" => null
            ];
        }
    }

    /**
     * 
     * @param array $page_dictionary
     * @param array $referenced_page_variables
     * @param string $default_language
     * @return void
     */
    private static function setSignUpOnTheSiteValues(array $page_dictionary, array &$referenced_page_variables, string $default_language): void {
        $referenced_page_variables["messages"] = [];
        $referenced_page_variables["hide_form"] = false;
        //
        if (filter_input(INPUT_SERVER, "REQUEST_METHOD") != "POST") {
            return;
        }
        // get email and username values
        $email = filter_input(INPUT_POST, "email");
        $username = trim(filter_input(INPUT_POST, "username"));
        // check email and username values
        if (empty($email)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "empty_email",
                        "parameters" => null
            ];
        } else {
            $referenced_page_variables["messages"] = array_merge($referenced_page_variables["messages"], UsersLibrary::checkEmail($email));
        }
        if (empty($username)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "empty_username",
                        "parameters" => null
            ];
        } else {
            $referenced_page_variables["messages"] = array_merge($referenced_page_variables["messages"], UsersLibrary::checkUsername($username));
        }
        //
        if (!empty($referenced_page_variables["messages"])) {
            return;
        }
        //
        $userGivenEmail = UsersModel::getUserGivenEmail($email);
        if ($userGivenEmail) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "site_registration_error",
                        "parameters" => null
            ];
            return;
        }
        //
        $userGivenUsername = UsersModel::getUserGivenUsername($username);
        if ($userGivenUsername) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "site_registration_error",
                        "parameters" => null
            ];
            return;
        }
        //
        UsersModel::addUser($email, $username);
        $newUser = UsersModel::getUserGivenUsername($username);
        if (empty($newUser)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "site_registration_error",
                        "parameters" => null
            ];
            return;
        }
        //
        $actual_date = date("Y-m-d H:i:s");
        $url = Config::APP_SITE;
        if ($referenced_page_variables["page_lang"] != $default_language) {
            $url .= "/" . $referenced_page_variables["page_lang"];
        }
        $url .= "/" . Consts::SET_PASSWORD_PAGE_NAME . "?hash=" . hash("sha256", $newUser[Config::ID_VARIABLE_NAME] . "|" . $newUser[Config::PASSWORD_VARIABLE_NAME] . "|" . $actual_date);
        //
        $message = "<p>"
                . htmlspecialchars($page_dictionary["messages"]["site_registration_mail"])
                . "</p>"
                . "<p>"
                . "<a href=\"" . $url . "\" target=\"_blank\">"
                . $url
                . "</a>"
                . "</p>";
        if (MailLibrary::sendMail($email, $page_dictionary["pages"]["sign_up_on_the_site"] . " - " . $page_dictionary["app_title"], $message)) {
            UsersModel::editResetDate($newUser[Config::ID_VARIABLE_NAME], $actual_date);
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "success",
                        "lemma" => "site_registration_successful",
                        "parameters" => null
            ];
            $referenced_page_variables["hide_form"] = true;
        } else {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "site_registration_successful_but_with_sending_mail_error",
                        "parameters" => null
            ];
        }
    }

    /**
     * 
     * @param array $page_dictionary
     * @param array $referenced_page_variables
     * @param string $default_language
     * @param bool $for_active_users
     * @return void
     */
    private static function setRequestActivationLinkValues(array $page_dictionary, array &$referenced_page_variables, string $default_language, bool $for_active_users): void {
        $referenced_page_variables["messages"] = [];
        $referenced_page_variables["hide_form"] = false;
        //
        if (filter_input(INPUT_SERVER, "REQUEST_METHOD") != "POST") {
            return;
        }
        // get email
        $email = filter_input(INPUT_POST, "email");
        // check email
        if (empty($email)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "empty_email",
                        "parameters" => null
            ];
        } else {
            $referenced_page_variables["messages"] = array_merge($referenced_page_variables["messages"], UsersLibrary::checkEmail($email));
        }
        //
        if (!empty($referenced_page_variables["messages"])) {
            return;
        }
        //
        $user = UsersModel::getUserGivenEmail($email);
        //
        if ($user
                //
                && ($for_active_users ? UsersLibrary::isUserActive($user) : (!UsersLibrary::isUserActive($user)))
                //        
                && (empty($user[Config::RESET_DATE_VARIABLE_NAME]) || (time() - strtotime($user[Config::RESET_DATE_VARIABLE_NAME])) >= Consts::MAX_EMAIL_SESSION_LENGTH)) {
            $actual_date = date("Y-m-d H:i:s");
            //
            $url = Config::APP_SITE;
            if ($referenced_page_variables["page_lang"] != $default_language) {
                $url .= "/" . $referenced_page_variables["page_lang"];
            }
            $url .= "/" . Consts::SET_PASSWORD_PAGE_NAME . "?hash=" . hash("sha256", $user[Config::ID_VARIABLE_NAME] . "|" . $user[Config::PASSWORD_VARIABLE_NAME] . "|" . $actual_date);
            //
            $message = "<p>"
                    . htmlspecialchars($for_active_users ? $page_dictionary["messages"]["password_retrieve_mail"] : $page_dictionary["messages"]["request_activation_link_mail"])
                    . "</p>"
                    . "<p>"
                    . "<a href=\"" . $url . "\" target=\"_blank\">"
                    . $url
                    . "</a>"
                    . "</p>";
            if (MailLibrary::sendMail($email, $page_dictionary["pages"]["password_recovery"] . " - " . $page_dictionary["app_title"], $message)) {
                UsersModel::editResetDate($user[Config::ID_VARIABLE_NAME], $actual_date);
                $referenced_page_variables["messages"][] = (object) [
                            "type" => "success",
                            "lemma" => ($for_active_users ? "password_retrieve_successful" : "request_activation_link_successful"),
                            "parameters" => null
                ];
                $referenced_page_variables["hide_form"] = true;
            } else {
                $referenced_page_variables["messages"][] = (object) [
                            "type" => "warning",
                            "lemma" => ($for_active_users ? "password_retrieve_error" : "request_activation_link_error"),
                            "parameters" => null
                ];
            }
        } else {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => ($for_active_users ? "password_retrieve_error" : "request_activation_link_error"),
                        "parameters" => null
            ];
        }
    }

    /**
     * 
     * @param array $referenced_page_variables
     * @return void
     */
    private static function setSetPasswordValues(array &$referenced_page_variables): void {
        $referenced_page_variables["messages"] = [];
        $referenced_page_variables["form_status"] = 0;
        //
        $hash = filter_input(INPUT_GET, "hash");
        if (empty($hash)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "empty_hash",
                        "parameters" => null
            ];
            $referenced_page_variables["form_status"] = -1;
        }
        //
        if (!empty($referenced_page_variables["messages"])) {
            return;
        }
        //
        $user = UsersModel::getUserGivenHash($hash);
        if (empty($user)
                //
                || (time() - strtotime($user[Config::RESET_DATE_VARIABLE_NAME])) >= Consts::MAX_EMAIL_SESSION_LENGTH) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "invalid_hash_for_password_recovery",
                        "parameters" => null
            ];
            $referenced_page_variables["form_status"] = -1;
        }
        //
        if (!empty($referenced_page_variables["messages"])) {
            return;
        }
        //
        if (filter_input(INPUT_SERVER, "REQUEST_METHOD") != "POST") {
            return;
        }
        //
        $password_1 = filter_input(INPUT_POST, "password_1");
        $password_2 = filter_input(INPUT_POST, "password_2");
        // check passwords
        if (empty($password_1)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "empty_password_1",
                        "parameters" => null
            ];
        } else {
            $referenced_page_variables["messages"] = array_merge($referenced_page_variables["messages"], UsersLibrary::checkPassword($password_1, "password_1"));
        }
        if (empty($password_2)) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "empty_password_2",
                        "parameters" => null
            ];
        } else {
            $referenced_page_variables["messages"] = array_merge($referenced_page_variables["messages"], UsersLibrary::checkPassword($password_2, "password_2"));
        }
        //
        if (!empty($referenced_page_variables["messages"])) {
            return;
        }
        //
        if ($password_1 != $password_2) {
            $referenced_page_variables["messages"][] = (object) [
                        "type" => "warning",
                        "lemma" => "passwords_mismatch",
                        "parameters" => null
            ];
        }
        //
        if (!empty($referenced_page_variables["messages"])) {
            return;
        }
        //
        UsersModel::editPassword($user[Config::ID_VARIABLE_NAME], $password_1);
        UsersModel::activateUser($user[Config::ID_VARIABLE_NAME], true);
        $referenced_page_variables["messages"][] = (object) [
                    "type" => "success",
                    "lemma" => "password_set_successfully_[%s]",
                    "parameters" => [$user[Config::USERNAME_VARIABLE_NAME]]
        ];
        $referenced_page_variables["form_status"] = 1;
    }

    /**
     * 
     * @param string $view_name
     * @param string $page_lang
     * @param string|null $query_string
     * @return void
     */
    public static function echoPage(string $view_name, string $page_lang, ?string $query_string): void {
        $page_variables = [];
        // get temporary variables
        $temp_variables = [];
        $temp_variables["default_language"] = LanguageLibrary::getDefaultLanguage();
        // get logged user
        $page_variables["logged_user"] = UsersModel::getFromSession();
        // set page language, page name and view filename
        if (in_array($page_lang, Consts::LANGUAGES)) {
            $page_variables["page_lang"] = $page_lang;
            // set page name and view filename
            $temp_variables["view_filename"] = Consts::VIEWS_DIR . $view_name . ".php";
            if (is_file($temp_variables["view_filename"])) {
                if ($page_variables["logged_user"]) {
                    if (in_array($view_name, [Consts::LOGIN_PAGE_NAME, Consts::SIGN_UP_ON_THE_SITE_PAGE_NAME, Consts::REQUEST_ACTIVATION_LINK_PAGE_NAME, Consts::PASSWORD_RECOVERY_PAGE_NAME, Consts::SET_PASSWORD_PAGE_NAME])) {
                        $page_variables["page_name"] = Consts::HTTP_401_PAGE_NAME;
                        $page_variables["view_filename"] = Consts::ERROR_401_PAGE_FILENAME;
                    } else {
                        $page_variables["page_name"] = $view_name;
                        $page_variables["view_filename"] = $temp_variables["view_filename"];
                    }
                } else {
                    if (in_array($view_name, [Consts::VIEW_USER_INFO_PAGE_NAME, Consts::CHANGE_USERNAME_PAGE_NAME, Consts::CHANGE_PASSWORD_PAGE_NAME, Consts::LOGOUT_PAGE_NAME])) {
                        $page_variables["page_name"] = Consts::HTTP_401_PAGE_NAME;
                        $page_variables["view_filename"] = Consts::ERROR_401_PAGE_FILENAME;
                    } else {
                        $page_variables["page_name"] = $view_name;
                        $page_variables["view_filename"] = $temp_variables["view_filename"];
                    }
                }
            } else {
                $page_variables["page_name"] = Consts::HTTP_404_PAGE_NAME;
                $page_variables["view_filename"] = Consts::ERROR_404_PAGE_FILENAME;
            }
            unset($temp_variables["view_filename"]);
        } else {
            $page_variables["page_lang"] = $temp_variables["default_language"];
            $page_variables["page_name"] = Consts::HTTP_404_PAGE_NAME;
            $page_variables["view_filename"] = Consts::ERROR_404_PAGE_FILENAME;
        }
        // set app url prefix
        if ($page_variables["page_lang"] == $temp_variables["default_language"]) {
            $page_variables["app_url_prefix"] = "/" . Config::APP_DIR;
        } else {
            $page_variables["app_url_prefix"] = "/" . Config::APP_DIR . "/" . $page_variables["page_lang"];
        }
        // set languages array
        $page_variables["page_langs"] = [];
        foreach (Consts::LANGUAGES as $temp_variables["lang"]) {
            $temp_variables["url"] = "/" . Config::APP_DIR;
            if ($temp_variables["lang"] != $temp_variables["default_language"]) {
                $temp_variables["url"] .= "/" . $temp_variables["lang"];
            }
            if ($page_variables["page_name"] != Consts::HOME_PAGE_NAME) {
                $temp_variables["url"] .= "/" . $page_variables["page_name"];
            }
            $page_variables["page_langs"][] = (object) [
                        "url" => $temp_variables["url"],
                        "value" => $temp_variables["lang"]
            ];
        }
        // set with home button
        if ($page_variables["page_name"] == Consts::HOME_PAGE_NAME) {
            $page_variables["with_home_button"] = false;
        } else {
            $page_variables["with_home_button"] = true;
        }
        // set page dictionary
        $page_dictionary = json_decode(file_get_contents(Consts::DICTIONARY_DIR . $page_variables["page_lang"] . ".json"), JSON_OBJECT_AS_ARRAY);
        // set other values
        if ($page_variables["page_name"] == Consts::LOGIN_PAGE_NAME) {
            self::setLoginValues($page_variables);
        } else if ($page_variables["page_name"] == Consts::SIGN_UP_ON_THE_SITE_PAGE_NAME) {
            self::setSignUpOnTheSiteValues($page_dictionary, $page_variables, $temp_variables["default_language"]);
        } else if ($page_variables["page_name"] == Consts::REQUEST_ACTIVATION_LINK_PAGE_NAME) {
            self::setRequestActivationLinkValues($page_dictionary, $page_variables, $temp_variables["default_language"], false);
        } else if ($page_variables["page_name"] == Consts::PASSWORD_RECOVERY_PAGE_NAME) {
            self::setRequestActivationLinkValues($page_dictionary, $page_variables, $temp_variables["default_language"], true);
        } else if ($page_variables["page_name"] == Consts::SET_PASSWORD_PAGE_NAME) {
            self::setSetPasswordValues($page_variables);
        } else if ($page_variables["page_name"] == Consts::CHANGE_USERNAME_PAGE_NAME) {
            $page_variables["messages"] = [];
            $page_variables["hide_form"] = false;
            //
            if (filter_input(INPUT_SERVER, "REQUEST_METHOD") == "POST") {
                // get username and password values
                $temp_variables["password"] = filter_input(INPUT_POST, "password");
                $temp_variables["username"] = trim(filter_input(INPUT_POST, "username"));
                // check username and password values
                if (empty($temp_variables["password"])) {
                    $page_variables["messages"][] = (object) [
                                "type" => "warning",
                                "lemma" => "empty_password",
                                "parameters" => null
                    ];
                } else {
                    $page_variables["messages"] = array_merge($page_variables["messages"], UsersLibrary::checkPassword($temp_variables["password"], "password"));
                }
                if (empty($temp_variables["username"])) {
                    $page_variables["messages"][] = (object) [
                                "type" => "warning",
                                "lemma" => "empty_username",
                                "parameters" => null
                    ];
                } else {
                    $page_variables["messages"] = array_merge($page_variables["messages"], UsersLibrary::checkUsername($temp_variables["username"]));
                }
                //
                if (empty($page_variables["messages"])) {
                    if ($page_variables["logged_user"] && password_verify($temp_variables["password"], $page_variables["logged_user"][Config::PASSWORD_VARIABLE_NAME])) {
                        // update username
                        UsersModel::editUsername($page_variables["logged_user"][Config::ID_VARIABLE_NAME], $temp_variables["username"]);
                        $temp_variables["user"] = UsersModel::getUserGivenId($page_variables["logged_user"][Config::ID_VARIABLE_NAME]);
                        UsersModel::storeIntoSession($temp_variables["user"]);
                        $page_variables["logged_user"] = UsersModel::getFromSession();
                        //
                        $page_variables["messages"][] = (object) [
                                    "type" => "success",
                                    "lemma" => "changing_username_successful",
                                    "parameters" => null
                        ];
                        $page_variables["hide_form"] = true;
                    } else {
                        $page_variables["messages"][] = (object) [
                                    "type" => "warning",
                                    "lemma" => "changing_username_error",
                                    "parameters" => null
                        ];
                    }
                }
            }
        } else if ($page_variables["page_name"] == Consts::CHANGE_PASSWORD_PAGE_NAME) {
            $page_variables["messages"] = [];
            $page_variables["hide_form"] = false;
            //
            if (filter_input(INPUT_SERVER, "REQUEST_METHOD") == "POST") {
                $temp_variables["old_password"] = filter_input(INPUT_POST, "old_password");
                $temp_variables["new_password_1"] = filter_input(INPUT_POST, "new_password_1");
                $temp_variables["new_password_2"] = filter_input(INPUT_POST, "new_password_2");
                // check passwords
                if (empty($temp_variables["old_password"])) {
                    $page_variables["messages"][] = (object) [
                                "type" => "warning",
                                "lemma" => "empty_old_password",
                                "parameters" => null
                    ];
                } else {
                    $page_variables["messages"] = array_merge($page_variables["messages"], UsersLibrary::checkPassword($temp_variables["old_password"], "old_password"));
                }
                if (empty($temp_variables["new_password_1"])) {
                    $page_variables["messages"][] = (object) [
                                "type" => "warning",
                                "lemma" => "empty_new_password_1",
                                "parameters" => null
                    ];
                } else {
                    $page_variables["messages"] = array_merge($page_variables["messages"], UsersLibrary::checkPassword($temp_variables["new_password_1"], "new_password_1"));
                }
                if (empty($temp_variables["new_password_2"])) {
                    $page_variables["messages"][] = (object) [
                                "type" => "warning",
                                "lemma" => "empty_new_password_2",
                                "parameters" => null
                    ];
                } else {
                    $page_variables["messages"] = array_merge($page_variables["messages"], UsersLibrary::checkPassword($temp_variables["new_password_2"], "new_password_2"));
                }
                //
                if (empty($page_variables["messages"])) {
                    if ($temp_variables["new_password_1"] != $temp_variables["new_password_2"]) {
                        $page_variables["messages"][] = (object) [
                                    "type" => "warning",
                                    "lemma" => "new_passwords_mismatch",
                                    "parameters" => null
                        ];
                    }
                }
                //
                if (empty($page_variables["messages"])) {
                    if ($page_variables["logged_user"] && password_verify($temp_variables["old_password"], $page_variables["logged_user"][Config::PASSWORD_VARIABLE_NAME])) {
                        UsersModel::editPassword($page_variables["logged_user"][Config::ID_VARIABLE_NAME], $temp_variables["new_password_1"]);
                        UsersModel::deleteFromSession();
                        $page_variables["messages"][] = (object) [
                                    "type" => "success",
                                    "lemma" => "changing_password_successful",
                                    "parameters" => null
                        ];
                        $page_variables["hide_form"] = true;
                    } else {
                        $page_variables["messages"][] = (object) [
                                    "type" => "warning",
                                    "lemma" => "changing_password_error",
                                    "parameters" => null
                        ];
                    }
                }
            }
        } else if ($page_variables["page_name"] == Consts::LOGOUT_PAGE_NAME) {
            UsersModel::deleteFromSession();
            $page_variables["redirect_to_home_filename"] = Consts::REDIRECT_TO_HOME_TEMPLATE_FILENAME;
        }
        // unset original variables
        unset($view_name);
        unset($page_lang);
        unset($query_string);
        // unset temporary variables
        unset($temp_variables);
        // convert variables from array to object
        $page_variables = (object) $page_variables;
        // echo page
        require_once(Consts::PAGE_TEMPLATE_FILENAME);
        exit(0);
    }

}
