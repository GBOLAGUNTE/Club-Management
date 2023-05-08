<?php include_once "portalheader.php"?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-4 mb-3">
                    <small>Delete Club</small>
            </h1>

            <?php
            if (isset($_REQUEST['clubname'])) {
                echo "<div class='alert alert-warning mb-4'>
                <h2>Are you sure you want to delete ".$_REQUEST['clubname']." record? </h2>
        
                </div>";
            }
            
            ?>

            <form action="deleterecord.php" method="post">
                <input type="hidden" name="clubid" value="<?php if(isset($_REQUEST['clubid'])){echo $_REQUEST['clubid'];} ?>">
                <input type="submit" value="Delete" name="btnDelete" class="btn btn-danger">
                <input type="submit" value="Cancel" name="btnCancel" class="btn btn-secondary">

            </form>
        </div>
    </div>
</div>

<?php include_once "portalfooter.php"?>