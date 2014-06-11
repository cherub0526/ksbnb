<?php require_once('../Connections/ksnews3.php'); ?>
<?php

if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",3000000);
define("DESTINATION_FOLDER", "../images/landscape/");
define("no_error", "admin_banner.php");
define("yes_error", "admin_banner_1_3Add.php");
$_accepted_extensions_ = "jpg,gif,png";
if(strlen($_accepted_extensions_) > 0){
	$_accepted_extensions_ = @explode(",",$_accepted_extensions_);
} else {
	$_accepted_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['l_images'])){ //如果你的上傳檔案欄位不是取banner_pic，請將你的欄位名稱取代所有banner_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['l_images']['tmp_name']) && $HTTP_POST_FILES['l_images']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['l_images'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_SIZE && MAX_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$_ext_ = strtolower($_ext_[count($_ext_)-1]);
		if(!in_array($_ext_, $_accepted_extensions_) && count($_accepted_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_FOLDER) && is_writeable(DESTINATION_FOLDER)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			if(@copy($_tmp_name_,DESTINATION_FOLDER . "/" . date("YmdHis02.").$_ext_)){ //修改自動重新命名
				$newPicname=date("YmdHis02.").$_ext_;//變數$newname取得新檔案名，供寫入資料庫
			//	header("Location: " . no_error);
			} else {
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>history.back()</script>";//回上一頁
		    exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
	}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO bnb_landscape (l_title, l_area, l_zip, l_text, l_url, l_images, l_date) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['l_title'], "text"),
                       GetSQLValueString($_POST['l_area'], "text"),
                       GetSQLValueString($_POST['l_zip'], "int"),
                       GetSQLValueString($_POST['l_text'], "text"),
                       GetSQLValueString($_POST['l_url'], "text"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['l_date'], "date"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL, $ksnews3) or die(mysql_error());

  $insertGoTo = "bnb_landscape_detail.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
/*
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecZip = "SELECT * FROM zipcode WHERE City = '花蓮縣' ORDER BY Id ASC";
$RecZip = mysql_query($query_RecZip, $ksnews3) or die(mysql_error());
$row_RecZip = mysql_fetch_assoc($RecZip);
$totalRows_RecZip = mysql_num_rows($RecZip);
*/
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecCity = "SELECT * FROM level1 ORDER BY level_id ASC";
$RecCity = mysql_query($query_RecCity, $ksnews3) or die(mysql_error());
$row_RecCity = mysql_fetch_assoc($RecCity);
$totalRows_RecCity = mysql_num_rows($RecCity);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>旅遊景點 新增 </title>
<style type="text/css">
#content {
	float: left;
	width: 835px;
}
</style>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
            $(document).ready(function(){
                //利用jQuery的ajax把縣市編號(CNo)傳到Town_ajax.php把相對應的區域名稱回傳後印到選擇區域(鄉鎮)下拉選單
                $('#l_area').change(function(){
                    var CNo= $('#l_area').val();
                    $.ajax({
                        type: "POST",
                        url: 'Town_ajax.php',
                        cache: false,
                        data:'city='+CNo,
                        error: function(){
                            alert('Ajax request 發生錯誤');
                        },
                        success: function(data){
                            $('#l_zip').html(data);
                        }
                    });
                });
            });
        </script>
</head>

<body onload="createCKeditor('l_text','Full','office2003')" >
<div id="body">
<div id="content" class="cx_admin_table" style="height:500px">
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="23" background="../images/board10.gif">&nbsp;</td>
      <td width="144" background="../images/board04.gif" align="left" style="font-size:0.8em">旅遊景點 新增 </td>
      <td width="650" background="../images/board04.gif">&nbsp;</td>
      <td width="10" background="../images/board05.gif">&nbsp;</td>
    </tr>
  </table>
</div>
  <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
    <table width="835" border="0" cellpadding="0">
     <tr>
        <td colspan="2">
        </td>
      </tr>
      <tr>
        <td width="145">景點名稱：</td>
        <td width="684"><label for="l_url"></label>
        <input type="text" name="l_title" id="l_title" /></td>
      </tr>
      <tr>
        <td>鄉鎮：</td>
        <td><label for="l_zone"></label>
          <label for="l_zip"></label>
          <label for="l_area2"></label>
          <select name="l_area" id="l_area">
 <option value="">請選擇縣市</option>
            <?php
do {  
if($row_RecCity['name']!=""){
?>
            <option value="<?php echo $row_RecCity['level_id']?>"><?php echo $row_RecCity['name']?></option>
            <?php
}} while ($row_RecCity = mysql_fetch_assoc($RecCity));
  $rows = mysql_num_rows($RecCity);
  if($rows > 0) {
      mysql_data_seek($RecCity, 0);
	  $row_RecCity = mysql_fetch_assoc($RecCity);
  }
?>
          </select>
          <select name="l_zip" id="l_zip"></select>
        <input name="l_date" type="hidden" id="l_date" value="<?php echo date("Y-m-d H:i:s"); ?>" /></td>
      </tr>
      <tr>
        <td width="145">景點網址：</td>
        <td width="684"><label for="l_url"></label>
        <input type="text" name="l_url" id="l_url" /></td>
      </tr>
      <tr>
        <td>景點內文：</td>
        <td><label for="l_text"></label>
        <textarea name="l_text" cols="50" rows="10" id="l_text"></textarea>
        </td>
      </tr>
      <tr>
        <td height="25">上傳圖片：</td>
        <td><p>*圖片限定jpg,png格式，小於3MB的檔案(圖片長寬為455*300px)<br />
          <input name="l_images" type="file" id="l_images" value="上傳檔案" size="50" />
        </p></td>
      </tr>
    </table>
    <p align="center"><input type="submit" value="送出" /> <input type="reset" value="重新填寫"  /> <input type="button" value="回上一頁" onclick="window.history.back()" /></p>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
</div>
</div>
<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("l_text");
?>
</body>
</html>
<?php
//mysql_free_result($RecZip);

mysql_free_result($RecCity);
?>
