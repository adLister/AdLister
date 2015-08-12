<?php

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
    <?= require_once '../views/partials/sidebar.php'; ?>
    <?php if ($value['title'] == ) : ?>
	    <? foreach ($ads as $key => $value): ?>
	        <div id="most_recent" class="col-sm-8">
	            <ul>
	                <?php if($value['image_url']):?><p><img src="img/uploads/<?= $value['image_url'];?>" alt=""></p><?php endif ?>
	                <div id="post_details">
	                    <strong><u><?= $value['title'];?></strong>
	                    <li>Date Created: <?= $value['date_created'];?></li>
	                    <li>Description: <?= $value['description'];?></li>
	                </div>
	            </ul>
	        </div>
	    <? endforeach; ?>
	<? endif ?>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>