<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; cahrset=UTF-8");
header("Access-Control-Allow-Methods: POST");
// check the request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get raw strings
    $rawjsondata = file_get_contents('php://input');
    $data = json_decode($rawjsondata);
 // validate inputs
    if (empty($data->lastname) || empty($data->firstname) || empty($data->dob) || empty($data->desc) || empty($data->email) || 
    empty($data->password) || empty($data->phone) ) {
        
        $responsedata = array(
            "status"=>"failed",
            "message"=>"Bad request ",
            "data"=> []
        );
        echo json_encode($responsedata);
    }else {
        //add user class file
        include_once "userapi.php";
        //create object of new user
        $userobj = new User;
        // accesss insertUser
        $output = $userobj->insertUser($data->lastname, $data->firstname, $data->dob, $data->desc, $data->email,$data->password,$data->phone);

        echo $output;
    }
}else {
    $responsedata = array(
        "status"=>"failed",
        "message"=>"Method not allowed ",
        "data"=> []
    );
    echo json_encode($responsedata);
}

?>