<?php
require_once("system/config.php");

class MailLibrary {

    /**
     * 
     * @return bool
     */
    public static function sendMail(string $to, string $subject, string $message): bool {
        if (strpos(Config::APP_SITE, "http://localhost/") !== false || strpos(Config::APP_SITE, "https://localhost/") !== false) {
            ?>
            <div class="alert alert-info">
                <?= $message ?>
            </div>
            <?php
            return true;
        } else {
            return mail(
                    $to,
                    $subject,
                    $message);
        }
    }

}
