<?PHP

require_once '../bootstrap.php';
$errors = array();
// if(!empty($_POST)){
//     try { 
//         Input::getString('title');
//     }catch(Exception $e){
//         $errors[] = $e->getMessage(). ' for the title feild.';
//     }

//     try { 
//         Input::getString('description');
//     }catch(Exception $e){
//             $errors[] = $e->getMessage() . ' for the description feild.';
//     }

    if(empty($errors)){
        $newPost = $dbc->prepare("INSERT INTO ads(title, description, image_url) 
        VALUES(:title,:description,:image_url)");
        var_dump($_FILES);
        // $newPost->bindValue(':title', Input::getString('title'), PDO::PARAM_STR);
        // $newPost->bindValue(':description', Input::getString('description'), PDO::PARAM_STR);
        // $newPost->bindValue(':image_url', Input::getString('image_url'), PDO::PARAM_STR);
        // $newPost->execute();
    }
// }



?>

<html>
    <head>  

        <link rel="stylesheet" href="/public/css/custom.css"> 
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
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['description'])){ echo $_POST['description'];}?>" placeholder="Description" name="description" id="description" required="" aria-describedby="basic-addon1">
                </div>                
                <div class="form-group">
                    <label for="exampleInputFile" name="image_url" id="image_url" accept='image/*'>File input</label>
                    <input type="file" id="exampleInputFile" name="file">
                    <p class="help-block">Accepts PNG, JPEG, JPG, and GIFS.</p>
                </div>
                <button class="btn btn-lg btn-info btn-block"type="submit">Submit</button>                
            </form>
        </div>
    </body>
</html>