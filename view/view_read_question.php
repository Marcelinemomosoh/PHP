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
        <h1><?php echo $post->Title; ?></h1>
        <p>Asked <span><?= $post->Timestamp ?></span> by <?= $post->User() ?></p>
        <div><?php echo $post->getBody(); ?></div>

    </body>
</html>