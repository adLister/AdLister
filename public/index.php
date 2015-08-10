<?php
require_once '../database/db_connect.php';
require_once '../utils/Input.php';
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
    <title>National ads</title>
</head>
<body>
    <h1><u>National ads</u></h1>
    <div id="container_ads">
        <div class="row">
            <? foreach ($ads as $key => $value): ?>
                <div class="col-sm-5">
                    <ul><strong><u><?= $value['title'];?></strong></u>
                        <li>State located in: <?= $value['date_created'];?></li>
                        <li>Date established: <?= $value['image_url'];?></li>
                        <li>Description: <?= $value['description'];?></li>
                    </ul>
                </div>
            <? endforeach;?>
        </div>
    </div>
        <hr>
        <ul class='pager'>
            <?php if($_GET['page'] != $maxpage):?>  
                <li id='next_page'><a href='index.php?page=<?= $_GET['page'] + 1 ?>'>Next Page</a></li>
            <?php endif ?>
            <?php if($_GET['page'] >= 2): ?>    
                <li id='previous_page'><a href='index.php?page=<?= $_GET['page'] - 1 ?>'>Previous Page</a></li>
            <?php endif ?>
        </ul>
    </div>

</body>
</html>