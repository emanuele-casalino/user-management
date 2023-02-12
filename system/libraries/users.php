<?php

require_once("system/config.php");

class UsersLibrary {

    /**
     * 
     * @param string $email
     * @return array
     */
    public static function checkEmail(string $email): array {
        $result = [];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result[] = (object) [
                        "type" => "warning",
                        "lemma" => "invalid_email",
                        "parameters" => null
            ];
        }
        return $result;
    }

    /**
     * 
     * @param string $username
     * @return array
     */
    public static function checkUsername(string $username): array {
        $result = [];
        if (strlen($username) < Config::MIN_USERNAME_LENGTH || strlen($username) > Config::MAX_USERNAME_LENGTH) {
            $result[] = (object) [
                        "type" => "warning",
                        "lemma" => "wrong_username_length_[%d,%d]",
                        "parameters" => [Config::MIN_USERNAME_LENGTH, Config::MAX_USERNAME_LENGTH]
            ];
        }
        if (preg_match('/[^\ -\?A-\~]/', $username)) {
            $temp_chars_list = "";
            for ($i = 32; $i <= 126; $i++) {
                $temp_char = chr($i);
                if ($temp_char == '@') {
                    continue;
                }
                if ($temp_chars_list) {
                    $temp_chars_list .= " ";
                }
                if ($temp_char == " ") {
                    $temp_chars_list .= "[spc]";
                } else {
                    $temp_chars_list .= $temp_char;
                }
            }
            $result[] = (object) [
                        "type" => "warning",
                        "lemma" => "wrong_username_chars_[%s]",
                        "parameters" => [$temp_chars_list]
            ];
        }
        return $result;
    }

    /**
     * 
     * @param string $password
     * @param string $type
     * @return array
     */
    public static function checkPassword(string $password, string $type): array {
        $result = [];
        if (strlen($password) < Config::MIN_PASSWORD_LENGTH || strlen($password) > Config::MAX_PASSWORD_LENGTH) {
            $result[] = (object) [
                        "type" => "warning",
                        "lemma" => "wrong_" . $type . "_length_[%d,%d]",
                        "parameters" => [Config::MIN_PASSWORD_LENGTH, Config::MAX_PASSWORD_LENGTH]
            ];
        }
        if (preg_match('/[^\!-\~]/', $password)) {
            $temp_chars_list = "";
            for ($i = 33; $i <= 126; $i++) {
                $temp_char = chr($i);
                if ($temp_chars_list) {
                    $temp_chars_list .= " ";
                }
                $temp_chars_list .= $temp_char;
            }
            $result[] = (object) [
                        "type" => "warning",
                        "lemma" => "wrong_" . $type . "_chars_[%s]",
                        "parameters" => [$temp_chars_list]
            ];
        }
        if (!(preg_match('/[0-9]/', $password) && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[^0-9A-Za-z]/', $password))) {
            $result[] = (object) [
                        "type" => "warning",
                        "lemma" => "wrong_" . $type . "_char_types",
                        "parameters" => null
            ];
        }
        return $result;
    }

    /**
     * 
     * @param array $user
     * @return bool
     */
    public static function isUserActive(array $user): bool {
        if (Config::ACTIVE_USER_BOOLEAN_VALUE) {
            return $user[Config::IS_ACTIVE_OR_NOT_VARIABLE_NAME];
        } else {
            return (!$user[Config::IS_ACTIVE_OR_NOT_VARIABLE_NAME]);
        }
    }

    /**
     * 
     * @param array $user
     * @return bool
     */
    public static function isUserSuspended(array $user): bool {
        if (self::isUserActive($user)) {
            return false;
        }
        if ($user[Config::LAST_PASSWORD_DATE_VARIABLE_NAME]) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @return string
     */
    public static function getRandomPassword(): string {
        $result = "";
        $random_length = random_int(Config::MIN_PASSWORD_LENGTH, Config::MAX_PASSWORD_LENGTH);
        for ($i = 0; $i < $random_length; $i++) {
            $result = $result . chr(random_int(33, 126));
        }
        return $result;
    }

}
