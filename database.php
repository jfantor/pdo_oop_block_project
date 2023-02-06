<?php

$hostname = "http://localhost/product%20list/blog_project_pdo/";

class DataBase{
    private $db_host = "localhost";
    private $db_name = "news-site";
    private $db_user = "root";
    private $db_pass = "";

    private $mysql = "";
    private $result = array();
    private $image_name=array();
    private $conn = false;

// pdo connection function ---------------------------------
    public function __construct(){
        if(!$this->conn){
            $this->mysql = new pdo("mysql:host=$this->db_host;dbname=$this->db_name","$this->db_user","$this->db_pass");
            // var_dump($this->mysql);

            $this->conn = true;
            if($this->mysql->errorInfo()){
                array_push($this->result,$this->mysql->errorInfo());
                return false;
            }

        }else{
            return true;
        }
    }

    // function for chak existing table in data base

    private function table_ex($table){

        $tableInDb = $this->mysql->prepare("SHOW TABLES LIKE '$table' ");
        $tableInDb->execute();

        $count=$tableInDb->rowCount();
        

        if($tableInDb){
            if($tableInDb){
                if($count == 1){
                    // echo "tablae exist";
                    return true;
                }else{
                    return false;
                    array_push($this->result,$table . "dose not exist in this data base .");
                    echo "<pre>";
                    echo($this->result);
                    echo "</pre>";
                   
                    
                }
            }
        }

    }


    // function for insert data into data base ------------

    public function insert($table,$params=array()){

        if($this->table_ex($table)){
            // echo "<pre>";
            // print_r($params);
            // echo "</pre>";

            $table_colum = implode(",",array_keys($params));
            $table_valu = implode("','",$params);

            // echo $table_colum ."<br>";
            // echo $table_valu;

            $ins = $this->mysql->prepare("INSERT INTO $table ($table_colum) VALUES ('$table_valu')");

            if($ins->execute()){
                
                echo "insert success";
                return true;
            }else{
                array_push($this->result,$this->mysql->errorInfo());
                return false;
            }
        }

    }


    // function for update data from data base 

    public function update($table,$params = array(),$where = null){

        if($this->table_ex($table)){
            $args = array();

            foreach($params as $key => $value){
                $args[] = "$key = '$value'";
            }
            $sql = "UPDATE $table SET " . implode(', ' , $args) ;
            // var_dump($args_im) or die();
            if($where != null){
                $sql .= " WHERE $where";
            }
            $sql = $this->mysql->prepare($sql);
            
            // echo "<pre>";
            // print_r ($sql);
            // echo "</pre>";
            
            


            
            if($sql->execute()){
                echo " update success";
            array_push($this->result ,$sql->rowCount());
            return true;
            }else{
            array_push($this->result , $sql->errorInfo());
            }
                
        }else{
            return false;
        }
    }

    // function for delete table or row from database   ===

    public function delete($table,$where = null){

        if($this->table_ex($table)){

            $query = "DELETE FROM $table " ;

            if($where != null){
                $query .= " WHERE $where";
            }
        
            $sql = $this->mysql->prepare("$query");

            if($sql->execute()){
                echo "delete susseccfull";
                array_push($this->result, $sql->rowCount());
                return true;
            }else{
                echo "delete unsuccessfull";
                array_push($this->result,$sql->errorInfo());
                return false;
            }
            
            
        }else{
            return false;
        }
    }

    // function for select from data base --------------------

