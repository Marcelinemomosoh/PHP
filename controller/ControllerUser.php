<?php
require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerUser extends Controller {

    public function index() {
        //   if ($this->user_logged()) {
            $this->redirect("post", "index");
        // } else {
            // (new View("index" ))->show();
        // }
    }
    
    public function login() {
        $UserName = '';
        $Password = '';
        $errors = [];
        if (isset($_POST['UserName']) && isset($_POST['Password'])) { 
            $UserName = $_POST['UserName'];
            $Password = $_POST['Password'];

            $errors = User::validate_login($UserName, $Password);
            if (empty($errors)) {
                $this->log_user(User::get_User_by_UserName($UserName));
            }
        }
        (new View("login"))->show(array("UserName" => $UserName, "Password" => $Password, "errors" => $errors));
    }
    //gestion de l'inscription d'un utilisateur
    public function signup() {
        $UserName = '';
        $Password = '';
        $Password_confirm = '';
        $FullName = '';
        $Email = '';
        $errors = [];

        if (isset($_POST['UserName']) && isset($_POST['Password']) && isset($_POST['Password_confirm']) && isset($_POST['FullName'])&& isset($_POST['Email'])) {
            $UserName = trim($_POST['UserName']);
            $password = $_POST['Password'];
            $password_confirm = $_POST['Password_confirm'];
            $FullName = $_POST['FullName'];
            $Email = $_POST['Email'];

            $user = new User($UserName, Tools::my_hash($password),$FullName,$Email);
            $errors = User::validate_unicity($UserName);
            $errors = array_merge($errors, $user->validate());
            $errors = array_merge($errors, User::validate_passwords($password, $password_confirm));

            if (count($errors) == 0) { 
                $user->add(); //sauve l'utilisateur
                $this->log_user($user);
            }
        }
        (new View("signup"))->show(array("UserName" => $UserName, "Password" => $Password, 
                                         "Password_confirm" => $Password_confirm,
                                         "FullName" => $FullName,"Email" => $Email, "errors" => $errors));
    }
    

}