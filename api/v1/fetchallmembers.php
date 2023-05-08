<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; cahrset=UTF-8");
header("Access-Control-Allow-Methods: POST");
// check the request method
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include_once "userapi.php";
    // create object of user class
    $obj = new User;
    $result = $obj->getAllUsers();

    echo $result;
}else {
    $responsedata = array(
        "status"=>"failed",
        "message"=>"Method not allowed ",
        "data"=> []
    );
    echo json_encode($responsedata);
}
?>