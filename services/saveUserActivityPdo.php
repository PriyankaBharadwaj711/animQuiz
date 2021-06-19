<?php
// PDO 
class ActivityHistory{
    public function saveHistory($conn,$event_type,$event_desc){
        try{
            $sql = "INSERT INTO user_activity_history (`id`,`user_id`, `type`,`description`,`creation_date`,`session_id`) VALUES (?,?,?,?,CURRENT_TIMESTAMP,?)";
            $stmt= $conn->prepare($sql);
            $stmt->execute([NULL,$_SESSION["userid"],$event_type,$event_desc,session_id()]);
        }
        catch(Exception $e){
            // echo $e->getMessage();
        }
        
    }
}
?>