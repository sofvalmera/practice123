<?php

include_once (__DIR__ . '/../controller/usercontroller.php');
header('Content-Type: application/json');
$delete=['id' => '1'];
$getallusers = new UserController();
$alldata = $getallusers->delete($delete);
echo json_encode($alldata);
?>
