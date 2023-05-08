<?php include_once "portalheader.php";  ?>


<!-- Page Content -->
<link type='text/css' rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
  <div class="container" style='min-height:500px'>

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">
      <?php 
      if (isset($_SESSION['myrolename'])) {
        echo $_SESSION['myrolename'];
      }
      ?>
      <small>Transaction Status</small>
    </h1>
      <h5 class="mb-3">
        <?php 
           if (isset($_SESSION['myfirstname'])) {
            echo "Welcome ".$_SESSION['myfirstname']." ".$_SESSION['mylastname'];
          }
        ?>
      </h5>
           <!-- Icon Cards-->
        <div class="row">
            <div class="col-md-8">
                    <div class="alert alert-success">
                        <h2>Transaction Successsful</h2>
                        <p>Payment Completed</p>
                    </div>
            </div>
        </div>
		
		
	<!-- /.row -->

  </div>
  <!-- /.container -->

  <?php include_once "portalfooter.php";  ?>