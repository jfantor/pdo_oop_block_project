<?php
include "../database.php";
$obj= new DataBase;
if($_SESSION["user_role"] == '0'){
  header("Location: {$hostname}/admin/post.php");
}
$userid = $_GET['id'];

if($obj->delete('user',"user_id = {$userid}")){
  header("Location: {$hostname}/admin/users.php");
}else{
  echo "<p style='color:red;margin: 10px 0;'>Can\'t Delete the User Record.</p>";
}

mysqli_close($conn);

?>
