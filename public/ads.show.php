<?php
require_once '../bootstrap.php';

$id = Input::get('id');
$ads = Ad::idSearch($id);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Single Ad</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/custom.css"> 
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<h1><?= $ads->attributes['0']['title']; ?></h1>
	<hr>
	<div class="row">
		<div class="col-md-3">
	    	<?= require_once '../views/partials/sidebar.php';?>
	    </div>
	    <div id="container_ads" class="col-md-9">
	        <div class="row">
	            <? foreach ($ads->attributes as $key => $value): ?>
	                <?php if($value['id'] == "$id"):?>
	                    <div id="most_recent">
	                        <ul>
	                            <?php if($value['image_url']):?>
	                                <p><img src="../img/uploads/<?= $value['image_url'];?>" alt=""></p>
	                            <?php endif; ?>
	                            <br>
	                            <div id="post_details">
	                                <li>Date Created: <?= $value['date_created'];?></li>
	                                <li>Price: $<?= $value['price'];?></li>
	                                <li>Description: <?= $value['description'];?></li>
	                            </div>
	                        </ul>
	                    </div>
	                <? endif; ?>
	            <? endforeach; ?>
	        </div>
	    </div>
	</div>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>