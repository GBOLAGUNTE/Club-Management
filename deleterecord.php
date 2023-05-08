<?php 
if (isset($_REQUEST['btnCancel'])) {
   // redirect to allclubs.php
   header("Location: allclubs.php");
   exit;
}

if (isset($_REQUEST['btnDelete'])) {
    # add club class
    include_once "shared/club.php";

    // create object of class club
    $clubobj = new Club();
    $output = $clubobj->deleteClub($_REQUEST['clubid']);
    
    if ($output == true) {
        $status = "success";
        $msg = "Club was successfully deleted";
    }else {
        $status = "failed";
        $msg = "Oops ! something went wrong, try it later";
    }

    //redirect to allclubs.php
    header("Location: allclubs.php?msg=$msg&status=$status");
}
?>