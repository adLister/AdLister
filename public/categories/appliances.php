<?php
require_once '../../utils/Auth.php';
require_once '../../utils/Input.php';
require_once '../../database/db_connect.php';
require_once '../../bootstrap.php';

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

$limit = 5;
$offset = (($_GET['page']-1) * $limit);

if(empty($_GET)){
    header('location: ?page=1');
    exit();
}

$stmt = $dbc->prepare("SELECT * FROM ads LIMIT :limit OFFSET :offset");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$ads= $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $dbc->query('SELECT count(*) FROM ads');
$stmt1 = $count->fetchColumn();
$maxpage = ceil($stmt1 / $limit);

if($_GET['page'] > $maxpage || !is_numeric($_GET['page']) || $_GET['page'] < 1){    
    header("location: ?page=$maxpage");
    exit();
}
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
    <?= require_once '../../views/partials/sidebar.php'; ?>

    <h1>Most Recent</h1>
    <!-- <hr> -->
    <div id="container_ads">
        <div class="row">
            <?php var_dump($ads);?>
            <? foreach ($ads as $key => $value): ?>
            <?php if($value['category'] == 'Appliances'):?>
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
        <div>
            <ul class="pager">
                <?php if($_GET['page'] >= 2): ?>    
                    <li id="previous_page" class="pager-buttons"><a href='index.php?page=<?= $_GET['page'] - 1 ?>'>Previous Page</a></li>
                <?php endif ?>
                
                <?php if($_GET['page'] != $maxpage):?>  
                    <li id="next_page" class="pager-buttons"><a href='index.php?page=<?= $_GET['page'] + 1 ?>'>Next Page</a></li>
                <?php endif ?>
            </ul>
        </div>
    </div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>