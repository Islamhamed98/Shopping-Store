<?php 
    include 'core/connection.php';
    include 'includes/head.php';
    include 'includes/navigationbar.php';
    include 'includes/slider.php';
    include 'includes/leftbar.php';
    /** 
     * Query For Get Products.
    */
    $stmt = $conn->prepare("SELECT * FROM products WHERE featured = 1 ");
    $stmt->execute(array());
    $my_products = $stmt->fetchAll();
?>

        <!-- ======================================================== -->

        <!-- ======================================================================================= -->
        <!-- Start Fashions Section  -->

            <!-- Main Content -->
            <div class="col-md-8">
                <div class="row">
                    <h2 class="text-center"> Features Products </h2>
                    <?php 
                        foreach( $my_products as $product )  { /* while */ 
                         $_SESSION['id'] = $product['product_id'];
                     ?>
                        <div class="col-md-3">
                            <h4><?=$product['title'];?></h4>
                            <img src="<?=$product['image'];?>" alt="<?=$product['title'];?>" class="img-responsive img-thumb" />
                            <p class="list-price text-danger">List Price: <s>$<?=$product['list_price'];?></s> </p>
                            <p class="price">Our Price: $<?=$product['price'];?> </s> </p>
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="detailsmodal(<?=$product['product_id'];?>)" data-target="#details-1"> Details </button>
                        
                        </div>
                    <?php } ?>
                 </div>
            </div>

        <!--End Fashion Section -->
        <!-- ===================================================================================== -->
          
        <!-- Details Modal -->
        <div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">    
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title text-center" id="modal_title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="center-block">
                                        <img src="<?=$product['image']; ?>" alt="girl's bag" class="details img-responsive" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h4>Details</h4>
                                    <p><?=$product['description']; ?></p>
                                    <hr>
                                    <p class="text-danger">Last Price: <s>$<?=$product['list_price']; ?></s></p>
                                    <p>Price: $<?=$product['price']; ?></p>
                                    <p>Brand: <?=$product['brand']; ?></p>
                                    <form action="add_cart.php" method="post">
                                        <div class="form-group">
                                            <div class="col-xs-3" style="margin-left:-15px">
                                                <label for="quantity">Quantity: </label>
                                                <input type="text" class="form-control" id="quantity" name="quantity">
                                            </div>
                                            <p>Available: 3 </p>
                                        </div>
                                        <div class="form-group">
                                        <br><br>
                                            <label for="size">Size: </label>
                                            <select name="size" id="size" class="form-control">
                                                <option value=""></option>
                                                <option value="28">28</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>     
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-warning" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart</button>
                    </div>                
                </div>    
            </div>
        </div>

        <!-- ===================================================================================== -->
<?php 
   
    include 'includes/rightbar.php';
    include 'includes/footer.php';

?>

