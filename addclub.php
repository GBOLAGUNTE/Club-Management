<?php 
include_once "portalheader.php";
include_once "shared/common.php";

//create instance
$cobj = new Common();
$countries = $cobj->getCountries();

echo "<pre>";
print_r($_FILES);
echo "</pre>";

if (isset($_REQUEST['btnsubmit'])) {
 
  // form validate
  $errors = array();

  if (empty($_REQUEST['clubname'])) {
    $errors[] = "Club name is required";
  }
  if (empty($_REQUEST['clubdesc'])) {
    $errors[] = "Club Desc is required";
  }
  if (empty($_REQUEST['estyear'])) {
    $errors[] = "Year Established is required";
  }
  if (empty($_REQUEST['country'])) {
    $errors[] = "Country is required";
  }
  if ($_FILES['emblem']['error'] > 0) {
   $errors[] = "You've not uploaded any file or your file is corrupted!";
  }

  // more than 1mb
  if ($_FILES['emblem']['size'] > 1048576) {
    $errors[] = "File sixe cannot be more than 1mb";
  }

  // the file type
  $ext_allowed = array("jpg","png","webp","gif","jpeg","svg");
  $filename_arr = explode(".",$_FILES['emblem']['name']);
  $filename_ext = end($filename_arr);

  if (!in_array(strtolower($filename_ext), $ext_allowed)) {
    $errors[] = "Filename not allowed";
  }
  // process the form data
  if (empty($errors)) {
   // sanitize inpts
   $clubname = $cobj->sanitizeInput($_REQUEST['clubname']);
   $slogan = $cobj->sanitizeInput($_REQUEST['slogan']);
   $desc = $cobj->sanitizeInput($_REQUEST['clubdesc']);
   $estyear = $_REQUEST['estyear'];
   $country = $_REQUEST['country'];

   // add club class
   include_once "shared/club.php";
   $clubobj = new Club(); // club object
   // reference insertClub method and pass parameters
   $output = $clubobj->insertClub($clubname, $slogan,$desc,$estyear,$country);

   if ($output == 'success') {
   // redirect to allclubs.php
   $msg = "success";
   header("Location: allclub.php?msg=$msg");
   exit();
   header("Location: allclubs.php");
   exit();
   }else {
    $errors[] = $output;
   }

  }
}
?>

<!-- //check if button is clicked -->


 <!-- Page Content -->
 <div class="container">

<!-- Page Heading/Breadcrumbs -->
<h1 class="mt-4 mb-3">
  <small>Add Club</small>
</h1>




<div class="row">
  <div class="col-lg-8 mb-4">
  <?php 
        if (isset($errors)) {
          foreach ($errors as $key => $value){
            echo "<div class='alert alert-danger'>$value</div>";
          }
        }
        ?>
    <form name="clubform" id="registerform" action='addclub.php' method="post" enctype="multipart/form-data">
      <div class="control-group form-group">
        <div class="controls">
          <label>Club Name:</label>
          <input type="text" class="form-control" id="clubname" name='clubname' value="<?php 
          if(isset($_REQUEST['clubname'])){
                echo $_REQUEST['clubname'];
          }
          
          ?>">
          
        </div>
      </div>
      <div class="control-group form-group">
        <div class="controls">
          <label>Slogan:</label>
          <input type="text" class="form-control" id="slogan" name='slogan' value="
          <?php if (isset($_REQUEST['slogan'])) {
             echo $_REQUEST['slogan'];
          } ?>
          
          ">
         
        </div>
      </div>
      <div class="control-group form-group">
        <div class="controls">
          <label>Emblem:</label>
          <input type="file" class="form-control" id="emblem" name="emblem" >
        </div>
      </div>
     
      <div class="control-group form-group">
        <div class="controls">
          <label>Description (short):</label>
          <textarea rows="5" cols="50" name='clubdesc' class="form-control" id="clubdesc"  maxlength="300" style="resize:none"><?php 
          if (isset($_REQUEST['clubdesc'])) {
            echo $_REQUEST['clubdesc'];
          }
          
          ?></textarea>
        </div>
      </div>
      <div class="control-group form-group">
        <div class="controls">
          <label>Year Established:</label>
        <select name="estyear" id="estyear" class="form-select">
          <option value="">Choose Year Established</option>
          <?php 
          for($year=1890; $year <= 1990 ; $year++){ 
            if(isset($_REQUEST['estyear']) && $_REQUEST['estyear'] == $year) {
              echo "<option value='$year' selected>$year</option>";
            }else{
              echo "<option value='$year'>$year</option>";
            }
          
          }
          ?>

        </select>
        </div>
      </div>
      <div class="control-group form-group">
        <div class="controls">
          <label>Country:</label>
        <select name="country" id="country" class="form-select">
          <option value="">Choose Country</option>
          <?php
            foreach ($countries as $key => $value){
              $countryid = $value['country_id'];
              $countryname = $value['country_name'];
              if (isset($_REQUEST['country']) && $_REQUEST['country'] == $countryid) {
                echo "<option value='$countryid' selected>$countryname</option>";
              }else {
                echo "<option value='$countryid'>$countryname</option>";
              }
              
            }
          ?>

        </select>
        </div>
      </div>
       
      
      <input type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit" value="submit">
    </form>
  </div>

</div>
<!-- /.row -->

</div>
<!-- /.container -->
<?php 
include_once "portalfooter.php";
?>