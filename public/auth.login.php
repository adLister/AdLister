<?php
require_once '../function.php';
require_once '../Auth.php';
require_once '../Input.php';


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
    <title>Login</title>

    <link rel="stylesheet" href="/css/login.css">
</head>
<body>

    <h2>Login</h2>
    <div>
        <form method="POST">
            <input id="username" type="text" name="username" placeholder="Username" autofocus><br>
            <input id="password" type="password" name="password" placeholder="Password"><br>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>