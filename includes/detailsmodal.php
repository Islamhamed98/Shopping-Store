 
 <?php
    require_once("c:/xampp/htdocs/shoppingStore/core/connection.php");

    $product_id = $_GET['id'] ;
    $product_id = (int) $product_id;
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = $product_id ");
    $stmt->execute(array());
    $product = $stmt->fetch();
    $sizestring = $product['size'];
    
    print_r( json_encode($product) ); 
    

 ?>
