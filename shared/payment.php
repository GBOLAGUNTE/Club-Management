<?php
include_once "constants.php";

// member variables
class Payment{
    public $amount;
    public $productid;
    public $mycon;
    public $key;
    // member functions
    public function __construct(){
        // connect to database
            $this->mycon = new MySQLi(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
        
            if ($this->mycon->connect_error) {
                   die("Connection Failed: ".$this->mycon->connect_error);
            }
            $this->key = "sk_test_ace4888b4ea7d76835943682d4a20423c55e9ebf";
        }

        public function insertTransaction($userid, $productid, $amount, $transreference){
            //prepare statement
            $stmt = $this->mycon->prepare("INSERT INTO payment(user_id, product_id, amount, datepaid, paymentstatus, paymentmode,
             trans_reference) VALUES(?,?,?,?,?,?,?)");
             //bind parameters
             $datepaid = date("Y-m-d h:i:s");
             $paymentstatus = "pending";
             $paymentmode = "online";
             $stmt->bind_param("iidssss", $userid, $productid, $amount, $datepaid, $paymentstatus, $paymentmode, $transreference);
             //execute
             $stmt->execute();

             if ($stmt->affected_rows == 1) {
                return true;
             }else {
                return false;
             }
        }

        #start initialize paystack transaction
        public function initPaystackTransaction($amount, $transreference, $emailaddress){
            $url = "https://api.paystack.co/transaction/initialize";
            $callback = "http://localhost/uefa/paystack_callback.php";
            $this->key = "sk_test_ace4888b4ea7d76835943682d4a20423c55e9ebf";


            $fields = [
                "email"=>$emailaddress,
                "amount"=>$amount * 100,
                "reference"=>$transreference,
                "callback_url"=>$callback

            ];

            $fieldstr = http_build_query($fields);
            // STEP 1:
            $ch = curl_init();

            //step 2

            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fieldstr);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch,CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer ".$this->key,
                "Cache-Control: no-cache"
            ));

            //step 3
            $response = curl_exec($ch);

            if (curl_error($ch) == true) {
                die("Error ".curl_error($ch));
            }
            // step 4: Close curl session
            curl_close($ch);

            //step 5: convert response to object
            $result = json_decode($response);

            return $result;

        }
        #end

        #start verify paystack transaction metrhod
        public function verifyPaystackTransaction($transreference){
            $url = "https://api.paystack.co/transaction/verify/".$transreference;

            // step 1: initialize curl

            $ch = curl_init();

            // step 2:: set curl options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch,CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer ".$this->key,
                "Cache-Control: no-cache"
            ));

            //step 3: execute curl
            $response = curl_exec($ch);

            if (curl_error($ch)) {
                die(" Curl Error: ".curl_error($ch));
            }

            // step 4: close open connection
            curl_close($ch);
            // step 5: convert json response to object

            return json_decode($response);
        }

        #end

        #start update transaction method
        public function updateTransaction($transreference, $datepaid){
            //prepare statement
            $stmt = $this->mycon->prepare("UPDATE payment set paymentstatus=?, datepaid=? WHERE trans_reference=?");
             //bind parameters
             
             $paymentstatus = "completed";
           
             $stmt->bind_param("sss", $paymentstatus, $datepaid, $transreference);
             //execute
             $stmt->execute();

             if ($stmt->affected_rows == 1) {
                return true;
             }else {
                return false;
             }
        }
        #end
}

?>