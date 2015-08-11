<?php
require_once '../bootstrap.php';


session_start();
$sessionId = session_id();

$LOGGED_IN_USER = false;

if (Input::has('username') && Input::has('password')){
    $username = escape(trim(Input::get('username')));
    $password = trim(Input::get('password'));
        
    if (isset($_POST['username'])){
        Auth::attempt($username, $password);
    }
}

if(Auth::check()){
    header("Location: http://codeup.dev/authorized.php");
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
        <span id="site-name">Site Name</span>

        <div id="login-form">
            <form>
                <div id="username">
                    </label>Email: </label><br>
                    <input class="login" id="username" type="text" name="username" placeholder="Username" autofocus>
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
        <form>
            <!-- </label>Email: </label><br> -->
            <input class="new-user" id="new-user-email" type="text" name="email" placeholder="Email"><br>
            <!-- <label>Password: </label><br> -->
            <input class="new-user" id="new-user-password" type="password" name="password" placeholder="Password"><br>
            <button id="submit-button" type="submit">Submit</button>
        </form>
    </div>

</body>
</html>