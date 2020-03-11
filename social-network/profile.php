<?php
include ('database_connect.php');
session_start();
if(!isset($_SESSION['id'])){
    header('location:login.php');
}
$message = '';
if(isset($_POST['edit'])){
    $file_name ='';
    if(isset($_SESSION['image'])){
        $file_name = $_SESSION['image'];
    }
    if($_FILES['image']['name'] != ''){
        $image_name = explode('.',$_FILES['image']['name']);
        $extension = end($image_name);
        $temporary_location = $_FILES['image']['tmp_name'];
        $file_name = rand().'.'.$extension;
        $location = 'images/'.$file_name;
        move_uploaded_file($temporary_location,$location);
    }
    $check_query ='SELECT * FROM users WHERE username = :username AND id != :id';
    $statement = $connect->prepare($check_query);
    $statement->execute(
        array(
            ':username'=>trim($_POST['username']),
            ':id'=>$_SESSION['id']
        )
    );
    $total_row = $statement->rowCount();
    if($total_row > 0){
        $message .= '<div class="alert alert-danger"> Username already Exists</div>';
    }else{
        $data = array(
            ':username'=>trim($_POST['username']),
            ':name'=>trim($_POST['realname']),
            ':image'=>$file_name,
            ':bio'=>$_POST['bio'],
            ':id'=>$_SESSION['id']
        );
        if($_POST['password'] != ''){
            $data[]=array(
                ':password' =>password_hash($_POST['password'],PASSWORD_DEFAULT)
            );
            $query = 'UPDATE users SET username = :username,password = :password,bio = :bio,image = :image,name = :name WHERE id = :id';
        }else{
            $query = 'UPDATE users SET username = :username,bio = :bio,image = :image,name = :name WHERE id = :id';
        }
        $statement= $connect->prepare($query);
        if($statement->execute($data)){
            $message .= '<div class="alert-danger alert">Profile Update Success</div>';
            $_SESSION['name']=trim($_POST['realname']);
            $_SESSION['image']=$file_name;
        }
    }
}
$query = 'SELECT * FROM users WHERE id = '.$_SESSION["id"];
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <?php
    include ('menu.php');
    ?>
    <div class="row mt-3">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Edit profile
                </div>
                <div class="card-body">
                    <?php echo $message?>
                    <?php
                    foreach ($result as $row) {
                        ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input value="<?php
                                if($row['name'] != ''){
                                    echo $row['name'];
                                }
                                ?>" type="text" name="realname"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input value="<?php
                                if($row['username'] != ''){
                                    echo $row['username'];
                                }
                                ?>" type="text" name="username"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Story About Me</label>
                                <textarea name="bio" id="bio" class="form-control"><?php echo $row['bio']?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Change your image</label>
                                <input type="file" name="image">
                            </div>
                            <img class="" style="width: 100px;" src="images/<?php echo $row['image'] ?>"/>
                            <input type="submit" name="edit" class="btn btn-primary float-right" value="Save">
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>