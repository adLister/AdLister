<?php

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

$category = str_replace('-', ' ', Input::get('category'));

if(empty($_GET['page'])){
   $page = '1';
}else{
    $page=$_GET['page'];
}

$userPosts = Ad::paginateCategories(10,(($page-1) * 10), $category);
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
    <h1><?= $category ?></h1>
    <hr>
    <div class="row">
        <div class="col-md-3">
           <?= require_once '../views/partials/sidebar.php'; ?>
        </div>
        <div id="container_ads" class="col-md-9">
            <div>
                <?php 
                    $max = $userPosts->attributes['maxpage'];
                    unset($userPosts->attributes['maxpage']);
                ?>
                <? foreach ($userPosts->attributes as $key => $value): ?>
                    <?php if($value['category'] == "$category"):?>
                        <div id="most_recent" class="col-sm-12">
                            <div class="row">
                                <a  class="ads-href" href="/ads.show.php?id=<?= $value['id'] ?>">
                                <strong><u><?= $value['title'];?></u></strong>
                                <ul>
                                    <div id="post_details" class="col-sm-6">
                                        <li>Date Created: <?= $value['date_created'];?></li>
                                        <li>Price: $<?= $value['price'];?></li>
                                        <li>Description: <?= $value['description'];?></li>
                                        <?php if($value['image_url']):?>
                                            <li class="ads-href">This add includes Photos</li></a>
                                        <?php endif; ?>
                                    </div>
                                </ul>
                            </div><br>
                        </div>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
            <div>
                <ul class="pager">
                    <?php if($page >= 2): ?>    
                        <li id="previous_page" class="pager-buttons"><a href='categories.php?page=<?= $page - 1 ?>'>Previous Page</a></li>
                    <?php endif ?>
                    
                    <?php if($page != $max):?>  
                        <li id="next_page" class="pager-buttons"><a href='categories.php?page=<?= $page + 1 ?>'>Next Page</a></li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>