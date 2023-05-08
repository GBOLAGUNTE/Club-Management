<?php
include_once "../../shared/constants.php";

class User{
    //member variables
    public $lastname;
    public $firstname;
    public $emailaddress;
    public $dateofbirth;
    public $phonenumber;
    public $profiledesc;
    public $password;
    public $mycon;

// member functions
    function __construct(){
        // connect to database
            $this->mycon = new MySQLi(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
        
                if ($this->mycon->connect_error) {
                   die("Connection Failed: ".$this->mycon->connect_error);
                }
        
            }
            
            #start insertuser method
            function insertUser($lname,$fname,$dob,$email,$phone,$desc,$pswd){
                // prepare the statement
                $stmt = $this->mycon->prepare("INSERT INTO users(lastname, firstname, dateofbirth, emailaddress, 
                phonenumber, profiledesc, password)VALUES(?,?,?,?,?,?,?)");
                // bind parameters
                $pswd = password_hash($pswd, PASSWORD_DEFAULT);
                $stmt->bind_param("sssssss",$lname,$fname,$dob,$email,$phone,$desc,$pswd);
                //execute
                $stmt->execute();

                //check if record wasv inserted
                if ($stmt->affected_rows == 1) {
                    $responsedata = array(
                        "status"=>"success",
                        "message"=>"Account created successfully ",
                        "data"=> $stmt->insert_id
                    );
                }else {
                    $responsedata = array(
                        "status"=>"failed",
                        "message"=>"Ooops, something went wrong ",
                        "data"=> null
                    );
                    // log error
                    file_put_contents("error_log.txt", $stmt->error);
                }

                $response = json_encode($responsedata);

                return $response;
            }

            #end insertuser method

            #start getallusers method

            function getallusers(){
                $statement = $this->mycon->prepare("SELECT * FROM users WHERE role_id=?");
                // bind parameter

                $roleid = 2;
                $statement->bind_param("i",$roleid);
                $statement->execute();
                $result=$statement->get_result();
                // check if there are recorsds
                $records = array();
                if($result->num_rows > 0){
                   // fetch records
                    while ($rows = $result->fetch_assoc()){
                    $records[] = $rows;
                   }
                   $responsedata = array(
                    "status"=>"success",
                    "message"=>"list of all members ",
                    "data"=> $records
                );
                 return json_encode($responsedata);
            }else {
                $responsedata = array(
                    "status"=>"failed",
                    "message"=>"no record found",
                    "data"=> []
                );
                //log error
                file_put_contents("error_log.txt", $statement->error, FILE_APPEND);

                return json_encode($responsedata);
            }
            
               }
            #end allusers method

            #start updateuser method

            function updateUser($lname,$fname,$dob,$phone,$desc,$userid){
                // prepare the statement
                $stmt = $this->mycon->prepare("UPDATE users SET lastname=?, firstname=?, dateofbirth=?, phonenumber=?, profiledesc=? WHERE user_id=?");
                // bind parameters
            
                $stmt->bind_param("sssssi",$lname,$fname,$dob,$phone,$desc,$userid);
                //execute
                $stmt->execute();

                //check if record wasv inserted
                if ($stmt->affected_rows == 1) {
                    $responsedata = array(
                        "status"=>"success",
                        "message"=>"Account Updated successfully ",
                        "data"=> []
                    );
                }elseif ($stmt->affected_rows == 0) {
                    $responsedata = array(
                        "status"=>"success",
                        "message"=>"Nothing to update",
                        "data"=> []
                    );
                
                }else {
                    $responsedata = array(
                        "status"=>"failed",
                        "message"=>"Ooops, something went wrong ",
                        "data"=> []
                    );
                    // log error
                    file_put_contents("error_log.txt", $stmt->error);
                }

                $response = json_encode($responsedata);

                return $response;
            }

            #end update user method

        }
?>