<?PHP

require_once '../bootstrap.php';
$errors = array();
if(!empty($_POST)){
    try { 
        Input::getString('title');
    }catch(Exception $e){
        $errors[] = $e->getMessage(). ' for the title feild.';
    }

    try { 
        Input::getString('description');
    }catch(Exception $e){
            $errors[] = $e->getMessage() . ' for the description feild.';
    }
    try { 
        Input::getString('category');
    }catch(Exception $e){
            $errors[] = $e->getMessage() . ' for the category feild.';
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
'Art/Media/Design',
'Biotech & Science',
'Business/Mgmt',
'Customer Service',
'Education',
'Human Resources',
'Internet Engineers',
'Legal/Peralegal',
'Medical/Health',
'Real Estate',
'Salon/Spa/Fitness',
'Security',
'Software/QA/DBA',
'Technical Support',
'Transport',
'Writing/Editing',
'Appliances',
'Arts & Crafts',
'Auto Parts',
'Baby & kid',
'Books',
'Cars & Trucks',
'Computers & Electronics',
'Furniture',
'Music',
'Sports & Outdoors',
'Tools',
'Video Gaming',
'Automotive',
'Computer & Technology',
'Event',
'Legal',
'Lessons',
'Pet',
'Realator');
?>

<html>
    <head>  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        <link rel="stylesheet" href="/css/custom.css"> 
    </head>
    <body>
        <h2>Create a new post!</h2>
        <div id="container">
        <?PHP foreach ($errors as $error):?>
            <p><?= $error ?></p>
        <?PHP endforeach ?>
        <div id="form">
            <form action="ads.create.php" method="POST" enctype="multipart/form-data">
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['title'])){ echo $_POST['title'];}?>" placeholder=" Post Title" name="title" id="title" required="" aria-describedby="basic-addon1">
                </div>
                <textarea type="text" class="form-control" value="<?php if(!empty($_POST['description'])){ echo $_POST['description'];}?>" placeholder="Description" name="description" id="description" required="" aria-describedby="basic-addon1"></textarea>
                <select class="category" name="category" required="">
                    <?foreach ($category as $key):?>
                        <option><?= $key; ?></option>
                    <? endforeach?>
                </select><br>              
                <div class="form-group">
                    <label for="exampleInputFile" name="image_url" id="image_url" accept='image/*'>File input</label>
                    <input type="file" id="exampleInputFile" name="file" >
                    <p class="help-block">Accepts PNG, JPEG, JPG, and GIFS.</p>
                </div>
                <button class="btn btn-lg btn-info btn-block"type="submit">Submit</button>                
            </form>
        </div>
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>