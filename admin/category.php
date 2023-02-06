<?php include "header.php"; ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
              <?php
                 /* Calculate Offset Code */
                 $limit= 3;
                  if(isset($_GET["page"])){
                      $page = $_GET["page"];
                  }
                  else{
                      $page = 1;
                  };
                  $offset = ($page-1)* $limit;
              /* select query with offset and limit */

              $col_name = "*";
              $order= "category_id DESC";
 
 
              $obj->select('category',$col_name,null,null,$order,$limit);
            //   $sql = "SELECT * FROM  category ORDER BY category_id DESC Limit $offset,$limit";
              $result = $obj->get_result();
              if (COUNT($result) > 0) {
                  $table = '<table class="content-table">';
                  $table .= '<thead>
                                  <th>S.No.</th>
                                  <th>Category Name</th>
                                  <th>No. of Posts</th>
                                  <th>Edit</th>
                                  <th>Delete</th>
                              </thead>
                              <tbody>';
                    $serial = $offset + 1;
                  foreach($result as $row) {
                    $table .= "<tr>
                            <td class='id'>{$serial}</td>
                            <td>{$row["category_name"]}</td>
                            <td>{$row["post"]}</td>
                            <td class='edit'><a href='update-category.php?id={$row['category_id']}' ><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id={$row['category_id']}'><i class='fa fa-trash-o'></i></a></td>
                        </tr>";
                        $serial++;
                  }
                  $table .= '</tbody></table>';
                  // show table
                  echo $table;
              } else {
                  echo "<h3>No Results Found.</h3>";
              }
                            // show pagination
              $obj->pagination('category',null,null,$limit);

              ?>
            </div>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>
