<?php
?>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    fetch_post();
    function fetch_post() {
        var action = 'fetch_post';
        $.ajax({
            url:'action.php',
            method: 'post',
            data: {action:action},
            success:function (data) {
                $('#post-list').html(data);
            }
        })
    }
    fetch_user();
    function fetch_user() {
        var action = 'fetch_user';
        $.ajax({
            url:'action.php',
            method:'post',
            data:{action:action},
            success:function (data) {
                // console.log(data);
                $('#user-list').html(data);
            }
        })

    }
    function fetch_comment(post_id){
        var action = 'fetch-comment';
        $.ajax({
            url:'action.php',
            data:{action:action,post_id:post_id},
            method:'post',
            success:function (data) {
                $('#old-comment'+post_id).html(data);
            }
        })
    }
    $(document).on('click','.action-button',function (e) {
        e.preventDefault();
        action = $(this).data('action');
        sender = $(this).data('sender');
        $.ajax({
            url:'action.php',
            data:{action:action , sender_id:sender},
            method:'post',
            success:function (data) {
                fetch_post();
                fetch_user();
            }
        })
    })
    $('#post_form').on('submit',function (e) {
        e.preventDefault();
        if($('#post_content').val() == ''){
            alert('Enter Story Content');
        }else{
            var form_data = new FormData($(this)[0]);
            $.ajax({
                url:'action.php',
                data:form_data,
                method:'post',
                processData: false,
                contentType: false,
                success:function (data) {
                    console.log(data);
                    $('#post_form')[0].reset();
                    fetch_post();
                }
            })
        }
    });
    var user_id;
    var post_id;
    $(document).on('click','.post-comment',function (e) {
        e.preventDefault();
        user_id = $(this).data('userid');
        post_id = $(this).data('id');
        $('#comment_form'+post_id).slideToggle('slow');
        fetch_comment(post_id);
    });
    $(document).on('click','.submit-comment',function (e) {
        e.preventDefault();
        var comment = $('#comment'+post_id).val();
        var action = 'submit-comment';
        if(comment != ''){
            $.ajax({
                url:'action.php',
                data:{post_id:post_id,user_id:user_id,comment:comment,action:action},
                method:'post',
                success:function (data) {
                    fetch_comment(post_id);
                }
            });
        }
    });
    $(document).keypress(function (e) {
        if (e.which == 13) {
            e.preventDefault();
            var comment = $('#comment'+post_id).val();
            var action = 'submit-comment';
            if(comment != ''){
                $.ajax({
                    url:'action.php',
                    data:{post_id:post_id,user_id:user_id,comment:comment,action:action},
                    method:'post',
                    success:function (data) {
                        fetch_comment(post_id);
                    }
                });
            }
            return false;
        }
    });
    $(document).on('click','.repost',function (e) {
        e.preventDefault();
        post_id = $(this).data('postid');
        action = 'repost';
        $.ajax({
            url:'action.php',
            data:{post_id:post_id,action:action},
            method:'post',
            success:function (data) {
                alert(data);
                fetch_post();
            }
        })
    })
    $(document).on('click','.like',function (e) {
        e.preventDefault();
        post_id = $(this).data('postid');
        action = 'like';
        $.ajax({
            url:'action.php',
            data:{post_id:post_id,action:action},
            method:'post',
            success:function (data) {
                // console.log(data);
                fetch_post();
                $('.like').tooltip('hide');
            }
        });
    });
    $(document).on('click','.see-noti',function (e) {
        e.preventDefault();
        action = 'see-notification';
        noti_id = $(this).data('idnoti');
        see_notification(action,noti_id);
    });
    function see_notification(action,noti_id){
        $.ajax({
            url:'action.php',
            data:{action:action,noti_id:noti_id},
            method:'post',
            success:function (data) {
                console.log(data);
            }
        })
    }
    $('body').tooltip({
        selector:'.like',
        title:fetch_post_like_user_list,
        html:true,
        placement:'top'
    });
    var out = '';
    function fetch_post_like_user_list() {
        var element = $(this);
        var post_id = element.data('postid');
        var action = 'getUserLike';
        $.ajax({
            async:false,
            url:'action.php',
            data:{action:action,post_id:post_id},
            method:'post',
            success:function (data) {
                out = data;
            }
        });
        return out;
    };
</script>
