<?php

include_once (__DIR__ . '/../controller/usercontroller.php');

$testData = [
    'fname' => 'test',
    'lname' => 'test',
    'email' => 'sofgmail.com',
    'password' => 'test',
    'token' => 'test'
];

// offline debugging

$insertuser = new UserController();
$data = $insertuser->insertuser($testData);
echo json_encode($data);
?>
