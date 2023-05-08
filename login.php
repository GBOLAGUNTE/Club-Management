<?php
$page_title = "Login";
include_once "header.php";


if (isset($_REQUEST['btnlogin'])) {
  
  //validate the form
   $errors = array();
   if (empty($_REQUEST['username'])) {
   $errors[] = "Username field cannot be empty!";
   }
   if (empty($_REQUEST['pwd'])) {
   $errors[] = "Password field cannot be empty!";
   }

   // no validation error
   if (empty($errors)) {
   // add user class
    // add user class
include_once ("shared/user.php");
// create instance of user class
  $userobj = new User();
  // reference login method
  $output = $userobj->login($_REQUEST['username'], $_REQUEST['pwd']);

  if ($output === false) {
    $errors[] = "Invalid username or password!";
  }else {
    // redirect the user to dashboard
    header("Location: dashboard.php");
    exit();
  }
   }
}


?>
  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3 text-center">
      <small>Login</small>
    </h1>
    

   
    

    <div class="row" style='min-height:400px;'>
      <div class="col-lg-8 col-md-8  offset-md-2 offset-lg-2 col-sm-12">
      <?php 
        if (isset($errors)) {
          foreach ($errors as $key => $value){
            echo "<div class='alert alert-danger'>$value</div>";
          }
        }

        if (isset($_REQUEST['notice'])) {
          echo "<div class='alert alert-danger'>".$_REQUEST['notice']."</div>";
        }
        ?>
 
         <form action='login.php' method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" name='username' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
     
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name='pwd' class="form-control" id="exampleInputPassword1">
  </div>
  
  <button type="submit" class="btn btn-info btn-block" id="btnlogin" name="btnlogin">Login</button>
</form>
      </div>
    
     
      
     
      
    </div>

    

  </div>
  <!-- /.container -->


<?php
include_once "footer.php";
?>