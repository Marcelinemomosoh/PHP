<?php
require_once 'model/Post.php';
require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerPost extends Controller
{
    public function index()
    {
        $user = $this->get_user_or_false();
        $posts = Post::newest();
        (new View("index"))->show(array("posts" => $posts, "user" => $user));
    }

    // public function newest()
    // {
    //     $posts = Post::newest();
    //     (new View("index"))->show(array("posts"=>$posts ));
    // }
    public function vote()
    {
        $user = $this->get_user_or_false();
        $posts = Post::vote();
        (new View("index"))->show(array("posts" => $posts, "user" => $user));
    }

    public function unanswered()
    {
        $user = $this->get_user_or_false();
        $posts = Post::unanswered();
        (new View("index"))->show(array("posts" => $posts, "user" => $user));
    }

    public  function read_question()
    {
        $user = $this->get_user_or_false();
        $id = $_GET['param1'];
        
        $post = POST::getOnePostbyId($id);

        (new View("read_question"))->show(array("post" => $post, "user" => $user));
    }
    
    public function getTimestamp($full=false){
        $now=new DateTime;
        $ago=new DateTime($this->Timestamp);
        $diff=$now->diff($ago);

        $diff->w=floor($diff->d/7);
        $diff->d-=$diff->w*7;

        $string =array(
            'y'=>'year',
            'm'=>'month',
            'w'=>'week',
            'd'=>'day',
            'h'=>'hour',
            'i'=>'minute',
            's'=>'second',
        );
        foreach($string as $k =>&$v){
            if($diff->$k){
                $v=$diff->$k.''.$v.($diff->$k>1?'s':'');

            }
            else{
              unset($string[$k]);
            }


        }
        if(!$full)$string=array_slice($string,0,1);
        return $string? implode(',',$string).'ago': 'just now';
    }
}
