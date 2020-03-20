<?php

require_once 'framework/Model.php';

class User extends Model
{

    public $UserId;
    public $UserName;
    public $Password;
    public $FullName;
    public $Email;

    public function __construct($UserName, $Password, $FullName, $Email, $UserId = -1)
    {

        $this->UserId = $UserId;
        $this->UserName = $UserName;
        $this->Password = $Password;
        $this->FullName = $FullName;
        $this->Email = $Email;
    }

    public static function get_User_by_UserName($UserName)
    {
        $query = self::execute("SELECT * FROM User where UserName = :UserName", array("UserName" => $UserName));
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["UserName"], $data["Password"], $data["FullName"], $data["Email"], $data["UserId"]);
        }
    }

    public static function validate_login($UserName, $Password)
    {
        $errors = [];
        $User = User::get_User_by_UserName($UserName);
        if ($User) {
            if (!self::check_password($Password, $User->Password)) {
                $errors[] = "mauvais password. essaie encore.";
            }
        } else {
            $errors[] = "Can't find a User with the UserName '$UserName'. Please sign in.";
        }
        return $errors;
    }

    private static function check_password($clear_password, $hash)
    {
        return $hash === Tools::my_hash($clear_password);
    }
    public function validate()
    {
        $errors = array();
        if (!(isset($this->UserName) && is_string($this->UserName) && strlen($this->UserName) > 3)) {
            $errors[] = "username is required.";
        }
        if (!(isset($this->FullName))) {
            $errors[] = "fullname is require";
        } else if (!(strlen($this->FullName) > 2)) {
            $errors[] = "fullname ne peut pas etre inférieur à 3 charactères";
        }
        if (!filter_var($this->Email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "email est mauvaise.";
        }
        return $errors;
    }
    public static function validate_unicity($UserName)
    {
        $errors = [];
        $UserName = self::get_user_by_UserName($UserName);
        if ($UserName) {
            $errors[] = "se user existe deja .";
        }
        return $errors;
    }
    private static function validate_password($password)
    {
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "Password est inferieur à 8.";
        }
        if (!((preg_match("/[A-Z]/", $password)) && preg_match("/\d/", $password) && preg_match("/['\";:,.\/?\\-]/", $password))) {
            $errors[] = "Password ne verifie pas la syntaxe requise.";
        }
        return $errors;
    }
    public static function validate_passwords($Password, $Password_confirm)
    {
        $errors = user::validate_password($Password);
        if ($Password != $Password_confirm) {
            $errors[] = "vous n'avez pas inscrit le bon mot de passe.";
        }
        return $errors;
    }
    public function add()
    {
        self::execute(
            "INSERT INTO User(UserName,Password,FullName,Email) VALUES(:UserName,:Password,:FullName,:Email)",
            array("UserName" => $this->UserName, "Password" => $this->Password, "FullName" => $this->FullName, "Email" => $this->Email)
        );
        return $this;
    }

    public static function get_User_by_UserId($UserId)
    {
        $query = self::execute("SELECT * FROM User where UserId = :UserId", array("UserId" => $UserId));
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["UserName"], $data["Password"], $data["FullName"], $data["Email"], $data["UserId"] );
        }
    }
}
