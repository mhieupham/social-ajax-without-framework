<?php
include "database_connect.php";
session_start();
if(!isset($_SESSION['id'])){
    header('location:login.php');
}
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
    <div class="row">
        <div class="col-md-8">
            <div class="card mt-3">
                <h5 class="card-header">Start write here</h5>
                <div class="card-body">
                    <form method="post" id="post_form" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea name="post_content" id="post_content" maxlength="160" class="form-control" placeholder="Write your short story"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="border rounded px-2" for="uploadFile"><img src="images/iconPost/icon-image-512.png" style="width: 40px;"> Add Image/Video </label>
                            <input accept=".jpg, .png , .jpeg, .mp4" type="file" name="image[]" id="uploadFile" class="d-none" multiple >
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="action" value="insert">
                            <input type="submit" class="btn btn-primary float-right" name="share_post" value="Share">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-5">
                <h5 class="card-header">Trending Now</h5>
                <div class="card-body">
                    <div id="post-list">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-header">
                    Someone else did you know
                </div>
                <div class="card-body">
                    <div id="user-list">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
<?php
include "jquery.php";
?>
</body>
</html>
