<?php
require("../Connections/ksnews3.php");
$v_id = $_POST['v_id'];
$upload_dir = '../images/ksad/';
mysql_select_db($database_ksnews3,$ksnews3);
if (!isset($_FILES['files'])) {
	
	$file_name = $_FILES['file']['name'];
	$file_size = $_FILES['file']['size'];
	$file_tmp = $_FILES['file']['tmp_name'];
	$file_type = $_FILES['file']['type'];
	$extend = strrchr($file_name, ".");
	$time=time()+(8*60*60);				 //取得格林威治+8時間
	$time=date("Ymd-His",$time);		 //取得目前時間,例如 
	$fname = $time.$extend ;
	
	$z=iconv("UTF-8","big5//TRANSLIT//IGNORE",$_FILES['file']['name']);
	$ap_picurl = $upload_dir.$file_name;
	
	
    $tempFile = iconv("UTF-8","big5//TRANSLIT//IGNORE",$_FILES['file']['tmp_name']);                    
      // using DIRECTORY_SEPARATOR constant is a good practice, it makes your code portable.
    $targetPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $upload_dir . DIRECTORY_SEPARATOR;  
     // Adding timestamp with image's name so that files with same name can be uploaded easily.
    $mainFile =  $targetPath . $fname;  
	
	$query = "INSERT INTO banner_pic (banner_id,banner_pic,banner_title) VALUES ('$v_id','$fname','$fname')";
    
	if(file_exists($upload_dir . $_FILES['file']['name']))
	{
		die("File is exist . Don't upload again!");
	}
	 else if(move_uploaded_file($tempFile,$mainFile))
	{
		echo "Sucess!!";
	}
	else
	{
		mkdir(dirname($upload_dir),0777);
		mkdir($upload_dir,0777);
		move_uploaded_file($tempFile,$mainFile);
    }	
	mysql_query($query);
}
?>