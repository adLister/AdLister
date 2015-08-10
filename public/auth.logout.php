<?php
require_once '../function.php';
require_once '../Auth.php';
require_once '../Input.php';

session_start();

if (Input::has('reset') && $_GET['reset'] == 'true'){
    Auth::logout();
    header("Location: http://codeup.dev/login.php");
    exit(); 
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>

    <link rel="stylesheet" href="/css/logout.css">
</head>
<body>

    <h2 align="center">You have been successfully logged out</h2>
    <a href="?reset=true">Login Again?</a>

</body>
</html>