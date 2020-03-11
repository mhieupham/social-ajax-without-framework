<?php
include ('database_connect.php');
session_start();
$message ='';
if(isset($_SESSION['id'])){
    header('location:index.php');
}
if(isset($_POST['register'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $realname = $_POST['realname'];
    $check_query = 'SELECT * FROM `users` WHERE `username` = :username';
    $statement = $connect->prepare($check_query);
    $check_data = array(
        ':username' =>$username
    );
//    $statement->execute($check_data);
//    echo "\nPDOStatement::errorCode(): ";
//    print $statement->errorCode();
    if($statement->execute($check_data)){
        if($statement->rowCount()>0){
            $message .='<p><label>Username already taken</label></p>';
        }else{
            if(empty($realname)){
                $message .='<p><label>Your name is required</label></p>';
            }
            if(empty($username)){
                $message .= '<p><label>Username is required</label></p>';
            }
            if(empty($password)){
                $message .= '<p><label>Password is required</label></p>';
            }else{
                if($password != $_POST['comfirm_password']){
                    $message .= '<p><label>Password not match</label></p>';
                }
            }
            if($message == ''){
                $data = array(
                        ':name'=>$realname,
                    ':username'=>$username,
                    ':password'=>password_hash($password,PASSWORD_DEFAULT),
                );

                $query = "INSERT INTO `users` (name,username,password) VALUES (:name,:username,:password)";
                $statement = $connect->prepare($query);
//                var_dump($statement->execute($data));
                if($statement->execute($data)){
                    $message .= '<label>Registration Complete</label>';
                }else{
                    echo 'error';
                }
            }
        }
    }
}
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
    <h3>Social Register</h3>
    <form method="post" id="register">
        <spam class="text-danger"><?php echo $message?></spam>
        <div class="form-group">
            <label >Realname</label>
            <input type="text" id="realname" class="form-control" name="realname">
        </div>
        <div class="form-group">
            <label >Username</label>
            <input type="text" id="username" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" id="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label>Re-Password</label>
            <input type="password" id="confirm_password" class="form-control" name="comfirm_password">
        </div>
        <input type="submit" name="register" value="Register" class="btn btn-primary">
        <span>have an account ?</span>
        <a href="login.php" class="btn btn-primary">Login</a>
    </form>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