    public function select($table , $row="*" , $join = null , $where = null , $order = null , $limit = null){
        if($this->table_ex($table)){
            $query = "SELECT $row FROM $table";
            if($join != null){
                $query .= " JOIN $join";
            }
            if($where != null){
                $query .= " WHERE $where";
            }
            if($order != null){
                $query .= " ORDER BY $order";
            }
            if($limit != null){
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }else{
                    $page = 1;
                }
                $start = ($page - 1)* $limit;
                $query .= " LIMIT $start, $limit";
            }
            // echo $query;
            $sql = $this->mysql->prepare("$query");

            if($sql->execute()){
                $this->result = $sql->fetchall();
                return true;
            }
            else{
                array_push($this->result,$sql->errorInfo());
                return false;
            }

        } else{
        return false;
        }   
    }

    // function for pagination ===================

    public function pagination($table,$join = null,$where = null,$limit,$id = null){
        if($this->table_ex($table)){
            if($limit != null){
                $query = "SELECT COUNT(*) FROM $table";
                if($join != null){
                    $query .= " JOIN $join";
                }
                if($where != null){
                    $query .= " WHERE $where";
                }
                // echo $query;

                $sql = $this->mysql->prepare("$query");
                // print_r ($sql);
                
                $sql->execute();
                $total_record = $sql->fetchAll();
                $total_record= $total_record[0];
                $total_record = $total_record[0];

                // echo $total_record;
                $total_page = ceil($total_record / $limit);

                $url = basename($_SERVER['PHP_SELF']);

                if(isset($_GET["page"])){
                    $page = $_GET['page'];
                }else{
                    $page = 1;
                }

                $output = "<ul class = 'pagination' >";

                if($id !=null){
                    if($page>1){
                        $output .= "<li><a href = '$url? $id&page=".($page-1)."'>Prev</a></li>";
                    }
                    if($total_record > $limit){
                        for( $i=1; $i <= $total_page; $i++){
                            if($i==$page){
                                $class = "class = 'active'";
                            }else{
                                $class = '';
                            }
                            $output .= "<li><a $class href = '$url? $id&page=$i'>$i</a></li>";
                        }
    
                    }
                    if($total_page > $page){
                        $output .= "<li><a href = '$url? $id&page=".($page+1)."'>Next</a></li>";
                    }
                }else{
                    if($page>1){
                        $output .= "<li><a href = '$url?page=".($page-1)."'>Prev</a></li>";
                    }
                    if($total_record > $limit){
                        for( $i=1; $i <= $total_page; $i++){
                            if($i==$page){
                                $class = "class = 'active'";
                            }else{
                                $class = '';
                            }
                            $output .= "<li><a $class href = '$url?page=$i'>$i</a></li>";
                        }
    
                    }
                    if($total_page > $page){
                        $output .= "<li><a href = '$url?page=".($page+1)."'>Next</a></li>";
                    }
                }
                $output .= "</ul>";

                echo $output;


                
               
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    // function for execute sql sentex===========

    public function sql($sql){
        $query = $this->mysql->prepare($sql);

        if($query->execute()){
            $this->result = $query->fetchall();
            return true;

        }else{
            array_push($this->result,$query->errorInfo());
            return false;
        }
    }





    // get result ================

    public function get_result(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }


// function for image uplode -----------------

    public function Img_Up($fileToUpload,$target){
        if(isset($_FILES[$fileToUpload])){
            $errors = array();
        
            $file_name = $_FILES[$fileToUpload]['name'];
            $file_size = $_FILES[$fileToUpload]['size'];
            $file_tmp = $_FILES[$fileToUpload]['tmp_name'];
            $file_type = $_FILES[$fileToUpload]['type'];
            $tmp_ext = explode('.',$file_name);
            $file_ext = end($tmp_ext);
        
        
            $extentions = array("jpeg",'jpg','png');
        
            if(in_array($file_ext,$extentions) ===false){
                $errors[]="This extension file not allowed , please choose jpeg , jpg , png file . ";
            }
            if($file_size > 2097152){
                $errors[]="file size must be 2md or lower .";
        
            }
            $new_name=time()."-".basename($file_name);
            $target = "$target".$new_name;
        
            //echo $target;
        
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,$target);
        
            }else{
                print_r($errors);
                die();
            }
            array_push($this->image_name,$new_name);
        }

    }










    // public function Img_U($fileToUpload=null,$target,$save){
    //     if(isset($_POST[$save])){
    //         if(isset($_FILES[$fileToUpload])){
    //             $errors = array();
            
    //             $file_name = $_FILES[$fileToUpload]['name'];
    //             $file_size = $_FILES[$fileToUpload]['size'];
    //             $file_tmp = $_FILES[$fileToUpload]['tmp_name'];
    //             $file_type = $_FILES[$fileToUpload]['type'];
    //             $tmp_ext = explode('.',$file_name);
    //             $file_ext = end($tmp_ext);


            
            
    //             $extentions = array("jpeg",'jpg','png');
            
    //             if(in_array($file_ext,$extentions) ===false){
    //                 $errors[]="This extension file not allowed , please choose jpeg , jpg , png file . ";
    //             }
    //             if($file_size > 2097152){
    //                 $errors[]="file size must be 2md or lower .";
            
    //             }
    //             $new_name=time()."-".basename($file_name);
    //             $target = "$target".$new_name;

    //             // var_dump($errors) or die;
            
    //             //echo $target;
            
    //             if(isset($_POST[$save])){
    //                 if(empty($errors)==true){
    //                     // move_uploaded_file($file_tmp,$target);
    //                     if(move_uploaded_file($file_tmp,$target)){
    //                         array_push($this->image_name,$new_name);
    //                         unset($new_name);
    //                         unset($target);
    //                     }
                
    //                 }else{
    //                     print_r($errors);
    //                     die();
    //                 }
    //             }
                
    //         }
    //     }

    // }

    // // function for gat image name ------------

    public function Img(){
        $val = $this->image_name;
        $this->image_name = array();
        return $val;
    }

    // function for close data base ---------------------------

    public function __destruct(){
        if($this->conn){
            $this->mysql = null;
            if($this->mysql == null){
                $this->conn = false;
                return true;

            }else{
                echo "Connection is not close .";

            }
        }else{
            return false;
        }
    }

}






