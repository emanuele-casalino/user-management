<?php

require_once("system/config.php");
require_once("system/consts.php");
require_once("system/controller.php");
require_once("system/libraries/languages.php");

class Application {

    /**
     * 
     * @param string $path_string
     * @return void
     */
    public static function echoPage(string $path_string): void {
        $path_array = explode("/", $path_string);
        if ($path_array[1] != Config::APP_DIR) {
            die("Wrong application directory!");
        }
        $path_params_array = array_slice($path_array, 2);
        $path_params_count = count($path_params_array);
        if ($path_params_count >= 1 && empty($path_params_array[$path_params_count - 1])) {
            $path_params_array = array_slice($path_params_array, 0, $path_params_count - 1);
        }
        switch (count($path_params_array)) {
            case 0:
                $view_name = Consts::HOME_PAGE_NAME;
                $page_lang = LanguageLibrary::getDefaultLanguage();
                break;
            case 1:
                if (empty($path_params_array[0])) {
                    $view_name = Consts::HOME_PAGE_NAME;
                    $page_lang = LanguageLibrary::getDefaultLanguage();
                } else if (in_array($path_params_array[0], Consts::LANGUAGES)) {
                    $view_name = Consts::HOME_PAGE_NAME;
                    $page_lang = $path_params_array[0];
                } else {
                    $view_name = $path_params_array[0];
                    $page_lang = LanguageLibrary::getDefaultLanguage();
                }
                break;
            case 2:
                $view_name = $path_params_array[1];
                $page_lang = $path_params_array[0];
                break;
            default:
                $view_name = Consts::HTTP_404_PAGE_NAME;
                $page_lang = LanguageLibrary::getDefaultLanguage();
                break;
        }
        Controller::echoPage($view_name, $page_lang);
    }

}
