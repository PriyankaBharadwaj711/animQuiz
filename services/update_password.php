<?php
require("../connect.php");
$email = $_POST['email'];
$pwd=password_hash($_POST['password'], PASSWORD_DEFAULT);
echo $pwd;
$sql = "UPDATE users set password = '$pwd' WHERE email = '$email';";
$result = $conn->query($sql);
if($result->num_rows>=0){
    echo '<script>
    alert("Password has been updated successfully");
    window.location = "./index.php";
    </script>';

}
?>