class Img_Up{
    // class properties --------------
    private $image_name; //the image name
    private $image_type; //the image type
    private $image_size; //this image size
    private $image_temp; //this image temporary location where the uploaded image is stored.
    private $uploade_folder = "./admin/uplode"; // the uploades folder
    private $uploade_max_size = 2*1024*1024;//setting te max upload file size to 2 mb


    //next i need a property to hold an array of allowed image types,

    private $allowed_image_type = ["image/jpeg","image/jpg","image/png","image/gif"];

    //and last i need a property to store any validation error.
    //I am setting the visibillity of the error property to public.
    //bacause i want to have access to this property from th indes file 

    public $error;

    //class methods==========
    //i need the class constructor to initialize my properties
    //the constructor takes as an arument the $_FILES superglobaal variable,
    //when we careating a new object on the html file.

    public function __construct($files){
        $this->image_name = $files['image']['name'];
        $this->image_size = $files['image']['size']; 
        $this->image_temp = $files['image']['tmp_name'];
        $this->image_type = $files['image']['type']; 


        $this->isImage();
        $this->imageNameValidation();
        $this->sizeValidatoin();
        $this->checkFile();


        // here i have to check if the error propertyu has no errors stored,
        //and the i will call the moveFile method.

        if($this->error == null){
            $this->MoveFile();
        }

        if($this->error == null){
            $this->recordImage();
        }



    }

    //next in need a function to do two things.
    //first the method will check if the uploaded file is indeed an image.
    //and second method will validate if the uploaded file type in included
    //in the $allowred_image_type array.


    private function isImage(){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo,$this->image_temp);
    if(!in_array($mime,$this->allowed_image_types)){
        return $this->error = "Only [.jpeg, .jpg, .png, and .gif ] files are allowed";
        }
        finfo_close($finfo);
    }

    //next i need a method to validate the image s name.
    //the method will return the sanitized image name so we are
    //sure that it is  safe to store the name in the database.


    private function imageNameValidation (){
        return $this->image_name = filter_var($this->image_name,FILTER_SANITIZE_STRING);
    }

    //next i need a method to validate the max upload size
    //the method will return an error if the file size exceeds
    // the 2 mb size limit.

    private function sizeValidatoin(){
        if($this->image_size > $this->upload_max_size){
            return $this->error = "File is bigger then 2MB";
        }
    }

    // I need a method to check if the file alteahy exists tn the folder.
    //the mehod will return an error if the file exist.

    private function checkFile(){
        if(file_exists($this->uploads_folder.$this->image_name)){
            return $this->error = "File alrady exists in folder";
        }
    }

    // next i will move the file from the temporay storage to our 
    // uploade folder
    // when we uploadeing a file , php is s r uploads folder.
    
    private function MoveFile(){
        //I an gonna use the move_uploaded_file function to move the file
        //from the temorary locatoin to my uploads folder.
        if(!move_uploaded_file($this->image_temp,$this->uploads_folder.$this->image_name)){
            return $this->error = "There was an error , please try again";
        }
    }
    // and last i need a mathod to store the image name to the data base.


    private function recordImage(){
       $mysqli = new mysqli("localhost","root","","practis-db");

       $mysqli->query("INSERT INTO `img` ( `img_name`) VALUES ('$this->image_name')");


       if($mysqli -> affected_rows != 1){
        if(file_exists($this->uplodes_folder.$this->image_name)){
            unlink($this->uploads_folder.$this->image_name);

        }
        return $this->error = "there was an error , Please try again ";
       }
    }







}
?>