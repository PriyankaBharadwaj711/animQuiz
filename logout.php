<?php
session_start();
$version =$_REQUEST["version"];
session_unset();
session_destroy();

header('Location: ./index.php?version=' . $version);

  
?>
