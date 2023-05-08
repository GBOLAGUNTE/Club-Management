<?php
// add constants
include_once "constants.php";

// class definition
class User{
    //member variables
    var $lastname;
    var $firstname;
    var $mycon; // database connection handler

    // member methods
    function __construct(){
// connect to database
    $this->mycon = new mySQLi(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

        if ($this->mycon->connect_error) {
           die("Connection Failed: ".$this->mycon->connect_error);
        }

    }
    # begin login method
    function login($email,$password){
        // prepare statement
        $statement = $this->mycon->prepare("SELECT * FROM users JOIN roles ON users.role_id = roles.role_id WHERE emailaddress=?");
        // bind parameter
        $statement->bind_param("s",$email);
        //execute
        $statement->execute();
        // result set
        $result = $statement->get_result();

        // fetch the data from result set
        if ($result->num_rows == 1) {
            // record exist
            $row = $result->fetch_assoc();
            // echo "<pre>";
            // print_r($row);
            // echo"</pre>";

            // verify password
            if (password_verify($password,$row['password'])) {
                //password match
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['mylastname'] = $row['lastname'];
                $_SESSION['myfirstname'] = $row['firstname'];
                $_SESSION['myemail'] = $row['emailaddress'];
                $_SESSION['logger'] = "My_key";
                $_SESSION['myroleid'] = $row['role_id'];
                $_SESSION['myrolename'] = $row['role_name'];

                return true;
            }else {
                // password does not match
                return false;
            }

        }else {
            // email does not exist
            return false;
        }
    }
    # end login method

    # logout method

    #begin logout method
    function logout(){
        session_start();
        session_destroy();

        // redirect the user to login page
        header("Location: login.php ");
        exit();
    }
    #end logout method
}

?>