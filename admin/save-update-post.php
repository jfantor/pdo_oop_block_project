<?php
include "../database.php";
$obj = new DataBase; 

if(empty($_FILES['new-image']['name'])){
    $file_name = $_POST['old_image'];
}else{
    $obj->Img_Up("new-image","uplode/");
    $result = $obj->Img();
    $file_name = $result[0];
}

$sql = "UPDATE post SET title='{$_POST["post_title"]}',description='{$_POST["postdesc"]}',category={$_POST["category"]},post_img='{$file_name}'
        WHERE post_id={$_POST["post_id"]};";
if($_POST['old_category'] != $_POST["category"] ){
  $sql .= "UPDATE category SET post= post - 1 WHERE category_id = {$_POST['old_category']};";
  $sql .= "UPDATE category SET post= post + 1 WHERE category_id = {$_POST["category"]};";
}

// $result = mysqli_multi_query($conn,$sql) or die('orjjoigfjoijoi');

if($obj->sql($sql)){
  header("location: {$hostname}/admin/post.php");
}else{
  echo "Query Failed";
}

?>

