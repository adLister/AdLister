<?php
require_once '../utils/Auth.php';
require_once '../utils/Input.php';
require_once '../database/db_connect.php';
require_once '../bootstrap.php';

session_start();
$sessionId = session_id();

if (Auth::checkUser()){
    $username = Auth::currentUser();   
} else{
    header("Location: welcome.php");
    exit();
}

if (Input::has('logout') && $_GET['logout'] == 'true'){
    Auth::logoutUser();
    header("Location: welcome.php");
    exit(); 
}

if(empty($_GET)){
   $_GET['page'] = '1';
}

$category = str_replace('-', ' ', Input::get('category'));
// str_replace('-', ' ', $category);
$ads = Ad::categorySeach($category);


?>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/custom.css"> 

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <div>
    <?= require_once '../views/partials/sidebar.php'; ?>

    <h1>Most Recent</h1>
    <!-- <hr> -->
    <div id="container_ads">
        <div class="row">
            <? foreach ($ads->attributes as $key => $value): ?>
            <?php if($value['category'] == "$category"):?>
                <div id="most_recent" class="col-sm-8">
                    <ul>
                        <?php if($value['image_url']):?><p><img src="../img/uploads/<?= $value['image_url'];?>" alt=""></p><?php endif; ?>
                        <div id="post_details">
                            <strong><u><?= $value['title'];?></strong>
                            <li>Date Created: <?= $value['date_created'];?></li>
                            <li>Description: <?= $value['description'];?></li>
                        </div>
                    </ul>
                </div>
        <? endif; ?>
            <? endforeach; ?>
        </div>
    </div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>