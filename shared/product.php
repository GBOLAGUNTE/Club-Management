<?php
include_once "constants.php";

    class Product{
        // member variables
        public $productname;
        public $price;
        public $qty;
        public $mycon;

        function __construct(){
            // connect to database
                $this->mycon = new MySQLi(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
            
                if ($this->mycon->connect_error) {
                       die("Connection Failed: ".$this->mycon->connect_error);
                }
            
            }

            #start getproducts method

            function getProducts(){
                $statement = $this->mycon->prepare("SELECT * FROM products");
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

            #end getproducts method
    }

?>