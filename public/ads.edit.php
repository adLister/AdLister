<?php

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Post</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/css/ads.create.css"> 
    <link rel="stylesheet" href="/css/custom.css"> 
</head>
<body>
    <h2 id="header">Edit your post!</h2>

	<div id="form">
	    <form action="ads.create.php" method="POST" enctype="multipart/form-data">
	        <label>*Title:</label>
	        <input id="title" type="text" placeholder="Post Title" name="title" value="<?php if(!empty($_POST['title'])){ echo $_POST['title'];}?>"autofocus><br>

	        <div>
	            <label>*Category:</label>
	            <select id="category" name="category">
	                <?php foreach ($category as $key):?>
	                    <option><?= $key; ?></option>
	                <?php endforeach?>
	            </select><br>   

	            <label for="exampleInputFile" name="image_url" id="image_url" accept='image/*'>File input:</label>
	            <input id="exampleInputFile" type="file" name="file">
	            <p class="help-block">Accepts PNG, JPEG, and JPG.</p>

	            <label>*Price:</label>
	            <input id="price" type="number" placeholder="Price" name="price" value="<?php if(!empty($_POST['price'])){ echo $_POST['price'];}?>">
	        </div>

	        <label>*Description:</label><br>
	        <textarea id="description" type="text" placeholder="Description" name="description" value="<?php if(!empty($_POST['description'])){ echo $_POST['description'];}?>"></textarea><br>
	        <button id="submit" type="submit">Submit</button>
	        <p id="required">*Required Fields</p>
	    </form>
	</div>
</body>
</html>