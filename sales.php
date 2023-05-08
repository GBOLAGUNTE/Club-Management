<?php include_once "portalheader.php" ?>
<div class="container" style='min-height:500px'>
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2>Sales Product</h2>
        <?php
        include_once "shared/product.php";
        // create object of product class
        $objprd = new Product;
        //make reference to getProduct method
        $products = $objprd->getProducts();
    // echo "<pre>";
    // print_r($products);
    // echo "</pre>";
    echo "<div class = 'row'>";
        if (count($products) > 0) {
            foreach ($products as $key => $value){

          ?>      
          <div class="col-md-4">
                <img src="images/<?php echo $value['imageurl'] ?>" alt="<?php echo $value['product_name'] ?>" class="img-fluid">
                <h6><?php echo $value['product_name'] ?></h6>
                <span>&#8358;<?php echo number_format($value['price'], 2); ?></span>
                <form method="post" action="confirmsales.php">
                    <input type="hidden" name="amount" value="<?php echo $value['price']; ?>">
                    <input type="hidden" name="productid" value="<?php echo $value['product_id']; ?>">
                    <input type="hidden" name="productname" value="<?php echo $value['product_name']; ?>">
                    <input type="hidden" name="productimage" value="<?php echo $value['imageurl']; ?>">
                    

                <button class='btn btn-primary btn-sm' name="btnsales">Buy</button>
                
                </form>           
        </div>
        <?php
            }
        }
        echo "</div>";
        ?>
    </div>
</div>

</div>



<?php include_once "portalfooter.php" ?>