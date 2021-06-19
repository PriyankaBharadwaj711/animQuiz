<?php
class ActivityHistory{

    public function saveHistory($conn,$event_type,$event_desc){
        $sql_activity = 'INSERT INTO `user_activity_history` (`id`,`user_id`, `type`,`description`,`creation_date`,`session_id`) VALUES (NULL,'.$_SESSION["userid"].',"'.$event_type.'","'.$event_desc.'",CURRENT_TIMESTAMP,"'.session_id().'")';
      //  echo $sql_activity;
        $sql_result = $conn->query($sql_activity);
        
    }
}


?>