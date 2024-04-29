<?php

include_once (__DIR__ . '/../controller/usercontroller.php');
header('Content-Type: application/json');

$search = 'so';
$searchusers = new UserController();
$searchdata = $searchusers->searchusers($search);
echo json_encode($searchdata);
?>
