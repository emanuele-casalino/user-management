<?php

require_once("system/consts.php");

class LanguageLibrary {

    /**
     * 
     * @return string
     */
    public static function getDefaultLanguage(): string {
        $http_accept_language = filter_input(INPUT_SERVER, "HTTP_ACCEPT_LANGUAGE");
        $language_in_two_letters = substr($http_accept_language, 0, 2);
        if (in_array($language_in_two_letters, Consts::LANGUAGES)) {
            return $language_in_two_letters;
        } else {
            return Consts::DEFAULT_LANGUAGE;
        }
    }

}
