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

$errorMessage = 'Add an Ad';

$stmt = $dbc->prepare("SELECT * FROM ads LIMIT :limit OFFSET :offset");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$ads= $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $dbc->query('SELECT count(*) FROM ads');
$stmt1 = $count->fetchColumn();
$maxpage = ceil($stmt1 / $limit);

if(!empty($_POST)){
    try { 
        Input::getString('name');
    }catch(Exception $e){
        $errors[] = $e->getMessage(). ' for the name feild.';
    }

    try { 
        Input::getString('location');
    }catch(Exception $e){
        $errors[] = $e->getMessage() . ' for the location feild.';
    }

    try { 
        Input::getDate('date_established');
    }catch(Exception $e){
        $errors[] = $e->getMessage();
    }

    try { 
        Input::getNumber('area_in_acres');
    }catch(Exception $e){
        $errors[] = $e->getMessage();
    }

    try { 
        Input::getString('description');
    }catch(Exception $e){
            $errors[] = $e->getMessage() . ' for the description feild.';
    }
        if(empty($errors)){
            $newPost = $dbc->prepare("INSERT INTO ads(name, location, date_established, area_in_acres, description) 
            VALUES(:name,:location,:date_established,:area_in_acres,:description)");
            $newPost->bindValue(':name', Input::getString('name'), PDO::PARAM_STR);
            $newPost->bindValue(':location', Input::getString('location'), PDO::PARAM_STR);
            $newPost->bindValue(':date_established', Input::getDate('date_established'), PDO::PARAM_STR);
            $newPost->bindValue(':area_in_acres', Input::getNumber('area_in_acres'), PDO::PARAM_STR);
            $newPost->bindValue(':description', Input::getString('description'), PDO::PARAM_STR);
            $newPost->execute();
        }
}


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
    <div id="container">
        <h2><u><?= $errorMessage ?></u></h2>
        <?PHP foreach ($errors as $error):?>
            <p><?= $error ?></p>
        <?PHP endforeach ?>
        <div id="form">
            <form method="POST">
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['name'])){ echo $_POST['name'];}?>" placeholder="Park Name" name="name" id="name" required="" aria-describedby="basic-addon1">
                </div>
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['location'])){ echo $_POST['location'];}?>" placeholder="State" name="location" required="" aria-describedby="basic-addon1">
                </div>          
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['date_established'])){ echo $_POST['date_established'];}?>" placeholder="YYYY-MM-DD" name="date_established"  aria-describedby="basic-addon1">
                </div>          
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['area_in_acres'])){ echo $_POST['area_in_acres'];}?>" placeholder="Area in Acres" name="area_in_acres" required="" aria-describedby="basic-addon1">
                </div>          
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['description'])){ echo $_POST['description'];}?>" placeholder="Description" name="description" required="" aria-describedby="basic-addon1">
                </div>
                <button class="btn btn-lg btn-info btn-block"type="submit">Submit</button>
            </form>
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