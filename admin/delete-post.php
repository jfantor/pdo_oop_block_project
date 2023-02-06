<?php
  include "../database.php";
  $obj = new DataBase;

  $post_id = $_GET['id'];
  echo $post_id;
  $cat_id = $_GET['catid'];

  $obj->select('post',"*",null,"post_id = {$post_id}");
  $row = $obj->get_result();

  unlink("upload/".$row['post_img']);

  $sql= "DELETE FROM post WHERE post_id = {$post_id};";
  $sql .= "UPDATE category SET post= post - 1 WHERE category_id = {$cat_id}";

  if($obj->sql($sql)){
    header("location: {$hostname}/admin/post.php");
  }else{
    echo "Query Failed";
  }
?>
