<?php
// require_once("../loadEnvironmentals.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Event{
    function __construct($conn)
    {
        $this->conn = $conn;
    }

    
    function updateSelectItem($selection,$conn){
        $userId = $_SESSION["userid"];
        $sql = "UPDATE user_character_mapping SET characterName=? WHERE uid=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $selection,$userId);
        $stmt->execute();

        return ($conn->affected_rows ==  1);
    }


}

// class ActivityHistory{

//     public function saveHistory($conn,$event_type,$event_desc){
//         $sql_activity = 'INSERT INTO `user_activity_history` (`id`,`user_id`, `type`,`description`,`creation_date`,`session_id`) VALUES (NULL,'.$_SESSION["userid"].',"'.$event_type.'","'.$event_desc.'",CURRENT_TIMESTAMP,"'.session_id().'")';
//       //  echo $sql_activity;
//         $sql_result = $conn->query($sql_activity);
        
//     }
// }

?>