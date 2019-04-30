<?php 
    include 'core/connection.php';
    /* Queries */ 
    $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = 0 "); 
    $stmt->execute(array());
    $category = $stmt->fetchAll();
    $count = $stmt->rowCount();
    /* Quey For Child Categories */


?>

<!-- Start Navbar  -->
<nav class="navbar navbar-default navbar-fixed-top">
     <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">ShoppingStore</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
             <ul class="nav navbar-nav navbar-right">
                <?php 
                     foreach($category as $cat) { /* while 1 */ ?> 
                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$cat["category"]; ?> </a>
                    <?php  
                        $parent_id = $cat["category_id"];
                        $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = $parent_id ");
                        $stmt->execute(array());
                        $row = $stmt->fetchAll();
                    ?>
                    
                    <ul class="dropdown-menu">
                     <?php foreach($row as $cat ) { /* while 2 */?>
                        <li><a href="#"><?= $cat['category'];?></a></li>
                     <?php } /* endwhile 1 */?> 
                   </ul>
                 </li>
              <?php } /* endwhile 2 */?> 
            
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Setting </a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Edit Profile</a></li>
                    <li><a href="#">Security</a></li>
                    <li><a href="#">Setting</a></li>
                    <li><a href="#">Log Out</a></li>
                  </ul>
                </li>
            </ul>
          </div>
       </div>
 </nav>
    <!-- End Navbar  -->
 