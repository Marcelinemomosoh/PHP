<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>stuck overflow </title>

        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
    <div id="barre">stuck overflow <?php if($user) echo $user->UserName; ?>
    <div id="question">
    <?php if(!$user): ?>
        <a href="user/signup">inscription</a>
        <a href="user/login">connexion</a>
    <?php else: ?>
        <a href="user/logout">logout</a>
    <?php endif; ?>
    </div>



    </div>
        
        <div class="menu">
           <a href="post/index">newest</a>
            <a href="post/index">active</a>
            <a href="post/unanswered">unanswered</a>
            <a href="post/vote">votes</a>
            
        </div>
        <div class="newest">
          
              
              <?php foreach ($posts as $post): ?>
            <div class="post" style="padding: 5px; margin: 10px;">
                <h4><a href="post/read_question/<?php echo $post->PostId; ?>"><?= $post->Title ?></a></h4>
                <p><?= $post->Body ?></p>
                <p>Asked <span><?= $post->Timestamp ?></span> by <?= $post->User() ?></p>
            </div>
        <?php endforeach; ?>
       
              
            
                
        </div>
    </body>
</html>