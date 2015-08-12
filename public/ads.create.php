<?php

require_once '../bootstrap.php';

$errors = array();
if(!empty($_POST)){
    try { 
        Input::getString('title');
    }catch(Exception $e){
        $errors[] = $e->getMessage();
    }

    try { 
        Input::getString('description');
    }catch(Exception $e){
            $errors[] = $e->getMessage();
    }
    try { 
        Input::getString('category');
    }catch(Exception $e){
            $errors[] = $e->getMessage();
    }

    if($_FILES) {
        $uploads_directory = 'img/uploads/';
        $filename = $uploads_directory . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
            echo '<h1>Your new add post with image '. basename( $_FILES['file']['name']). ' has been uploaded.</h1>';
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    if(empty($errors)){
        $newPost = $dbc->prepare("INSERT INTO ads(title, description, image_url,category) 
        VALUES(:title,:description,:image_url,:category)");
        $newPost->bindValue(':title', Input::getString('title'), PDO::PARAM_STR);
        $newPost->bindValue(':description', Input::getString('description'), PDO::PARAM_STR);
        $newPost->bindValue(':image_url', $filename, PDO::PARAM_STR);
        $newPost->bindValue(':category', Input::getString('category'), PDO::PARAM_STR);
        $newPost->execute();
    }
}

$category = array(
'Accounting & Finance',
'Admin & Office',
'Appliances',
'Art/Media/Design',
'Arts & Crafts',
'Auto Parts',
'Automotive',
'Baby & kid',
'Biotech & Science',
'Books',
'Business/Mgmt',
'Cars & Trucks',
'Computer & Technology',
'Computers & Electronics',
'Customer Service',
'Education',
'Event',
'Furniture',
'Human Resources',
'Internet Engineers',
'Legal',
'Legal/Peralegal',
'Lessons',
'Medical/Health',
'Music',
'Pet',
'Real Estate',
'Realator',
'Salon/Spa/Fitness',
'Security',
'Software/QA/DBA',
'Sports & Outdoors',
'Technical Support',
'Tools',
'Transport',
'Video Gaming',
'Writing/Editing');
?>

<html>
    <head>
        <title>Add Post</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        <link rel="stylesheet" href="/css/ads.create.css"> 
        <link rel="stylesheet" href="/css/custom.css"> 
    </head>
    <body>
        <h2 id="header">Create a new post!</h2>
        <div id="container">
            <div id="errors">
                <?php foreach ($errors as $error):?>
                    <p><?= $error ?></p>
                <?php endforeach ?>
            </div>

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
                        <p class="help-block">Accepts PNG, JPEG, JPG, and GIFS.</p>
                    </div>

                    <label>*Description:</label><br>
                    <textarea id="description" type="text" placeholder="Description" name="description" value="<?php if(!empty($_POST['description'])){ echo $_POST['description'];}?>"></textarea><br>
                    <button id="submit" type="submit">Submit</button>
                    <p id="required">*Required Fields</p>
                </form>
            </div>
        </div>
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>