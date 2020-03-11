<?php
include ('database_connect.php');
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
if(isset($_POST['action'])){
    $output = '';
    if($_POST['action'] == 'insert'){
        $nameImageArr = [];
        if($_FILES['image']['tmp_name'][0] != ""){
            var_dump($_FILES['image']);
            for($count = 0;$count<count($_FILES['image']['tmp_name']);$count++){
                $tmp_location = $_FILES['image']['tmp_name'][$count];
                $image_name = explode('.',$_FILES['image']['name'][$count]);
                $extension = end($image_name);
                $filename = rand().'.'.$extension;

                $location = 'images/'.$filename;
                move_uploaded_file($tmp_location,$location);
                array_push($nameImageArr,$filename);
            }
            $arrToJsonNameImage = json_encode($nameImageArr);
            $data = array(
                ':user_id'=>$_SESSION['id'],
                ':post_content'=>$_POST['post_content'],
                ':post_images'=>$arrToJsonNameImage,
                ':post_datetime'=>date('Y-m-d').' '.date('H:i:s')
            );
            $query = 'INSERT INTO posts (user_id,post_content,post_images,post_datetime) VALUES (:user_id,:post_content,:post_images,:post_datetime)';
            $statement = $connect->prepare($query);
            if($statement->execute($data)){
                $output .= 'Post has been sharerd';
            }
        }else{
            $data = array(
                ':user_id'=>$_SESSION['id'],
                ':post_content'=>$_POST['post_content'],
                ':post_datetime'=>date('Y-m-d').' '.date('H:i:s')
            );
            $query = 'INSERT INTO posts (user_id,post_content,post_datetime) VALUES (:user_id,:post_content,:post_datetime)';
            $statement = $connect->prepare($query);
            if($statement->execute($data)){
                $output .= 'Post has been sharerd';
            }
        }

//        echo $output;
        $notifi_query = 'SELECT follow.receiver_id FROM follow WHERE sender_id ='.$_SESSION["id"];
        $statement = $connect->prepare($notifi_query);
        $statement->execute();
        $noti_result = $statement->fetchAll();
        foreach ($noti_result as $noti_row){
            $noti_text ='<p>'.get_user_name($connect,$_SESSION["id"]).' has share new post</p>';
            $insert_query ='INSERT INTO notification (notification_receiver_id,notification_text,read_notification) VALUES('.$noti_row["receiver_id"].',"'.$noti_text.'","no")';
            $statement = $connect->prepare($insert_query);
            $statement->execute();
        }
    }
    if($_POST['action'] == 'fetch_post'){
        $query = '
        SELECT 
        posts.id,
        posts.post_content,
        posts.post_datetime,
        posts.user_id \'post_userid\',
        posts.post_images,
        users.id \'user_id\',
        users.name,
        users.image,
        users.bio,
        users.follower_number
        FROM posts 
        INNER JOIN users on users.id = posts.user_id 
        LEFT JOIN follow on posts.user_id = follow.sender_id
        where posts.user_id = '.$_SESSION["id"].' or follow.receiver_id = '.$_SESSION['id'].' 
        GROUP BY posts.id ORDER BY posts.id DESC';
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $total_row = $statement->rowCount();
        if($total_row <0){
            $output .='No Post';
        }else{
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
                                            <button class="btn btn-link like" data-postid = "'.$row["id"].'" >'.count_like($connect,$row["id"]).' Like</button>
                                            <button class="btn btn-link post-comment" data-id="'.$row['id'].'" data-userid="'.$_SESSION["id"].'">'.count_comment($connect,$row["id"]).' Comment</button>
                                            <button class="btn btn-link repost '.$repost.'" data-postid="'.$row["id"].'"  >'.count_share($connect,$row["id"]).' Share</button>
                                            <div id="comment_form'.$row["id"].'" style="display: none">
                                                <div class="form-group">
                                                    <textarea name="comment" id="comment'.$row["id"].'" class="form-control" placeholder="Enter comment"></textarea>
                                                </div>
                                                <button type="button" name="submit" class="float-right btn btn-primary btn-sm submit-comment"> Comment</button>
                                                <div class="d-flex flex-column mt-5" id="old-comment'.$row["id"].'"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                </div>';

            }
        }
        echo $output;
    }
    if($_POST['action'] == 'fetch_user'){
        $query = 'SELECT * FROM users WHERE id !='.$_SESSION["id"].' ORDER BY id DESC';
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $total_row = $statement->rowCount();
        if($total_row < 0){
            $output .= 'No user';
        }else{
            foreach ($result as $row){
                $profile_image ='';
                if($row['image'] != ''){
                    $profile_image .= '<img class="img-fluid" style="width: 100px" src="images/'.$row["image"].'">';
                }else{
                    $profile_image .= '<img class="img-fluid" style="width: 100px" src="images/user-image.jpg">';
                }
                $output .= '<div class="row mt-3">
                            <div class="col-md-4">
                            '.$profile_image.'
</div>
                            <div class="col-md-8">
                            <h4>'.$row["name"].'</h4>
                            '.make_follow_button($connect,$row["id"],$_SESSION["id"]).'
                            <span class="badge badge-success text-wrap">'.$row["follower_number"].' Follower</span>
</div>
                </div>';

            }
        }
        echo $output;
    }
    if($_POST['action'] == 'follow'){
        $query = 'INSERT INTO follow (sender_id,receiver_id) VALUES ('.$_POST["sender_id"].','.$_SESSION["id"].')';
        $statement = $connect->prepare($query);
        if($statement->execute()){
            $sub_query = 'UPDATE users SET follower_number = follower_number + 1 WHERE id = '.$_POST["sender_id"];
            $statement = $connect->prepare($sub_query);
            $statement->execute();
        }
    }
    if($_POST['action'] == 'unfollow'){
        $query = 'DELETE FROM follow WHERE sender_id ='.$_POST["sender_id"].' AND receiver_id ='.$_SESSION["id"];
        var_dump($query);
        $statement = $connect->prepare($query);
        if($statement->execute()){
            $sub_query = 'UPDATE users SET follower_number = follower_number-1 WHERE id ='.$_POST['sender_id'];
            $statement = $connect->prepare($sub_query);
            $statement->execute();
        }

    }
    if($_POST['action'] == 'submit-comment'){
        $data = array(
            ':post_id'=>$_POST['post_id'],
            ':user_id'=>$_POST['user_id'],
            ':comment'=>$_POST['comment'],
            ':comment_time'=> date('Y-m-d').' '.date('H:i:s')
        );
        $query = 'INSERT INTO comments (post_id,user_id,comment,comment_time) VALUES (:post_id,:user_id,:comment,:comment_time)';
        $statement = $connect->prepare($query);
        $statement->execute($data);
    }
    if($_POST['action'] == 'fetch-comment'){
        $query ='SELECT * FROM comments LEFT JOIN users on comments.user_id = users.id WHERE comments.post_id ='.$_POST["post_id"].' ORDER BY comments.comment_id desc';
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $rowCount = $statement->rowCount();
        $output ='';
        if($rowCount>0){
            foreach ($result as $row){
                $output .='<div class="row">
                                <div class="col-md-2">
                                <img style="width: 50px" class="rounded-circle" src="images/'.$row["image"].'">
</div>
                                <div class="col-md-10">
                                <h6>'.$row["name"].'</h6>
                                <small>'.$row["comment_time"].'</small>
                                <p>'.$row["comment"].'</p>
</div>
                            </div>';
            }
        }
        echo $output;
    }
    if($_POST['action'] == 'repost'){
        $query = 'SELECT * FROM repost WHERE post_id = '.$_POST["post_id"].' AND user_id ='.$_SESSION["id"];
        $statement = $connect->prepare($query);
        $statement->execute();
        $rowCount = $statement->rowCount();
        if($rowCount >0){
            $output .='You have already repost this post';
        }else{
            $sub_query ='INSERT INTO repost (post_id,user_id) VALUES ('.$_POST["post_id"].','.$_SESSION["id"].')';
            $statement = $connect->prepare($sub_query);
            if($statement->execute()){
                $query2 = 'SELECT * FROM posts WHERE id ='.$_POST["post_id"];
                $statement = $connect->prepare($query2);
                $statement->execute();
                $rowCount = $statement->rowCount();
                $result = $statement->fetchAll();
                if($rowCount > 0){
                    $post_content ='';
                    foreach ($result as $item) {
                        $post_content = $item["post_content"];
                    };
                    $query3 = 'INSERT INTO posts (user_id,post_content,post_datetime) VALUES ('.$_SESSION["id"].',"'.$post_content.'","'.date("Y-m-d").' '.date("H:i:s").'")';
                    $statement = $connect->prepare($query3);
                    if($statement->execute()){
                        $output .= 'Repost done success';
                    }else{
                      $query_delete = 'DELETE FROM repost WHERE post_id = '.$_POST["post_id"].' AND user_id = '.$_SESSION["id"];
                      $statement = $connect->prepare($query_delete);
                      if($statement->execute()){
                          $output .= 'false';
                      }
                    }
                }else{

                }
            }else{

            }

        }
        echo $output;
    }
    if($_POST['action'] == 'like'){
        $query ='SELECT * FROM likes WHERE user_id ='.$_SESSION["id"].' AND post_id ='.$_POST["post_id"];
        $statement = $connect->prepare($query);
        $statement->execute();
        $rowCount = $statement->rowCount();
        if($rowCount > 0){
            $sub_query = 'DELETE FROM likes WHERE user_id ='.$_SESSION["id"].' AND post_id ='.$_POST["post_id"];
        }else{
            $sub_query = 'INSERT INTO likes (user_id,post_id) VALUES ('.$_SESSION["id"].','.$_POST["post_id"].')';
        }
        $statement = $connect->prepare($sub_query);
        $statement->execute();
    }
    if($_POST['action'] == 'getUserLike'){
        $query ='SELECT users.name FROM `users` 
INNER JOIN likes on users.id = likes.user_id
where likes.post_id = '.$_POST["post_id"];
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $item){
            $output .= '<p>'.$item["name"].'</p>';
        }
        echo $output;
    }
    if($_POST['action'] == 'see-notification'){
        $query ='UPDATE notification SET read_notification = "yes" WHERE notification_id = '.$_POST["noti_id"];
        $statement = $connect->prepare($query);
        $statement->execute();
    }
    if($_POST['action'] == 'search_user'){
        $query ='SELECT users.name,users.image FROM users WHERE users.name LIKE "%'.$_POST["query"].'%" AND users.id != '.$_SESSION["id"];
        $statement =$connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row){
            $data[] = $row["name"];
        }
        echo json_encode($data);

    }
}
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
?>
