<?php

require_once("system/application.php");

class Index {

    /**
     * 
     * @return void
     */
    public static function init(): void {
        $url = parse_url(urldecode(filter_input(INPUT_SERVER, "REQUEST_URI")));
        Application::echoPage($url["path"]);
    }

}

\Index::init();
