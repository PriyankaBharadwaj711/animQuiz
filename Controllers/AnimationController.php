<?php


error_reporting(0);
session_start();
// $connType="PDO";
require_once("../connect.php");
require_once("../Models/Events.php");
// include("./services/saveUserActivity.php");

if(isset($_POST["type"]) && $_POST["type"] === "selectView"){
    $response["error"] = "";
    $selection = $_POST["selection"];

    $event = new Event($conn);
    $updateSelection = $event->updateSelectItem($selection,$conn);


    if($updateSelection == false) {
        $response["error"] = "unable to update profile";
    }
    echo(json_encode($response));
}


?>