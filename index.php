<?php

require_once("system/application.php");

class Index {

    /**
     * 
     * @return void
     */
    public static function init(): void {
        $url = parse_url(urldecode(filter_input(INPUT_SERVER, "REQUEST_URI")));
        if (isset($url["query"])) {
            Application::echoPage($url["path"], $url["query"]);
        } else {
            Application::echoPage($url["path"], null);
        }
    }

}

\Index::init();
