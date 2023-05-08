<?php 
include_once "portalheader.php";
include_once "shared/common.php";
include_once "shared/club.php";

//create instance
$cobj = new Common();
$countries = $cobj->getCountries();

//create object of class club
$myclubobj = new Club();

if (isset($_REQUEST['clubid'])) {
  //make reference to getclub method
  $club = $myclubobj->getClub($_REQUEST['clubid']);

  echo "<pre>";
  print_r($club);
  echo "</pre>";
}

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


 
  // process the form data
  if (empty($errors)) {
   // sanitize inpts
   $clubname = $cobj->sanitizeInput($_REQUEST['clubname']);
   $slogan = $cobj->sanitizeInput($_REQUEST['slogan']);
   $desc = $cobj->sanitizeInput($_REQUEST['clubdesc']);
   $estyear = $_REQUEST['estyear'];
   $country = $_REQUEST['country'];
   $clubid = $_REQUEST['clubid'];

   // add club class
   include_once "shared/club.php";
   $clubobj = new Club(); // club object
   // reference insertClub method and pass parameters
   $output = $clubobj->updateClub($clubname, $slogan,$desc,$estyear,$country,$clubid);

   if ($output == 'success' || $output == 'nothing to update') {
   // redirect to allclubs.php
  //  $msg = "success";
  //  header("Location: allclub.php?msg=$msg");
  //  exit();
   header("Location: allclubs.php?msg=$output");
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
  <small>Edit Club</small>
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
    <form name="clubform" id="registerform" action='editclub.php?clubid=<?php if (isset($_REQUEST['clubid'])) {
     echo $_REQUEST['clubid'];
    } ?>' method="post" enctype="multipart/form-data">
      <div class="control-group form-group">
        <div class="controls">
          <label>Club Name:</label>
          <input type="text" class="form-control" id="clubname" name='clubname' value="<?php 
          if (isset($club['club_name'])) {
            echo $club['club_name'];
          }
          
          ?>">
          
        </div>
      </div>
      <div class="control-group form-group">
        <div class="controls">
          <label>Slogan:</label>
          <input type="text" class="form-control" id="slogan" name='slogan' value="
          <?php if (isset($club['slogan'])) {
             echo $club['slogan'];
          } ?>
          
          ">
         
        </div>
      </div>
     
     
      <div class="control-group form-group">
        <div class="controls">
          <label>Description (short):</label>
          <textarea rows="5" cols="50" name='clubdesc' class="form-control" id="clubdesc"  maxlength="300" style="resize:none"><?php 
          if (isset($club['club_desc'])) {
            echo $club['club_desc'];
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
            if(isset($club['year_established']) && $club['year_established'] == $year) {
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
              if (isset($club['country_id']) && $club['country_id'] == $countryid) {
                echo "<option value='$countryid' selected>$countryname</option>";
              }else {
                echo "<option value='$countryid'>$countryname</option>";
              }
              
            }
          ?>

        </select>
        </div>
      </div>
       <!--Hidden fields for clubid-->
      <input type="hidden" name="clubid" value="<?php if(isset($club['club_id'])){echo $club['club_id'];} ?>">
      <input type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit" value="Save Changes">
    </form>
  </div>

</div>
<!-- /.row -->

</div>
<!-- /.container -->
<?php 
include_once "portalfooter.php";
?>