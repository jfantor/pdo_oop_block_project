<div id ="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
              <?php


                $col_name = "*";
                $obj->select('settings',$col_name);

                $result = $obj->get_result();
                if(COUNT($result) > 0){
                  foreach($result as $row) {
              ?>
                <span><?php echo $row['footerdesc']; ?></span>
              <?php
                }
              }
              ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
