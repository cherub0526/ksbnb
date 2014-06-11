<?php
require('../Connections/ksnews3.php');
$uploads_dir = 'mydir';//存放上傳檔案資料夾
foreach ($_FILES["ff"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["ff"]["tmp_name"][$key];
        $name = $_FILES["ff"]["name"][$key];
        move_uploaded_file($tmp_name, "$uploads_dir/$name");
		mysql_select_db($database_ksnews3,$ksnews3);
		$query = sprintf("INSERT INTO product_pic (product_pic) VALUES ($name)");
		mysql_query($query,$ksnews3);
    }
}
?>