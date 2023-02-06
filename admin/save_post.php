<?php

include "../dataBase.php";
$obj = new DataBase; 

// echo "echo".$_POST['save'];

if(isset($_POST["save"])){

  $obj->Img_Up("fileToUpload","uplode/");
  $result = $obj->Img();
  $file_name = $result[0];

  session_start();

  $titel = $_POST['post_title'];
  $description = $_POST['postdesc'];
  $category = $_POST['category'];
  $date = date("d M,Y");
  $author = $_SESSION["user_id"];

  $sql="INSERT INTO post(title,description,category,post_date,author,post_img) 
    value('{$titel}','{$description}','{$category}','{$date}',{$author},'{$file_name}');";
  $sql.="UPDATE category set post=post + 1 where category_Id={$category}";

  if($obj->sql($sql)){
    header("location: {$hostname}/admin/post.php");
  }else{
      echo "<div class='alert alert-denger'> Query Failed . </div>";
  }

}else{
  echo "no file found";
}

?>

