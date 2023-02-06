<?php
  //echo "<h1>" .  . "</h1>";
  include "database.php";
  $obj = new DataBase; 
  $page = basename($_SERVER['PHP_SELF']);
  switch($page){
    case "single.php":
      if(isset($_GET['id'])){
        $join =null;
        $col_name = "*";
        $limit= null;
        $order= null;
        $where = " post_id = {$_GET['id']}"; 

        $obj->select('post',$col_name,$join,$where);
        $result_title = $obj->get_result();
        $result_row = $result_title[0];
        $page_title = $result_row['title'];
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "category.php":
      if(isset($_GET['cid'])){
        $join =null;
        $col_name = "*";
        $limit= null;
        $order= null;
        $where = " category_id = {$_GET['cid']}"; 

        $obj->select('category',$col_name,$join,$where);
        $result_title = $obj->get_result();
        $result_row = $result_title[0];

        $page_title = $result_row['category_name'] . " News";
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "author.php":
      if(isset($_GET['aid'])){
        $join =null;
        $col_name = "*";
        $limit= null;
        $order= null;
        $where = " user_id = {$_GET['aid']}"; 

        $obj->select('user',$col_name,$join,$where);
        $result_title = $obj->get_result();
        $result_title = $result_title[0];
        $page_title = "News By " .$result_title['first_name'] . " " . $result_title['last_name'];
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "search.php":
      if(isset($_GET['search'])){

        $page_title = $_GET['search'];
      }else{
        $page_title = "No Search Result Found";
      }
      break;
    default :
    $join =null;
    $col_name = "websitename";
    $limit= null;
    $order= null;
    $where = null; 
    $obj->select('settings',$col_name,$join,$where);

    $result_title = $obj->get_result();

    $result_row = $result_title[0];

    // print_r ($result_row );
    $page_title = $result_row['websitename'];
    break;
  }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
              <?php
                
                
                
                
                $col_name = "*";
                $obj->select('settings',$col_name);

               
                  foreach($obj->get_result() as $row) {
                    if($row['logo'] == ""){
                      echo '<a href="index.php"><h1>'.$row['websitename'].'</h1></a>';
                    }else{
                      echo '<a href="index.php" id="logo"><img src="admin/uplode/'. $row['logo'] .'"></a>';
                    }

                  }
                
                ?>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
              <?php

                if(isset($_GET['cid'])){
                  $cat_id = $_GET['cid'];
                }
               

                $join =null;
                $col_name = "*";
                $limit= null;
                $order= null;
                $where = ' post > 0';

                
                $obj->select('category',$col_name,$join,$where);
                if(COUNT($obj->get_result()) > 0){
                  $active = "";
                  
              ?>
                <ul class='menu'>
                  <li><a href='<?php echo $hostname; ?>'>Home</a></li>
                  <?php 
                  $obj->select('category',$col_name,$join,$where);
                  foreach($obj->get_result() as $row) {
                    
                    if(isset($_GET['cid'])){
                      if($row['category_id'] == $cat_id){
                        $active = "active";
                      }else{
                        $active = "";
                      }
                    }
                    echo "<li><a class='{$active}' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                  } ?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</div>