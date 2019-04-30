<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/shoppingStore/core/connection.php';
    $parent_id = (int)$_POST['parentID'];
    $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = '$parent_id' ORDER BY category ");
    $stmt->execute(array());
    $childs = $stmt->fetchAll();
   
   ob_start(); 
?>
    <option value=""></option>
    <?php foreach($childs as $child ) { ?>
       <option value="<?=$child['category_id'];?>"><?=$child['category'];?></option>
    <?php } ?>
    
<?php echo ob_get_clean();?>