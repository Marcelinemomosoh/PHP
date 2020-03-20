<?php
require_once 'User.php';
require_once 'framework/Model.php';
require_once 'Vote.php';
require_once 'lib/parsedown-1.7.3/parsedown.php';

class Post extends Model {
    public $PostId;
    public $AuthorId;
    public $Title;
    public $Body;
    public $Timestamp;
    public $AcceptedAnswerId;
    public $ParentId;

    
    
    public function __construct( $PostId =-1,$AuthorId,$Title, $Body,$Timestamp,$AcceptedAnswerId,$ParentId) {

        $this->PostId= $PostId;
        $this->AuthorId = $AuthorId;
        $this->Title = $Title;
        $this->Body = $Body;
        $this->Timestamp = $Timestamp;
        $this->AcceptedAnswerId = $AcceptedAnswerId;
        $this->Timestamp = $Timestamp;
        $this->ParentId=$ParentId;
    }

    public  function get_Reponses_by_ParentId() {
        $query = self::execute("SELECT * FROM Post where ParentId = :ParentId", array("ParentId"=>$this->PostId));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Post($row["PostId"], $row["AuthorId"], $row["Title"],$row["Body"],$row["Timestamp"],$row["AcceptedAnswerId"],$row["ParentId"]);
        }
        return $results;
    }

    public function getBody(){
        $Parsedown=new Parsedown();
        $Parsedown->setsafeMode(true);
        $body=$Parsedown->text($this->Body);
        return $body;
    }

    public function User(){
        return User::get_User_by_UserId($this->AuthorId)->FullName." ".User::get_User_by_UserId($this->AuthorId)->UserName;
    }

    public function votes(){
        return Vote::get_votes_by_PostId($this->PostId);
    }

    public static function newest() {
        $query = self::execute("SELECT * FROM post where ParentId is null ORDER BY Timestamp desc ",array());
        $data = $query->fetchall(); 
    //   if ($query->rowCount() == 0) {
    //       return false;
        $results = [];
        foreach ($data as $row) {
            $results[] = new Post($row["PostId"], $row["AuthorId"], $row["Title"], $row["Body"], 
            $row["Timestamp"], $row["AcceptedAnswerId"], $row["ParentId"]);
        }
        return $results;
    }
    public static function vote(){
        $query = self::execute("SELECT post.*, max_score
        FROM post, (
            SELECT parentid, max(score) max_score
            FROM (
                SELECT post.postid, ifnull(post.parentid, post.postid) parentid, ifnull(sum(vote.updown), 0) score
                FROM post LEFT JOIN vote ON vote.postid = post.postid
                GROUP BY post.postid
            ) AS tbl1
            GROUP by parentid
        ) AS q1
        WHERE post.postid = q1.parentid
        ORDER BY q1.max_score DESC, timestamp DESC  ",array());
        $data = $query->fetchall(); 
       $results = [];
       foreach ($data as $row) {
           $results[] =  new Post($row["PostId"], $row["AuthorId"], $row["Title"], $row["Body"], 
           $row["Timestamp"], $row["AcceptedAnswerId"], $row["ParentId"]);
       }
       return $results; 
    
    }
    public static function unanswered(){
        $query=self::execute("SELECT * FROM post WHERE AcceptedAnswerId is NULL and ParentId is null ",array());
        $data=$query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] =   new Post($row["PostId"], $row["AuthorId"], $row["Title"], $row["Body"], 
            $row["Timestamp"], $row["AcceptedAnswerId"], $row["ParentId"]);
        }
        return $results;
    }
    public static function getPostbyId($PostId){
        $query = self::execute("SELECT * FROM Post where PostId = :PostId", array("PostId"=>$PostId));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Post($row["PostId"], $row["AuthorId"], $row["Title"],$row["Body"],$row["Timestamp"],$row["AcceptedAnswerId"],$row["ParentId"]);
        }
        return $results;
    }

    public static function getOnePostbyId($PostId){
        $query = self::execute("SELECT * FROM Post where PostId = :PostId", array("PostId"=>$PostId));
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Post($data["PostId"], $data["AuthorId"], $data["Title"],$data["Body"],$data["Timestamp"],$data["AcceptedAnswerId"],$data["ParentId"]);
        }
    }

    public  function getResponses(){
        $query = self::execute("SELECT * FROM Post where ParentId = : PostId " , array($this->ParentId));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Post($row["PostId"], $row["AuthorId"], $row["Title"],$row["Body"],$row["Timestamp"],$row["AcceptedAnswerId"],$row["ParentId"]);
        }
        return $results;
    }
    public  function getCountResponses(){
        $query = self::execute("SELECT * FROM Post where ParentId = : PostId " , array($this->ParentId));
        
        return $query->rowcount();
    }
    public function getScore(){
        $query = self::execute("SELECT SUM(UpDown) from vote where PostId = : PostId", array("PostId"=> $this->PostId));
        return $query;
    }
    public function getVotes(){
        $query = self ::execute("SELECT * FROM vote   where PostId =:PostId  ", array("PostId"=>$this->PostId));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Vote($row["UserId"],$row["PostId"],$row["UpDown"]);
        }
        return $results;
    }
    public function getParent(){
        $query = self::execute("SELECT * FROM Post where PostId = : ParentId " , array("PostId"=>$this->ParentId));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Post($row["PostId"], $row["AuthorId"], $row["Title"],$row["Body"],$row["Timestamp"],$row["AcceptedAnswerId"],$row["ParentId"]);
        }
        return $results;
    }
    // public function getHightScore(){
    //     $query = self::execute("SELECT MAX(UpDown) from vote where PostId = : PostId", array("PostId"=> $this->PostId));
    //     return $query;
    // }
   
     
    

    

}
    