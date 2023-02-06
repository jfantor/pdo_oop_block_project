<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <?php
                  include "config.php";
                  if(isset($_GET['cid'])){
                    $cat_id = $_GET['cid'];
                    $col_name = "*";
                    $where = " category_id = {$cat_id}"; 

                    $obj->select('category',$col_name,null,$where);
                    $result1 = $obj->get_result();
                    $row1 = $result1[0];
                  ?>
                  <h2 class="page-heading"><?php echo $row1['category_name']; ?> News</h2>
                  <?php

                    $join ="category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id";
                    $col_name = "post.post_id, post.title, post.description,post.post_date,post.author,category.category_name,user.username,post.category,post.post_img";
                    $limit= 3;
                    $order= "post.post_id  DESC";
                    $where = " post.category = {$cat_id}"; 

                    $obj->select('post',$col_name,$join,$where,$order,$limit);
                    $result = $obj->get_result();
                    if(COUNT($result) > 0){
                      foreach($result as $row) {
                  ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                              <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/uplode/<?php echo $row['post_img']; ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                              <div class="inner-content clearfix">
                                  <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                  <div class="post-information">
                                      <span>
                                          <i class="fa fa-tags" aria-hidden="true"></i>
                                          <a href='category.php?cid=<?php echo $row['category']; ?>'><?php echo $row['category_name']; ?></a>
                                      </span>
                                      <span>
                                          <i class="fa fa-user" aria-hidden="true"></i>
                                          <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                      </span>
                                      <span>
                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                          <?php echo $row['post_date']; ?>
                                      </span>
                                  </div>
                                  <p class="description">
                                      <?php echo substr($row['description'],0,130) . "..."; ?>
                                  </p>
                                  <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                              </div>
                            </div>
                        </div>
                    </div>
                    <?php
                      }
                    }else{
                      echo "<h2>No Record Found.</h2>";
                    }
                    // show pagination
                    $cat_id = "cid=".$cat_id;
                    $obj->pagination('post',$join,$where,$limit,$cat_id);
                  }else{
                    echo "<h2>No Record Found.</h2>";
                  }
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
