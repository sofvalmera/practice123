<?php

include_once (__DIR__ . '/../controller/usercontroller.php');
header('Content-Type: application/json');

$deleteuser = new UserController();
$deletedata = $deleteuser->deleteuser($_GET);
echo json_encode($deletedata);
?>