<?php
$connect = new PDO('mysql:host=localhost;dbname=social','hieu','123456');
//try{
//    $connect = new PDO('mysql:host=localhost;dbname=social','hieu','123456',
//        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
////    die(json_encode(array('outcome' => true)));
//}
//catch(PDOException $ex){
////    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
//}

function count_notification($connect,$receiver_id){
    $query = 'SELECT count(*) as total FROM notification WHERE notification_receiver_id = '.$receiver_id.' AND read_notification = "no"';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row){
        if($row["total"] == 0){
            return '';
        }else{
            return $row["total"];
        }

    }
}
function load_notification($connect,$receiver_id){
    $output = '';
    $query ='SELECT notification.notification_id,notification.notification_text,notification.read_notification FROM notification WHERE notification_receiver_id ='.$receiver_id .' ORDER BY notification_id DESC';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row){
        $output .= '<a title="see" class="dropdown-item '.($row["read_notification"] == "no"?"bg-light ":"").'  see-noti" data-idnoti ="'.$row["notification_id"].'" href="#">'.$row["notification_text"].'</a>';
    }
    return $output;
}