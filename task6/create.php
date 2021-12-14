<?php
require 'dbconnect.php';

function Clean($input){
    return   strip_tags(trim($input));
}


if($_SERVER['REQUEST_METHOD'] == "POST"){

    $title     = Clean($_POST['title']);
    $content    = Clean($_POST['content']);
    $fileName = $_FILES['image']['name'];
    $fileTmp = $_FILES['image']['tmp_name'];

    $AllowExtention = array("jpg","png","jpeg");

    $tmp = explode('.',$fileName);
    $fileExtention = strtolower(end($tmp));

    $errors = [];

    # Validate Title
    if(empty($title)){
        $errors['title']  = "Field Required...";
    }
    if(strlen($title) < 6){
        $errors['title']  = "Must Be Greter Than 6chr";
    }
    # Validate Content
    if(empty($content)){
        $errors['content'] = "Field Required...";
    }
    if(strlen($content) < 20){
        $errors['title']  = "Must Be Greter Than 20chr";
    }
    #Validate Image
    if ( !empty($fileName) && in_array($fileExtention,$AllowExtention)){

    } else {
        $errors['Image'] = " The Extention Of Image Is Not Allwoed";
    }

    # Check Forms
    echo '<div class="container">';
    if(count($errors) > 0){
        foreach ($errors as $key => $value) {
            echo '<div class="alert alert-danger"> '.$key.' : '.$value.'</div>';
        }
    }else{
        $newFileName = rand().time(). '_' . $fileName;
        move_uploaded_file($fileTmp,"./uploads/" . $newFileName);

        $sql = "insert into user (title,content,image) values ('$title','$content','$newFileName') ";
        $op  = mysqli_query($con,$sql);
        if($op){
            echo 'Data Inserted';
        }else {
            echo 'Error '.mysqli_error($con);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Add Item</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleInputName">Title</label>
            <input type="text" class="form-control" id="exampleInputName" name="title" placeholder="Enter Name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Content</label>
            <textarea class="form-control" id="exampleInputEmail1" name="content"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Upload Image</label>
            <input type="file" id="exampleInputEmail1" name="image" >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
