<?php
require_once '../bootstrap.php';

session_start();
$sessionId = session_id();


$create_errors = array();
if(isset($_POST['new-user-email'])){
    try { 
        if(Input::has('new-user-email')){
            $new_email = Input::getString('new-user-email');
        }
    }catch(Exception $e){
        $create_errors[] = $e->getMessage(). ' for the email feild.';
    }

    try { 
        Input::getString('password');
    }catch(Exception $e){
            $create_errors[] = $e->getMessage() . ' for the password feild.';
    }

    if(empty($create_errors)){
        $newPost = $dbc->prepare("INSERT INTO users(email, password) 
        VALUES(:email,:password)");
        $hashedPassword = password_hash(Input::getString('password'), PASSWORD_DEFAULT);
        $newPost->bindValue(':email', $new_email, PDO::PARAM_STR);
        $newPost->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $newPost->execute();
    }
}


if(isset($_POST['email'])){
    try {
        if(Input::has('email')) {
            $email = Input::getString('email');
        }

        // $email = (Input::has('email')) ? Input::getString('email') : null;
    }catch(Exception $e){
        $errors[] = $e->getMessage(). ' for the email feild.';
    }

    try {
        if(Input::has('password')) {
            $password = Input::getString('password');
        }
    }catch(Exception $e){
            $errors[] = $e->getMessage() . ' for the password feild.';
    }

    if(empty($errors)){
        Auth::attempt($email , $password, $dbc);
    }
}


$LOGGED_IN_USER = false;

if (Input::has('username') && Input::has('password')){
    $username = escape(trim(Input::get('username')));
    $password = trim(Input::get('password'));
        
    if (isset($_POST['username'])){
        Auth::attempt($username, $password);
    }
}

if(Auth::checkUser()){
    header("Location: index.php");
    exit();
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
        <span id="site-name">WeGotIt</span>

        <div id="login-form">
            <form method="POST" action="welcome.php">
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
            <input class="new-user" id="new-user-email" type="text" name="new-user-email" placeholder="Email"><br>
            <input class="new-user" id="new-user-password" type="password" name="password" placeholder="Password"><br>
            <button id="submit-button" type="submit">Submit</button>
        </form>
    </div>

</body>
</html>