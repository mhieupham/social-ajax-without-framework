<?php
include 'database_connect.php';
session_start();
if(!isset($_SESSION["id"])){
    header('location:login.php');
}
$query = 'SELECT 
users.id "user_id",
users.name,
users.image,
users.bio,
users.follower_number,
posts.id,
posts.post_content,
posts.post_datetime,
posts.post_images
FROM posts LEFT JOIN users ON users.id = posts.user_id WHERE users.name LIKE "%'.$_GET["data"].'%" GROUP BY posts.id ORDER BY posts.id desc';

$statement = $connect->prepare($query);
$statement->execute();
$totalRow = $statement->rowCount();

$query2 ='SELECT * FROM users WHERE users.name LIKE "%'.$_GET["data"].'%" AND users.id != '.$_SESSION["id"];
$statement2 = $connect->prepare($query2);
$statement2->execute();
$totalRow2 = $statement2->rowCount();

//include 'action.php';
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.js"></script>
    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <?php
    include ('menu.php');
    ?>
    <div class="row mt-3">
        <?php
        if($totalRow2 >0){
            $result2 = $statement2->fetchAll();
        }
        ?>
        <div class="col-md-8">
                <div class="card-header">
                    Search result <?php echo $_GET["data"] ?>

                </div>
                <div class="card-body">
                    <?php
                    $output1 ='';
                    foreach ($result2 as $row2){
                        $output1 .= '
<div class="jumbotron"><div class="row mt-3">
                    <div class="col-md-2">
                    <img style="width:100px" src="images/'.$row2["image"].'" class="img-fluid" />
                    </div>
                    <div class="col-md-8">
                    <h4>'.$row2["name"].'</h4>
                    '. make_follow_button($connect,$row2["id"],$_SESSION["id"]).'
                    
                    </div>
                    </div>
                    </div> ';
                    }
                    echo $output1;
                    ?>

                    <?php
                    if($totalRow >0){
                        $result = $statement->fetchAll();
                    }
                    $output ='';
                        foreach ($result as $row){
                            $profile_image ='';
                            $post_image = '';
                            $carouselControl ='';
                            $post_video = '';
                            $repost = 'disabled';
                            if($row['user_id'] != $_SESSION['id']){
                                $repost ='';
                            }
                            if($row['image'] != ''){
                                $profile_image = '<img style="width:100px" src="images/'.$row["image"].'" class="img-fluid" />';
                            }else{
                                $profile_image = '<img style="width:100px" src="images/user-image.jpg" class="img-fluid" />';
                            }
                            if($row['post_images'] != NULL){
                                $arrPostImage = json_decode($row['post_images']);
                                foreach ($arrPostImage as $key => $value){
                                    $arrImageExplode = explode('.',$value);
                                    $extension = end($arrImageExplode);
                                    if($extension == 'jpg' OR $extension =='png'){
                                        $post_image .= '<div class="carousel-item '.($key == 0?"active":"").'"><a href="images/'.$value.'"><img style="width:450px;height:450px" src="images/'.$value.'" class="img-fluid" /></a></div>';
                                    }
                                    if($extension == 'mp4'){
                                        $post_video .='<div class="carousel-item '.($key == 0?"active":"").'"><a href="images/'.$value.'"><video width="406" height="355" controls><source src="images/'.$value.'" type="video/mp4"></video></a></div>';
                                    }
                                    if(count($arrPostImage) > 1){
                                        $carouselControl ='<a class="carousel-control-prev" href="#carouselExampleIndicators'.$row["id"].'" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                              </a>
                                              <a class="carousel-control-next" href="#carouselExampleIndicators'.$row["id"].'" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                              </a>';
                                    }
                                }
                            }
                            $profile_image = '';
                            if($row["image"] == ''){
                                $profile_image .= '<img class="img-fluid" style="width: 100px" src="images/user-image.jpg">';
                            }else{
                                $profile_image .= '<img class="img-fluid" style="width: 100px" src="images/'.$row["image"].'">';
                            }
                            $output .= '<div class="jumbotron">
                                  <div class="row">
                                        <div class="col-md-2">'.$profile_image.'</div>
                                        <div class="col-md-8">
                                        
                                            <h3>@'.$row["name"].'</h3>
                                            <small>'.$row["post_datetime"].'</small>
                                            <p>'.$row["post_content"].'</p>
                                            
                                            <div id="carouselExampleIndicators'.$row["id"].'" class="carousel slide" data-ride="carousel">
                                              <div class="carousel-inner">

                                                '.$post_image.'
                                                  '.$post_video.'

                                                  </div>
                                                '.$carouselControl.'
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                </div>';
                        }
                        echo $output;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
<?php

function get_user_name($connect,$user_id){
    $query = 'SELECT users.name FROM users WHERE users.id ='.$user_id;
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row){
        return $row['name'];
    }
}
function count_like($connect,$post_id){
    $query = 'SELECT * FROM likes WHERE post_id ='.$post_id;
    $statement = $connect->prepare($query);
    $statement->execute();
    $rowCount = $statement->rowCount();
    if($rowCount == 0){
        $rowCount ='';
    }
    return $rowCount;
}
function count_share($connect,$post_id){
    $query = 'SELECT * FROM repost WHERE post_id ='.$post_id;
    $statement = $connect->prepare($query);
    $statement->execute();
    $rowCount = $statement->rowCount();
    if($rowCount == 0){
        $rowCount = '';
    }
    return $rowCount;
}
function make_follow_button($connect,$sender_id,$receiver_id){
    $query = 'SELECT * FROM follow WHERE sender_id ='.$sender_id.' AND receiver_id = '.$receiver_id;
    $statement = $connect->prepare($query);
    $statement->execute();
    $rowcount = $statement->rowCount();
    $output ='';
    if($rowcount >0){
        $output = '<button type="button" data-action="unfollow" data-sender="'.$sender_id.'" class="btn btn-success action-button">Following</button> ';
    }else{
        $output = '<button type="button" data-action="follow" data-sender="'.$sender_id.'" class="btn btn-outline-success action-button">Follow</button> ';
    }
    return $output;
}
function count_comment($connect,$post_id){
    $query = 'SELECT * FROM comments WHERE post_id ='.$post_id;
    $statement = $connect->prepare($query);
    $statement->execute();
    $rowcount = $statement->rowCount();
    $output ='';
    return $rowcount;
}
function get_userId($connect,$username){
    $query = 'SELECT * FROM users WHERE users.name = '.$username;
    $statement = $connect->prepare($query);
    $statement->execute();
    $result= $statement->fetchAll();
    foreach ($result as $row){
        return $row["id"];
    }
}
include 'jquery.php';
?>

