<?php include_once "portalheader.php"?>

<div class="container">
    <div class="row">
        <div class="col">
        <h1 class="mt-4 mb-3">
            <small>Add Club</small>
        </h1>
        <a href="addclub.php" class="btn btn-primary mb-3">Add Club</a>
        <?php
        if (isset($_REQUEST['status'])) {
          ?>  
       
        
        <div class="alert alert-success">
            <p>
                <?php if (isset($_REQUEST['msg'])) {
                    echo $_REQUEST['msg'];
                }
               ?>

           </p>

        </div>
        <?php
        }
        ?>
        <table class="table">
            <thead>
                    <tr>
                        <th>#</th>
                        <th>Emblem</th>
                        <th>Club Name</th>
                        <th>Year Established</th>
                        <th>Country</th>
                        <th>Club Desc</th>
                        <th>Slogan</th>
                        <th>Action</th>
                    </tr>
            </thead>
            <tbody>
                <?php
                include_once "shared/club.php";
                //create club object
                $obj = new Club();
                $clubs = $obj->getAllClubs();

                // echo "<pre>";
                // print_r($clubs);
                // echo "</pre>";

                if (count($clubs) > 0) {
                    $kounter = 0;
                    foreach ($clubs as $key => $item){
                  ?>
                  <tr>
                    <td><?php echo ++$kounter; ?></td>
                    <td>
                        <img src="emblems/<?php echo $item['emblem']; ?>" 
                        alt="club emblem" class="img-fluid" style="width:45px">
                    </td>
                    <td><?php echo $item['club_name'] ?></td>
                    <td><?php echo $item['year_established'] ?></td>
                    <td><?php echo $item['country_name'] ?></td>
                    <td><?php echo $item['club_desc'] ?></td>
                    <td><?php echo $item['slogan'] ?></td>
                    <td>
                        <a href="editclub.php?clubid=<?php echo $item['club_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="deleteclub.php?clubid=<?php echo $item['club_id'] ?>&clubname=<?php echo $item['club_name'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                  </tr>
                  <?php      
                    }
                }

                ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php include_once "portalfooter.php"?>