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

if(empty($_GET)){
   $_GET['page'] = '1';
}

$category = str_replace('-', ' ', Input::get('category'));
$ads = Ad::categorySearch($category);

// $errors = array();
// $limit = 5;
// $offset = (($_GET['page']-1) * $limit);

// if(empty($_GET)){
//     header("Location: categories.php?category=$category&page=1");
//     exit();
// }

// $stmt = $dbc->prepare("SELECT * FROM ads LIMIT :limit OFFSET :offset");
// $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
// $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
// $stmt->execute();
// $ads= $stmt->fetchAll(PDO::FETCH_ASSOC);

// $count = $dbc->query('SELECT count(*) FROM ads');
// $stmt1 = $count->fetchColumn();
// $maxpage = ceil($stmt1 / $limit);

// if($_GET['page'] > $maxpage || !is_numeric($_GET['page']) || $_GET['page'] < 1){    
//     header("location: ?page=$maxpage");
//     exit();
// }
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
                <? foreach ($ads->attributes as $key => $value): ?>
                    <?php if($value['category'] == "$category"):?>
                        <div id="most_recent" class="col-sm-12">
                            <div class="row">
                                <a href="/ads.show.php?id=<?= $value['id'] ?>">
                                <strong><u><?= $value['title'];?></strong>
                                <ul>
                                    <div id="post_details" class="col-sm-6">
                                        <li>Date Created: <?= $value['date_created'];?></li>
                                        <li>Price: $<?= $value['price'];?></li>
                                        <li>Description: <?= $value['description'];?></li></a>
                                        <?php if($value['image_url']):?>
                                            <li>This add includes Photos</li>
                                        <?php endif; ?>
                                    </div>
                                </ul>
                            </div><br>
                        </div>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
    <!--    <div>
                <ul class="pager">
                    <?php if($_GET['page'] >= 2): ?>    
                        <li id="previous_page" class="pager-buttons"><a href='index.php?page=<?= $_GET['page'] - 1 ?>'>Previous Page</a></li>
                    <?php endif ?>
                    
                    <?php if($_GET['page'] != $maxpage):?>  
                        <li id="next_page" class="pager-buttons"><a href='index.php?page=<?= $_GET['page'] + 1 ?>'>Next Page</a></li>
                    <?php endif ?>
                </ul>
            </div> -->
        </div>
    </div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>