<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                <?php

                $col_name = " post.post_id, post.title, post.description,post.post_date,category.category_name,user.username,post.category";
                $limit= 3;
                $join ="category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id";
                $where = null;
                $order= "post.post_id DESC";
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                  }else{
                    $page = 1;
                  }
                  $offset = ($page - 1) * $limit;

                  if($_SESSION["user_role"] == '1'){
                    $obj->select('post',$col_name,$join,$where,$order,$limit);
                  }elseif($_SESSION["user_role"] == '0'){
                    $where1 = "post.author = {$_SESSION['user_id']}";
                    $obj->select('post',$col_name,$join,$where1,$order,$limit);
                  }

                  $result = $obj->get_result();
                  if(COUNT($result) > 0){
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                        $serial = $offset + 1;
                        foreach($result as $row) {?>
                          <tr>
                              <td class='id'><?php echo $serial; ?></td>
                              <td><?php echo $row['title']; ?></td>
                              <td><?php echo $row['category_name']; ?></td>
                              <td><?php echo $row['post_date']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td class='edit'><a href='update_post.php?id=<?php echo $row['post_id']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id']; ?>&catid=<?php echo $row['category']; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php
                          $serial++;
                        } ?>
                      </tbody>
                  </table>
                  <?php
                }else {
                  echo "<h3>No Results Found.</h3>";
                }
                // show pagination
                if($_SESSION["user_role"] == '1'){
                  /* select query of post table for admin user */
                  $obj->select('post',"*");
                  $obj->pagination('post',$join,null,$limit);
                }elseif($_SESSION["user_role"] == '0'){
                  /* select query of post table for normal user */
                  $where2 = " author = {$_SESSION['user_id']}";
                  $obj->select('post',"*",null,$where2);
                  $result2 = $obj->get_result();
                  if(COUNT($result2) > 3){
                    $obj->pagination('user',null,$where2,$limit);
                  }
                  
                }
                
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "../footer.php"; ?>
