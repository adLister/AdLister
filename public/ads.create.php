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

    if(!empty($_FILES['file'])) {
        $filename = basename($_FILES['file']['name']);
        $target = 'img/uploads/' . $filename;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            echo '<h1>Your new add post with image '. basename( $_FILES['file']['name']). ' has been uploaded.</h1>';
        }
    }

    if(empty($errors) && !empty($_FILES['file'])){
        $newPost = $dbc->prepare("INSERT INTO ads(title, description, image_url, category) 
        VALUES(:title, :description, :image_url, :category)");
        $newPost->bindValue(':title', Input::getString('title'), PDO::PARAM_STR);
        $newPost->bindValue(':description', Input::getString('description'), PDO::PARAM_STR);
        $newPost->bindValue(':image_url', $filename, PDO::PARAM_STR);
        $newPost->bindValue(':category', Input::getString('category'), PDO::PARAM_STR);
        $newPost->execute();

        sleep(3);
        header('Location: index.php');
        exit;
    }else{
        $newPost = $dbc->prepare("INSERT INTO ads(title, description, category) 
        VALUES(:title, :description, :category)");
        $newPost->bindValue(':title', Input::getString('title'), PDO::PARAM_STR);
        $newPost->bindValue(':description', Input::getString('description'), PDO::PARAM_STR);
        $newPost->bindValue(':category', Input::getString('category'), PDO::PARAM_STR);
        $newPost->execute();

        sleep(3);
        header('Location: index.php');
        exit;
    }

}

$category = array(
'Accounting and Finance',
'Admin and Office',
'Appliances',
'Art/Media/Design',
'Arts and Crafts',
'Auto Parts',
'Automotive',
'Baby and kid',
'Biotech and Science',
'Books',
'Business/Mgmt',
'Cars and Trucks',
'Computer and Technology',
'Computers and Electronics',
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
'Sports and Outdoors',
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
                        <p class="help-block">Accepts PNG, JPEG, and JPG.</p>
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