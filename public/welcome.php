<?php
require_once '../bootstrap.php';


$errors = array();
if(!empty($_POST)){
    try { 
        Input::getString('email');
    }catch(Exception $e){
        $errors[] = $e->getMessage(). ' for the email feild.';
    }

    try { 
        Input::getString('password');
    }catch(Exception $e){
            $errors[] = $e->getMessage() . ' for the password feild.';
    }

    if(empty($errors)){
        $newPost = $dbc->prepare("INSERT INTO users(email, password) 
        VALUES(:email,:password)");
        $newPost->bindValue(':email', Input::getString('email'), PDO::PARAM_STR);
        $newPost->bindValue(':password', Input::getString('password'), PDO::PARAM_STR);
        $newPost->execute();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>

    <link rel="stylesheet" href="/css/welcome.css"> 
</head>
<body>
    <div id="header">
        <span id="site-name">Site Name</span>

        <div id="login-form">
            <form>
                <div id="email">
                    </label>Email: </label><br>
                    <input class="login" id="input-email" type="text" name="email" placeholder="Email" autofocus>
                </div>
                <div id="password">
                    <label>Password: </label><br>
                    <input class="login" id="password" type="password" name="password" placeholder="Password">
                </div><br>
                <button id="login-button" type="submit">Login</button>
            </form>
        </div>
    </div>
    <div id="sign-up">
        <div id="sub-header">
            <h1>Sign Up!</h1>
        </div>
        <form action="welcome.php" method="POST">
            <input class="new-user" id="new-user-email" type="text" name="email" placeholder="Email"><br>
            <input class="new-user" id="new-user-password" type="password" name="password" placeholder="Password"><br>
            <button id="submit-button" type="submit">Submit</button>
        </form>
    </div>

</body>
</html>