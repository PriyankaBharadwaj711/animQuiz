<?php

session_start();
$connType = "PDO";
require("../connect.php");
$sql2 = "SELECT * from users where id= ?";
$stmt2 = $conn->prepare($sql2);
$uid = $_REQUEST["userid"];
$stmt2->execute([$uid]);
// var_dump($uid);
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
if ($result2) {
    foreach ($result2 as $row2) {
        if ($row2["feedback"]) {
            header("content-type: audio/webm");
            echo $row2["feedback"];
        } else {
            echo ' <div>No recording found by the Kid.</div>';
        }
    }
}
