<?php 
    include '../core/connection.php';
    include 'includes/head.php';
    include 'includes/navigationbar.php';
    // data variables
    $errors=array();
    $brand_value = 'adidas';
    // get brands from database 
    $stmt = $conn->prepare("SELECT * FROM brand ORDER BY brand");
    $stmt->execute(array());
    $brands = $stmt->fetchAll();



    //Edit Brand 
    if( isset($_GET['edit']) && !empty($_GET['edit']) ) { 
        $edit_brand_id = ($_GET['edit']);
        $stmt = $conn->prepare("SELECT * FROM brand WHERE brand_id = '$edit_brand_id '");
        $stmt->execute();
        $edit_brand = $stmt->fetch();
        $brand_value =  $edit_brand['brand'];
    }



    //Delete Brand 
    if( isset($_GET['delete']) && !empty($_GET['delete']) ) { 
        $delete_brand_id = ($_GET['delete']);
        $stmt = $conn->prepare("DELETE FROM brand WHERE  brand_id = '$delete_brand_id' " );
        $stmt->execute(array());
        header("Location:brand.php"); 
    }

     // add brand is submitted
    if(isset($_POST['add_submit'])) { 
        // Check if brand is blank 
        $brand = (isset($_POST['brand'])) ? $_POST['brand']: '' ;
        if( $_POST['brand']  == '')  {
           $errors[] .='You must enter a brand';
        }  
        // Check if brand exist in database
        $stmt = $conn->prepare("SELECT * FROM brand WHERE brand = '$brand' ");
        $stmt->execute(array()); 
        $Count = $stmt->rowCount();
        if($Count > 0) {   
            $errors[].= $brand . ' The Brand is already exist..., enter another one';
        }
        // display errors 
        if(!empty($errors)) { 
            // display errors 
            echo display_errors($errors);
        } else { 
            // add brand in database 
            $stmt = $conn->prepare("INSERT INTO brand (brand) VALUES ('$brand')");
            //Edit brand in database 
            if(isset($_GET['edit'])) { 
                $stmt= $conn->prepare("UPDATE brand SET brand = '$brand' WHERE brand_id = '$edit_brand_id' ");
            }
            $stmt->execute(array());
            header('Location: brand.php');
        }
       
    }
    // brand value 
    

    
?> 
<h2 class="text-center">Brands</h2>
<hr>
    <div class="text-center">
        <form class="form-inline" action="brand.php<?=((isset($_GET['edit']))?'?edit='.$edit_brand_id:'');?>" method="post">
            <div class="form-group">
                <label for="brand"> <?= ((isset($_GET['edit']))?'Edit':'Add'); ?> A Brand: </label>
                <input type="text" name="brand" class="form-control" value="<?=$brand_value;?>"/>
                <input type="submit" name="add_submit" value=" <?=((isset($_GET['edit']))?'Edit':'Add'); ?> Brand" class="btn btn-success"/>
                <?php if(isset($_GET['edit'])): ?>
                    <a href="brand.php" class="btn btn-default">Cancel</a>
                <?php endif;?>
            </div>
        </form>
    </div>

<hr>


<table class="table table-bordered table-striped table table-auto">
    <thead>
        <th></th><th>Brand</th> <th></th>
    </thead>
   <?php foreach( $brands as $brand ) {  ?>
   <tbody>
        <tr>
            <td><a href="brand.php?delete=<?=$brand['brand_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>    
            <td><?=$brand['brand'];?></td>    
            <td><a href="brand.php?edit=<?=$brand['brand_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>    
        </tr>
    </tbody>
    <?php } ?> 
</table> 


<?php 
       include 'includes/footer.php';
?>