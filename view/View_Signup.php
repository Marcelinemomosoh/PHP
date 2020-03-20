<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Log In</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
       
        <div class="menu">
            
            
        </div>
        <div class="main">
            <form action="user/signup" method="post">
            <div class="title">Sign up</div>
                <table>
                    <tr>
                        <td>UserName:</td>
                        <td><input id="UserName" name="UserName" type="text" value="<?= $UserName ?>"></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input id="Password" name="Password" type="Password" value="<?= $Password ?>"></td>
                    </tr>
                    <tr>
                        <td>confirm Password:</td>
                        <td><input id="Password_confirm " name="Password_confirm" type="Password" value="<?= $Password_confirm ?>"></td>
                    </tr>
                    <tr>
                        <td>FullName:</td>
                        <td><input id="FullName" name="FullName" type="FullName" value="<?= $FullName ?>"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input id="Email" name="Email" type="Email" value="<?= $Email ?>"></td>
                    </tr>
                </table>
                <input type="submit" value="sign up">
            </form>
            <?php if (count($errors) != 0): ?>
                <div class='errors'>
                    <p>Please correct the following error(s) :</p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>