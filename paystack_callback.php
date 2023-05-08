<?php
var_dump($_REQUEST);
if (isset($_REQUEST['reference'])) {
    # code...

//include add payment class
include_once "shared/payment.php";
// create instance of payment class
$objpay = new Payment;
// access verifyPaystackTransaction method
$result = $objpay->verifyPaystackTransaction($_GET['reference']);

echo "<pre>";
print_r($result->data->status);
echo "</pre>";
if ($result->data->status == 'success') {
    $datepaid = $result->data->created_at;
    $reference = $_GET['reference'];  
    // access updateTransaction method
    $output = $objpay->updateTransaction($reference, $datepaid);

    if ($output == true) {
        # redirect to transsuccess.php
        header("Location: transuccess.php");
        exit;
    }
}else {
    die("Oops, something happened ".$result->message);
}

}
?>