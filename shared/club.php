<?php 
    include_once "constants.php";

    //class definition
    class Club{
        // member variables
        var $clubname;
        var $yearestablished;
        var $slogan;
        var $mycon;

          // member functions
    function __construct(){
        // connect to database
            $this->mycon = new MySQLi(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
        
                if ($this->mycon->connect_error) {
                   die("Connection Failed: ".$this->mycon->connect_error);
                }
        
            }

            #begin getAllCluubs method
            function getAllClubs(){
                $statement = $this->mycon->prepare("SELECT * FROM clubs JOIN countries ON clubs.country_id = countries.country_id");
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
            #end getAllCluubs method

            #begin insertClub method
            function insertClub($clubname, $slogan, $desc, $estyear, $country){
                // process file upload
                $filename = $_FILES['emblem']['name'];
                $file_tmp_name = $_FILES['emblem']['tmp_name'];

                $destination = "emblems/$filename";

                if (move_uploaded_file($file_tmp_name, $destination)) {
                    #insert record into clubs table
                    $stmt = $this->mycon->prepare("INSERT INTO clubs(club_name,year_established,club_desc,emblem,country_id,slogan)VALUES(?,?,?,?,?,?)");
                    //bind parameters
                    $stmt->bind_param("ssssss", $clubname,$estyear,$desc,$filename,$country,$slogan);
                    // execute
                    $stmt->execute();

                    
                   

                    if ($stmt->affected_rows == 1) {
                        return "success";
                    }else {
                        return "Oops! something went wrong".$stmt->error;
                    }
                }else {
                    return "Oops! something happened!";
                }
            }

            #end insertClub method

            #begin getClub method
            function getClub($clubid){
                // prepare the statement
                $statement = $this->mycon->prepare("SELECT * FROM clubs WHERE club_id=?");
                //bind
                $statement->bind_param("i",$clubid);
                //execute
                $statement->execute();
               
                //get result set
                $result = $statement->get_result();
                if ($result->num_rows == 1) {
                    return $result->fetch_assoc();

                }else {
                    return "Oops! something happened!";
                }
            }

            #end getClub method

            #begin updateClub method
            function updateClub($clubname,$slogan,$estyear,$desc,$country,$clubid){
                // prepare the statement
                $statement = $this->mycon->prepare("UPDATE clubs SET club_name=?, year_established=?,
                club_desc=?, country_id=?, slogan=? WHERE club_id=?");
                //bind parameters
                $statement->bind_param("sisisi", $clubname, $estyear,$desc,$country,$slogan, $clubid);
                // execute the query
                $statement->execute();

                if ($statement->affected_rows == 1) {
                    return "success";
                }elseif ($statement->affected_rows == 0) {
                    return "nothing to update";
                }else {
                    return "Oops! something went wrong ".$statement->error;
                }

            }


            #end updateClub method

            #begin delete method
            function deleteClub($clubid){
                $statement = $this->mycon->prepare("DELETE FROM clubs WHERE club_id=?");
            // bind parameter
            $statement->bind_param("i",$clubid);
            //execute
            $statement->execute();

            if ($statement->affected_rows == 1) {
               return true;
            }else {
               return false;
            }
            }
            




            #end delete method
    }
?>