<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
                  <?php
                    if( isset($_POST['save']) ){
                        // database configuration;
                        $category = $_POST['cat'];
                        $col_name = "category_name";
                        $where = "category_name='{$category}'";


                        $obj->select('category',$col_name,null,$where);
                        /* query for check input value exists in category table or not*/
                        $result = $obj->get_result();
                        if (COUNT($result)> 0) {
                            // if input value exists
                            echo "<p style = 'color:red;text-align:center;margin: 10px 0';> Category already exists.</p>";
                        }else{
                            // if input value not exists
                            /* query for insert record in category name */
                            $cat_name = $_POST["cat"];
                            $value = ["category_name"=>$cat_name];
                            if ($obj->insert('category',$value)){
                                header("location: {$hostname}/admin/category.php");
                            }else{
                            echo "<p style = 'color:red;text-align:center;margin: 10px 0';>Query Failed.</p>";
                            }
                        }
                    }
                ?>
              </div>
          </div>
      </div>
  </div>
  
<?php
    include "../footer.php";
  ?>
