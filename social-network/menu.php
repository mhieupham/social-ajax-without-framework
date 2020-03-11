
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Social</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <div class="input-group">
                    <input type="text" class="form-control" name="search-user" id="search_user" placeholder="Search">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="view_notification" href="#">Notification <img style="width: 20px" src="images/iconPost/1_Bell-512.png"><sup><?php echo count_notification($connect,$_SESSION["id"]) ?></sup></a>
                <div class="dropdown-menu" aria-labelledby="view_notification">
                    <?php echo load_notification($connect,$_SESSION["id"]) ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img style="width: 30px;" src="images/<?php echo $_SESSION['image'] ?>"/>
                    <?php echo $_SESSION['name']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
    $(document).ready(function () {
        $('#search_user').typeahead({
            source:function (query,result) {
                var action = 'search_user';
                $.ajax({
                    url:'action.php',
                    data:{action:action,query:query},
                    method:'post',
                    dataType:'json',
                    success:function (data) {
                        return result(data);
                    }
                })
            }
        })
        $(document).on('click','.typeahead li',function () {
            var search_query = $(this).text();
            window.location.href='wall.php?data='+search_query;
        })
    })

</script>