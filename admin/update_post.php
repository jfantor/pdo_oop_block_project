<?php include "header.php";

if($_SESSION["user_role"] == 0){
  $post_id = $_GET['id'];
  $obj->select("post","author",null,"post_id = {$post_id}");
  $result = $obj->get_result();

  if($result['author'] != $_SESSION["user_id"]){
    header("location: {$hostname}/admin/post.php");
  }

}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
      <?php

        $post_id = $_GET['id'];

        $join =" category ON post.category = category.category_id
        LEFT JOIN user ON post.author = user.user_id";
        $col_name = "post.post_id, post.title, post.description,post.post_img,
        category.category_name, post.category";
        $limit= null;
        $where = "post.post_id = {$post_id}";
        $order= null;

        $obj->select('post',$col_name,$join,$where,$order,$limit);
        $result = $obj->get_result();
        if(COUNT($result)> 0){
          foreach($result as $row) {
      ?>
        <!-- Form for show edit-->
        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['post_id']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5">
                    <?php echo $row['description']; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                  <option disabled> Select Category</option>
                  <?php
                    $obj->select('category',"*");
                    // $sql1 = "SELECT * FROM category";

                    $result1 = $obj->get_result();

                    if(COUNT($result1)> 0){
                      foreach($result1 as $row1){
                        if($row['category'] == $row1['category_id']){
                          $selected = "selected";
                        }else{
                          $selected = "";
                        }
                        echo "<option {$selected} value='{$row1['category_id']}'>{$row1['category_name']}</option>";
                      }
                    }
                  ?>
                </select>
                <input type="hidden" name="old_category" value="<?php echo $row['category']; ?>">
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img src="uplode/<?php echo $row['post_img'];?>" alt="bloge img" height="150px">
                <input type="hidden" name="old_image" value="<?php echo $row['post_img']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
        <?php
          }
        }else{
          echo "Result Not Found.";
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php include "../footer.php"; ?>
