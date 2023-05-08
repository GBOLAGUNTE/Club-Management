<!DOCTYPE html>
<html lang="en">

<head>
<?php include_once "shared/constants.php"; ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>
  
  </title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  
<style type="text/css">
.nav-link{ color:white;}
.nav-link:hover{
	color:grey;
}
</style>


</head>

<body>
<?php 
session_start();

if (isset($_SESSION['logger']) && $_SESSION['logger'] == 'My_key') {

// Give Access
}else {
  $message = "You need to login to access this page";
  header("Location: login.php?notice=$message");
  exit();
}
?>
  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg  fixed-top header-footer-bg" >
    <div class="container">
      <a class="navbar-brand" href="index.html"><img src="images/logo2.png" width='100'></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sales.php">Products</a>
          </li>
		   <li class="nav-item">
            <a class="nav-link" href="allmembers.php">View All Members</a>
          </li>
		   <li class="nav-item">
            <a class="nav-link" href="allclubs.php">View All Clubs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="report.html">Payment Report</a>
          </li>
		   
         <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
           
         
        </ul>
      </div>
    </div>
  </nav>