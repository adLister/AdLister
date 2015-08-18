<?php

require_once '../bootstrap.php';

session_start();
$sessionId = session_id();

if (Auth::checkUser()){
    Auth::currentUser();   
} else{
    header("Location: welcome.php");
    exit();
}

if (Input::has('logout') && $_GET['logout'] == 'true'){
    Auth::logoutUser();
    header("Location: welcome.php");
    exit(); 
}

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
        Input::getNumber('price');
    }catch(Exception $e){
            $errors[] = $e->getMessage();
    }
    try { 
        Input::getString('category');
    }catch(Exception $e){
            $errors[] = $e->getMessage();
    }

    if(!empty($_FILES['file']['name'])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileContents = file_get_contents($_FILES["file"]["tmp_name"]);
        $mimeType = $finfo->buffer($fileContents);
        if ($mimeType != "image/png" && $mimeType != "image/gif" && $mimeType != "image/jpeg" && $mimeType != "image/jpg") {
            echo "Img Error: Invalid File Type!";
            exit;
        }else{
            $filename = basename($_FILES['file']['name']);
            $target = 'img/uploads/' . $filename;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                echo '<h1>Your new add post with image '. basename( $_FILES['file']['name']). ' has been uploaded.</h1>';
            }
        }
    }

    // var_dump($_SESSION);
    if(empty($errors) && !empty($_FILES['file']['name'])){
        $newPost = $dbc->prepare("INSERT INTO ads(title, description, image_url, price, category, posting_user) 
        VALUES(:title, :description, :image_url, :price, :category, :posting_user)");
        $newPost->bindValue(':title', Input::getString('title'), PDO::PARAM_STR);
        $newPost->bindValue(':description', Input::getString('description'), PDO::PARAM_STR);
        $newPost->bindValue(':image_url', $filename, PDO::PARAM_STR);
        $newPost->bindValue(':price', Input::getNumber('price'), PDO::PARAM_STR);
        $newPost->bindValue(':category', Input::getString('category'), PDO::PARAM_STR);
        $newPost->bindValue(':posting_user', $_SESSION['LOGGED_IN_USER'], PDO::PARAM_STR);
        $newPost->execute();

        sleep(3);
        header('Location: index.php');
        exit;
    }else{
        $newPost = $dbc->prepare("INSERT INTO ads(title, description, price, category, posting_user) 
        VALUES(:title, :description, :price, :category, :posting_user)");
        $newPost->bindValue(':title', Input::getString('title'), PDO::PARAM_STR);
        $newPost->bindValue(':description', Input::getString('description'), PDO::PARAM_STR);
        $newPost->bindValue(':price', Input::getNumber('price'), PDO::PARAM_STR);
        $newPost->bindValue(':category', Input::getString('category'), PDO::PARAM_STR);
        $newPost->bindValue(':posting_user', $_SESSION['LOGGED_IN_USER'], PDO::PARAM_STR);
        $newPost->execute();

        sleep(3);
        header('Location: index.php');
        exit;
    }

}

if(Input::has('id')){
    $id = Input::get('id');
    $ad = Ad::find($id);
}
$current = $ad->category;
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
    <title>Edit Post</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/css/ads.create.css"> 
    <link rel="stylesheet" href="/css/sidebar.css">

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <h1 id="header">Edit your Post!</h1>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <?= require_once '../views/partials/sidebar.php'; ?>
        </div>
        <div id="errors">
            <?php foreach ($errors as $error):?>
                <p><?= $error ?></p>
            <?php endforeach ?>
        </div>
        <div id="container_ads" class="col-md-9">
            <div id="form">
                <form action="ads.edit.php" method="POST" enctype="multipart/form-data">
                    <label>*Title:</label>
                    <input id="title" type="text" placeholder="Post Title" name="title" value="<?php echo $ad->title; ?>" ><br>

                    <div>
                        <label>*Category:</label>
                        <select id="category" name="category">
                            <?php foreach ($category as $key):?>
                                <option <?= ($key == $current) ? 'selected="selected"' : '' ?>><?= $key; ?></option>
                            <?php endforeach?>
                        </select><br>   

                        <label for="exampleInputFile" name="image_url" id="image_url" accept='image/*' value"<?php echo $ad->image_url; ?>">File input:</label>
                        <input id="exampleInputFile" type="file" name="file">
                        <p class="help-block">Current Photo is: <a id="imgAnchor" href="ads.show.php?id=<?php echo $ad->id; ?>"><?php echo $ad->image_url; ?></a></p>
                        <p class="help-block">Accepts PNG, JPEG, and JPG.</p>

                        <label>*Price: $</label>
                        <input id="price" type="number" placeholder="Price" name="price" value="<?php echo $ad->price; ?>">
                    </div>

                    <label>*Description:</label><br>
                    <textarea id="description" type="text" placeholder="Description" name="description"><?php echo $ad->description; ?></textarea><br>
                    <button id="submit" type="submit">Submit</button>
                    <p id="required">*Required Fields</p>
                </form>
            </div>
        </div>
    </div>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>