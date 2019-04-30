<?php
  $dsn = 'mysql:host=localhost;dbname=shopping_store';
  $user= 'root';
  $password='';
  $option = array(
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
  );

    try{
        $conn = new PDO( $dsn , $user , $password , $option );
        $conn->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );

      } catch ( PDOException $e ){
          echo "failed" . $e->getMessage();
}



require_once $_SERVER['DOCUMENT_ROOT'] . '/shoppingStore/config.php';
require_once BASEURL.'helpers/helpers.php';