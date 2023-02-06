<?php
    include '../database.php';
    $obj= new DataBase();
    if($_SESSION["user_role"] == '0'){
      header("Location: {$hostname}/admin/post.php");
    }
    $cat_id = $_GET["id"];

    if ( $obj->delete('category',"category_id ='{$cat_id}'")) {
        header("location:{$hostname}/admin/category.php");
    }


?>