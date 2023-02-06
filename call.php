<?php

include "dataBase.php";
$obj = new DataBase; 

// $obj->update('user',['first_name'=>'jf8','last_name'=>'antor3',
// 'username'=>'jfantor3','password'=>'12345','role'=>'1'] ,"user_id = 83");
// echo "Insert result is : ";
// echo "<pre>";
// print_r($obj->get_result());
// echo "</pre>";
// $obj->delete('user',"user_id='72'");
// $obj->delete('user',"user_id = 84");
$join =" post ON user.user_id=post.author";
$col_name = "*";
$limit= 3;
$where = null;
$order= null;


// $obj->select('user',$col_name,$join,$where,$order,$limit);
// echo "delete result is : ";
// echo "<pre>";
// print_r($obj->get_result());
// echo "</pre>";
// $obj->pagination('user',$join,$where,$limit);


?>













<?php
// if(isset($_POST['upload-image'])){
//     if($_FILES['image']['error'] == 0){
//         $image_upload = new Img_Up($_FILES);
//     }
// }


?>


<!DOCTYPE html>
<html>
<body>

<form action="admin/save_post.php" method="POST" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload" required>
  <input type="submit" name='save'>
  <!-- <button type="submit" name="save">upload image</button> -->
</form>

</body>
</html>

<?php



?>




