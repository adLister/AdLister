<?PHP

require_once '../bootstrap.php';
$errors = array();
if(!empty($_POST)){
    try { 
        Input::getString('name');
    }catch(Exception $e){
        $errors[] = $e->getMessage(). ' for the name feild.';
    }

    try { 
        Input::getDate('date_created');
    }catch(Exception $e){
        $errors[] = $e->getMessage();
    }

    try { 
        Input::getString('description');
    }catch(Exception $e){
            $errors[] = $e->getMessage() . ' for the description feild.';
    }

    if(empty($errors)){
        $newPost = $dbc->prepare("INSERT INTO ads(title, description) 
        VALUES(:title,:date_created,:description)");
        $newPost->bindValue(':title', Input::getString('title'), PDO::PARAM_STR);
        $newPost->bindValue(':description', Input::getString('description'), PDO::PARAM_STR);
        $newPost->execute();
    }
}



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
            <form method="POST">
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['name'])){ echo $_POST['name'];}?>" placeholder=" Post Title" name="name" id="name" required="" aria-describedby="basic-addon1">
                </div>                 
                <div class="input-group-lg">
                  <input type="text" class="form-control" value="<?php if(!empty($_POST['description'])){ echo $_POST['description'];}?>" placeholder="Description" name="description" required="" aria-describedby="basic-addon1">
                </div>
                <button class="btn btn-lg btn-info btn-block"type="submit">Submit</button>
            </form>
        </div>
    </body>
</html>