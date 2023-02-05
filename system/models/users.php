<?php

require_once("system/libraries/users.php");
require_once("system/config.php");
require_once("system/consts.php");

class UsersModel {

    private static $_connection;

    /**
     * 
     * @return void
     */
    public static function init(): void {
        self::$_connection = mysqli_connect(Config::DB_HOST, Config::DB_USERNAME, Config::DB_PASSWORD, Config::DB_NAME);
        if (!self::$_connection) {
            die("Connection to database failed!");
        }
        session_start();
    }

    /**
     * 
     * @param string $email
     * @param string $username
     * @return void
     */
    public static function addUser(string $email, string $username): void {
        $query_string = "INSERT INTO " . Config::USERS_TABLE_NAME . "("
                . Config::EMAIL_VARIABLE_NAME
                . ","
                . Config::USERNAME_VARIABLE_NAME
                . ","
                . Config::PASSWORD_VARIABLE_NAME
                . ","
                . Config::IS_ACTIVE_OR_NOT_VARIABLE_NAME
                . ") VALUES ("
                . "'" . self::$_connection->real_escape_string($email) . "'"
                . ","
                . "'" . self::$_connection->real_escape_string($username) . "'"
                . ","
                . "'" . password_hash(UsersLibrary::getRandomPassword(), PASSWORD_BCRYPT, ['cost' => Config::BCRYPT_COST]) . "'"
                . ","
                . (Config::ACTIVE_USER_BOOLEAN_VALUE ? "FALSE" : "TRUE")
                . ")";
        self::$_connection->query($query_string);
    }

    /**
     * 
     * @param int $id
     * @return array|null
     */
    public static function getUserGivenId(int $id): ?array {
        $query_string = "SELECT *"
                . " FROM " . Config::USERS_TABLE_NAME
                . " WHERE " . Config::ID_VARIABLE_NAME . " = '" . $id . "'";
        $query_result = self::$_connection->query($query_string);
        $query_object = $query_result->fetch_array(MYSQLI_ASSOC);
        if ($query_object) {
            return $query_object;
        }
        return null;
    }

    /**
     * 
     * @param string $username
     * @return array|null
     */
    public static function getUserGivenUsername(string $username): ?array {
        $sanitized_username = self::$_connection->real_escape_string($username);
        $query_string = "SELECT *"
                . " FROM " . Config::USERS_TABLE_NAME
                . " WHERE " . Config::USERNAME_VARIABLE_NAME . " = '" . $sanitized_username . "'";
        $query_result = self::$_connection->query($query_string);
        $query_object = $query_result->fetch_array(MYSQLI_ASSOC);
        if ($query_object) {
            return $query_object;
        }
        return null;
    }

    /**
     * 
     * @param string $email
     * @return array|null
     */
    public static function getUserGivenEmail(string $email): ?array {
        $sanitized_email = self::$_connection->real_escape_string($email);
        $query_string = "SELECT *"
                . " FROM " . Config::USERS_TABLE_NAME
                . " WHERE " . Config::EMAIL_VARIABLE_NAME . " = '" . $sanitized_email . "'";
        $query_result = self::$_connection->query($query_string);
        $query_object = $query_result->fetch_array(MYSQLI_ASSOC);
        if ($query_object) {
            return $query_object;
        }
        return null;
    }

    /**
     * 
     * @param string $hash
     * @return array|null
     */
    public static function getUserGivenHash(string $hash): ?array {
        $sanitized_hash = self::$_connection->real_escape_string($hash);
        $query_string = "SELECT *"
                . " FROM " . Config::USERS_TABLE_NAME
                . " WHERE SHA2(CONCAT(" . Config::ID_VARIABLE_NAME . ",'|'," . Config::PASSWORD_VARIABLE_NAME . ",'|'," . Config::RESET_DATE_VARIABLE_NAME . "), 256) = '" . $sanitized_hash . "'";
        $query_result = self::$_connection->query($query_string);
        $query_object = $query_result->fetch_array(MYSQLI_ASSOC);
        if ($query_object) {
            return $query_object;
        }
        return null;
    }

    /**
     * 
     * @param int $user_id
     * @param string $username
     * @return void
     */
    public static function editUsername(int $user_id, string $username): void {
        $sanitized_username = self::$_connection->real_escape_string($username);
        $query_string = "UPDATE " . Config::USERS_TABLE_NAME
                . " SET " . Config::USERNAME_VARIABLE_NAME . " = '" . $sanitized_username . "'"
                . " WHERE " . Config::ID_VARIABLE_NAME . " = " . $user_id;
        self::$_connection->query($query_string);
    }

    /**
     * 
     * @param int $user_id
     * @param string $password
     * @return void
     */
    public static function editPassword(int $user_id, string $password): void {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => Config::BCRYPT_COST]);
        $sanitized_password = self::$_connection->real_escape_string($hashed_password);
        $query_string = "UPDATE " . Config::USERS_TABLE_NAME
                . " SET " . Config::PASSWORD_VARIABLE_NAME . " = '" . $sanitized_password . "'"
                . " WHERE " . Config::ID_VARIABLE_NAME . " = " . $user_id;
        self::$_connection->query($query_string);
    }

    /**
     * 
     * @param int $user_id
     * @param string $reset_date
     * @return void
     */
    public static function editResetDate(int $user_id, string $reset_date): void {
        $sanitized_reset_date = self::$_connection->real_escape_string($reset_date);
        $query_string = "UPDATE " . Config::USERS_TABLE_NAME
                . " SET " . Config::RESET_DATE_VARIABLE_NAME . " = '" . $sanitized_reset_date . "'"
                . " WHERE " . Config::ID_VARIABLE_NAME . " = " . $user_id;
        self::$_connection->query($query_string);
    }

    /**
     * 
     * @param int $user_id
     * @param bool $activate_user
     * @return void
     */
    public static function activateUser(int $user_id, bool $activate_user): void {
        $query_string = "UPDATE " . Config::USERS_TABLE_NAME
                . " SET " . Config::IS_ACTIVE_OR_NOT_VARIABLE_NAME . " = " . (Config::ACTIVE_USER_BOOLEAN_VALUE ? $activate_user : (!$activate_user))
                . " WHERE " . Config::ID_VARIABLE_NAME . " = " . $user_id;
        self::$_connection->query($query_string);
    }

    /**
     * 
     * @return void
     */
    public static function deleteFromSession(): void {
        if (isset($_SESSION[Consts::USER_SESSION_VARIABLE_NAME])) {
            unset($_SESSION[Consts::USER_SESSION_VARIABLE_NAME]);
        }
    }

    /**
     * 
     * @param array $user
     * @return void
     */
    public static function storeIntoSession(array $user): void {
        $_SESSION[Consts::USER_SESSION_VARIABLE_NAME] = (object) [
                    "time" => time(),
                    "user" => $user
        ];
    }

    /**
     * 
     * @return array|null
     */
    public static function getFromSession(): ?array {
        if (!isset($_SESSION[Consts::USER_SESSION_VARIABLE_NAME])) {
            return null;
        }
        $temp_user = $_SESSION[Consts::USER_SESSION_VARIABLE_NAME];
        if (time() - $temp_user->time > Consts::MAX_LOGIN_SESSION_LENGTH) {
            unset($_SESSION[Consts::USER_SESSION_VARIABLE_NAME]);
            return null;
        }
        return $temp_user->user;
    }

}

UsersModel::init();
