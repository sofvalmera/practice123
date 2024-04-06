<?php

include_once (__DIR__ . '/../controller/usercontroller.php');

$updateuser = new UserController();
$data = $updateuser->updateuser($_POST);
echo json_encode($data);
?>
