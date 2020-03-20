<?php
require_once 'User.php';
require_once 'framework/Model.php';

class Vote extends model
{
    public $UserId;
    public $PostId;
    public $UpDown;

    public function User(){
        return User::get_User_by_UserId($this->UserId);
    }

    public function __construct($UserId, $PostId, $UpDown){
        $this->UserId = $UserId;
        $this->PostId = $PostId;
        $this->UpDown = $UpDown;
    }

    
    public static function get_votes_by_PostId($PostId) {
        $query = self::execute("SELECT * FROM Vote where PostId = :PostId", array("PostId"=>$PostId));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Vote($row["UserId"], $row["PostId"], $row["UpDown"]);
        }
        return $results;
    }

}
