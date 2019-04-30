<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/shoppingStore/core/connection.php';
    include 'includes/head.php';
    include 'includes/navigationbar.php';
    
    // get products from database 
    $stmt = $conn->prepare("SELECT * FROM products WHERE deleted = 0");
    $stmt->execute(array());
    $main_products = $stmt->fetchAll();
     
    // Update Featured Product 
    if( isset($_GET['featured']) ) { 
        $feat_id = $_GET['id'];
        $featured = $_GET['featured'];
        $stmt = $conn->prepare("UPDATE products SET featured ='$featured' WHERE product_id = '$feat_id' ");
        $stmt->execute(array());
        header("Location:products.php");
    }

    // Get Request 
    if(isset($_GET['add'])) { 
            // Get Brands From Database 
            $stmt = $conn->prepare("SELECT * FROM brand ORDER BY brand");
            $stmt->execute();
            $get_brands=$stmt->fetchAll();

            // Get Parent Category From Database 
            $stmt =$conn->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
            $stmt->execute(array());
            $parent_cats = $stmt->fetchAll();

        ?>
        <form action="products.php?add=1" method="POST" enctype="multipart/form.data">
            <div class="form-group col-md-3">
                <label for="title">Title :</label>
                <input type="text" name="title" id="title" class="form-control" value"title"/>
            </div>
            <div class="form-group col-md-3">
                <label for="brand">Brand : </label>
                <select class="form-control" name="brand" id="brand">
                    <option value="" <?=( (isset($_POST['brand']) && $_POST['brand'] == '' )? 'selected':'');?>></option>
                    <?php foreach($get_brands as $get_brand) {?>
                         <option value="<?=$get_brand['brand_id'];?>" <?=( (isset($_POST['brand']) && $_POST['brand'] == $get_brand['brand_id'] )?           'selected':'');?>><?=$get_brand['brand'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="from-group col-md-3">
                <label for="parent">Parent Category : </label>
                <select name="parent" id="parent" class="form-control">
                    <option value="" <?=(( isset($_POST['parent']) && $_POST['parent'] == '')? 'selected':'');?>></option>
                    <?php foreach($parent_cats as $parent_cat) { ?>
                    <option value="<?=$parent_cat['category_id'];?>" <?=(( isset($_POST['parent']) && $_POST['parent'] == $parent_cat['category_id']) ? 'selected' : '');?>><?=$parent_cat['category'];?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="child">Child Category : </label>
                <select name="child" id="child" class="form-control">
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="price">Price : </label>
                <input type="text" id="price" name="price" class="form-control" value="<?=((isset($_POST['price']))? $_POST['price']:'' );?>"/>
            </div>
            <div class="form-group col-md-3">
                <label for="price">list price : </label>
                <input type="text" id="list_price" name="list_price" class="form-control" value="<?=((isset($_POST['list_price']))? $_POST['list_price']:'' );?>"/>
            </div>
            <div class="form-group col-md-3">
                <label> Quantity & Sizes </label>
                <button class="btn btn-default form-control" onclick="$('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
            </div>
            <div class="form-group col-md-3">
                <label for="sizes">Sizes & Qty Preview </label>
                <input type="text" class="form-control" name="sizes" id="sizes" value="<?=((isset($_POST['sizes']))? $_POST['sizes']:'' );?>" readonly/>
            </div>
            <div class="form-group col-md-6">
                <label for="photo">Choise Photo : </label>
                <input type="file" name="photo" id="photo" class="form-control">
            </div>   
            <div class="form-group col-md-6">
                <label for="description">Description : </label>
                <textarea name="description" id="description" class="form-control"cols="30" rows="10" ><?=((isset($_POST['description']))? $_POST['description']:'' );?></textarea>
            </div>
            <input type="submit" value="Add Product" class="form form-control btn btn-success">

        </form>

    <?php } else { ?>
<h2 class="text-center">Products</h2>
<table class="table table-bordered table-condensed table-stripped">
    <thead>
        <th></th>
        <th>Product</th>
        <th>Price</th>
        <th>Category</th>
        <th>Featured</th>
        <th>Sold</th>
    </thead>
    <tbody>
    <?php 
        foreach($main_products as $main_product) { 
            $main_category = '';
            $child_id = $main_product['categories'];
            $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = '$child_id' ");
            $stmt->execute(array());
            $category = $stmt->fetch();
            $parent_cat = $category['parent'];
            $stmt=$conn->prepare("SELECT * FROM categories WHERE category_id = '$parent_cat' ");
            $stmt->execute(array());
            $category_parent = $stmt->fetch();
            $main_category.=$category_parent['category'].'-'. $category['category'];
    ?>
        <tr>
            <td>
                <a href="products.php?edit=<?=$main_product['product_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="products.php?delete=<?=$main_product['product_id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
            <td><?=$main_product['title'];?></td>
            <td><?=money($main_product['price']);?></td>
            <td><?= $main_category;?></td>
            <td>
                <a href="products.php?featured=<?=(($main_product['featured'] == 0)? '1':'0');?>&id=<?=$main_product['product_id'];?>" class="btn     btn-xs btn-default"> <span class="glyphicon glyphicon-<?=(($main_product['featured'] == 1)?'minus':'plus');?>"></span></a>
                 <span>&nbsp; <?=(($main_product['featured'] == 1)?'Featured Product':'');?></span>
            </td>   
            <td></td>
        </tr>
    <?php 
     }
    ?>
    </tbody>
</table>
<a href="products.php?add=1" class="btn btn-success btn-block">Add Product</a> 

<?php 
    }
    include 'includes/footer.php';
?>