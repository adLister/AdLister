<?php
require_once '../bootstrap.php';

$errors = array();
$limit = 4;
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

    <link rel="stylesheet" href="/css/sidebar.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/custom.css"> 
</head>

<body>
    <div>
    <?= require_once '../views/partials/sidebar.php'; ?>

    <h1>Most Recent</h1>
    <div id="container_ads">
        <div class="row">
            <? foreach ($ads as $key => $value): ?>
                <div id="most_recent" class="col-sm-8">
                    <ul><strong><u><?= $value['title'];?></strong></u>
                        <p><img src="<?= $value['image_url'];?>" alt=""></p>
                        <li>Date Created: <?= $value['date_created'];?></li>
                        <li>Description: <?= $value['description'];?></li>
                    </ul>
                </div>
            <? endforeach; ?>
        </div>
        <div>
            <ul class="pager">
                <?php if($_GET['page'] >= 2): ?>    
                    <li id='previous_page'><a href='index.php?page=<?= $_GET['page'] - 1 ?>'>Previous Page</a></li>
                <?php endif ?>
                
                <?php if($_GET['page'] != $maxpage):?>  
                    <li id='next_page'><a href='index.php?page=<?= $_GET['page'] + 1 ?>'>Next Page</a></li>
                <?php endif ?>
            </ul>
        </div>
    </div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>