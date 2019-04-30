<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/shoppingStore/core/connection.php';
    include 'includes/head.php';
    include 'includes/navigationbar.php';
    // defined vars 
    $errors = array();
    $category='';
    $post_parent='';

    //Edit Category 
    if( isset($_GET['edit']) && !empty($_GET['edit']) ) { 
        $edit_id = $_GET['edit'];
        $stmt=$conn->prepare("SELECT * FROM categories WHERE category_id = '$edit_id'");
        $stmt->execute(array());
        $edit_cat = $stmt->fetch();
        // Get Parent
        $get_parent = $edit_cat['parent'];
    }

    
    // Delete Category 
    if( isset($_GET['delete']) && !empty($_GET['delete']) ) { 
        $deleted_id = $_GET['delete'];
        $stmt=$conn->prepare("DELETE FROM categories WHERE category_id = $deleted_id OR parent =  $deleted_id ");
        $stmt->execute(array());
        header("Location:categories.php");
    }
     
    // Get Category from database   
    $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = 0");
    $stmt->execute(array());
    $cat_rows=$stmt->fetchAll();
    
    
    
        //Process Form 
    if( isset($_POST) && !empty($_POST) ) {
        $post_parent = $_POST['parent'];
        $category = $_POST['category'];
        // if Post Request 
        $stmt = $conn->prepare("SELECT * FROM categories WHERE category = '$category' AND parent = ' $post_parent '");
        // if Get Request 
        if( isset($_GET['edit']) ) {
            $id = $edit_cat['category_id']; 
            $stmt = $conn->prepare("SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND 'category_id' != '$id' ");
        }
        
        $stmt->execute(array());
        $rows=$stmt->fetch();
        $Count=$stmt->rowCount();
         
        //Check if exist in database or not & Check errors
        if( $Count > 0 ) { 
            $errors[].=  $rows['category'] . ' is exist already Try another.... ';
        }
        if( empty($category)) { 
            $errors[].='you must enter category ';
        }
        // Display errors or Update database 
        if(!empty($errors)) { 
            $dispaly = display_errors($errors);    
            echo $dispaly;
        } else {
            // Update Categories 
            $stmt=$conn->prepare("INSERT INTO categories ( category, parent ) VALUES ('$category','$post_parent') ");
            if(isset($_GET['edit'])){
                $stmt=$conn->prepare("UPDATE categories SET category = '$category' , parent = '$post_parent' WHERE category_id='$edit_id' ");
            }
            
            $stmt->execute(array());
            header("Location:categories.php");      

        }       
    
    }
    // Show Category Name in Field Of Category 
    if( isset($_GET['edit']) ) {
        $category_value  = $edit_cat['category'];
        $parent_value = $get_parent;
    } else { 
        if(isset($_POST)) {
            $category_value  = $category;
            $parent_value = $post_parent;
        }
    }
 
 
    
?>


<h2 class="text-center"> Our Categories </h2>
<div class="row">
    <!-- Form  -->
    <div class="col-md-6">
         <legend><?=((isset($_GET['edit']))?'Edit ':'Add ');?>A Category </legend>
         <div id="errors"></div>
        <form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='. $edit_id .'' : '');?>" method="post">
            <div class="form-group">
                <label for="parent">Parent</label>
                <select name="parent" id="parent" class="form-control">
                    <option value="0" <?=(($parent_value == 0)?'selected="selected"' : '');?>>parent</option>
                    <?php foreach( $cat_rows as $cats ){ ?>
                     <option  value="<?=$cats['category_id'];?>" <?=(($parent_value == $cats['category_id'] )?'selected="selected"' : '');?>> <?=$cats['category'];?></option>
                    <?php } ?>
                </select>            
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                 <input type="text" class="form-control" id="category" name="category" value="<?=$category_value; ?>">
            </div>
            <div class="form-group">
                <input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> Category" class="btn btn-success">
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
                <th>Category</th><th>Parent</th><th>Edit | Delete</th>
            </thead>
            <tbody>
            <?php 
                foreach($cat_rows as $cat) { 
                $cat_id = $cat['category_id'];
                $stmt=$conn->prepare("SELECT * FROM categories WHERE parent = '$cat_id' ") ;
                $stmt->execute(array());
                $childs = $stmt->fetchAll(); 
             ?>
            <tr class="bg-primary">
                <td><?=$cat['category'];?></td>
                <td>parent</td>
                <td>
                    <a href="categories.php?edit=<?=$cat['category_id'];?>" class="btn btn-xs btn-success"> <span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="categories.php?delete=<?=$cat['category_id'];?>" class="btn btn-xs btn-danger"> <span class="glyphicon glyphicon-remove-sign"></span> </a>
                </td>
            </tr>
            <?php foreach( $childs as $child ) { ?> 
                <tr class="bg-info">
                    <td><?=$child['category'];?></td>
                    <td><?=$cat['category'];?></td>
                    <td>
                        <a href="categories.php?edit=<?=$child['category_id'];?>" class="btn btn-xs btn-success"> <span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="categories.php?delete=<?=$child['category_id'];?>" class="btn btn-xs btn-danger"> <span class="glyphicon glyphicon-remove-sign"></span> </a>
                    </td>
                </tr>
            <?php } 
             } ?>
            </tbody>
        </table>
    
    </div>
</div>









<?php 
    include 'includes/footer.php';
?>