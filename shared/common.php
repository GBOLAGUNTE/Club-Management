<?php 
include_once "shared/constants.php";

// class definition
class Common{
    // member variables
    var $mycon;


    // member functions
    function __construct(){
        // connect to database
            $this->mycon = new mySQLi(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
        
                if ($this->mycon->connect_error) {
                   die("Connection Failed: ".$this->mycon->connect_error);
                }
        
            }

            #begin getCountries method
            



function getCountries(){
    $statement = $this->mycon->prepare("SELECT * FROM countries");
    $statement->execute();
    $result=$statement->get_result();
    // check if there are recorsds
    $records = array();
    if($result->num_rows > 0){
       // fetch records
        while ($rows = $result->fetch_assoc()){
        $records[] = $rows;
       }
     return $records;
   }
}

#begin sanitize method
function sanitizeInput($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = addslashes($data);

    return $data;
}

#end sanitize input
}
?>
