<?php require_once('../Connections/connSQL.php'); ?>
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




mysql_select_db($database_connSQL, $connSQL);
$query_RecZip = "SELECT * FROM zipcode WHERE City = '花蓮縣' ORDER BY Id ASC";
$RecZip = mysql_query($query_RecZip, $connSQL) or die(mysql_error());
$row_RecZip = mysql_fetch_assoc($RecZip);
$totalRows_RecZip = mysql_num_rows($RecZip);

$colname_RecLandscape = "-1";
if (isset($_GET['id'])) {
  $colname_RecLandscape = $_GET['id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecLandscape = sprintf("SELECT * FROM bnb_landscape WHERE l_id = %s", GetSQLValueString($colname_RecLandscape, "int"));
$RecLandscape = mysql_query($query_RecLandscape, $connSQL) or die(mysql_error());
$row_RecLandscape = mysql_fetch_assoc($RecLandscape);
$totalRows_RecLandscape = mysql_num_rows($RecLandscape);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if(isset($newPicname))
	{
		unlink("../images/landscape/".$row_RecLandscape['l_images']);
  $updateSQL = sprintf("UPDATE bnb_landscape SET l_title=%s, l_area=%s, l_zip=%s, l_url=%s, l_text=%s, l_images=%s WHERE l_id=%s",
                       GetSQLValueString($_POST['l_title'], "text"),
                       GetSQLValueString($_POST['l_area'], "int"),
                       GetSQLValueString($_POST['l_zip'], "int"),
                       GetSQLValueString($_POST['l_url'], "text"),
                       GetSQLValueString($_POST['l_text'], "text"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['l_id'], "int"));
	}
	else
	{
		  $updateSQL = sprintf("UPDATE bnb_landscape SET l_title=%s, l_area=%s, l_zip=%s, l_url=%s, l_text=%s WHERE l_id=%s",
                       GetSQLValueString($_POST['l_name'], "text"),
                       GetSQLValueString($_POST['l_area'], "int"),
                       GetSQLValueString($_POST['l_zip'], "int"),
                       GetSQLValueString($_POST['l_url'], "text"),
                       GetSQLValueString($_POST['l_text'], "text"),
                       GetSQLValueString($_POST['l_id'], "int"));
	}

  mysql_select_db($database_connSQL, $connSQL);
  $Result1 = mysql_query($updateSQL, $connSQL) or die(mysql_error());

  $updateGoTo = "bnb_landscape_detail.php";
  header(sprintf("Location: %s", $updateGoTo));
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>旅遊景點 更新 </title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
function createCKeditor(selectElement,selectType,selectSkin){	
	CKEDITOR.replace( selectElement,{
        toolbar : selectType,
		skin : selectSkin
    });
}
</script>
<script id="CKeditor" language="JavaScript" type="text/javascript" src="../CKeditor/ckeditor.js"></script>
</head>

<body onload="createCKeditor('l_text','Basic','office2003')">
<div id="content" class="cx_admin_table">
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="23" background="../images/board10.gif">&nbsp;</td>
      <td width="144" background="../images/board04.gif" align="left" style="font-size:0.8em">旅遊景點 更新 </td>
      <td width="650" background="../images/board04.gif">&nbsp;</td>
      <td width="10" background="../images/board05.gif">&nbsp;</td>
    </tr>
  </table>
</div>
  <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST" enctype="multipart/form-data">
    <table width="835" border="0" cellpadding="0">
     <tr>
        <td colspan="2">
        </td>
      </tr>
      <tr>
        <td width="145">中文名稱：</td>
        <td width="684"><label for="l_name"></label>
        <input name="l_title" type="text" id="l_title" value="<?php echo $row_RecLandscape['l_title']; ?>" />
        <input name="l_id" type="hidden" id="l_id" value="<?php echo $row_RecLandscape['l_id']; ?>" /></td>
      </tr>
      <tr>
        <td>鄉鎮：</td>
        <td><label for="l_zone"></label>
          <label for="l_zip"></label>
          <label for="l_area2"></label>
          <select name="l_area" id="l_area">
            <option value="346">花蓮縣</option>
          </select>
          <select name="l_zip" id="l_zip">
            <?php
do {  
?>
            <option value="<?php echo $row_RecZip['ZipCode']?>"<?php if (!(strcmp($row_RecZip['ZipCode'], $row_RecLandscape['l_zip']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecZip['Area']?></option>
            <?php
} while ($row_RecZip = mysql_fetch_assoc($RecZip));
  $rows = mysql_num_rows($RecZip);
  if($rows > 0) {
      mysql_data_seek($RecZip, 0);
	  $row_RecZip = mysql_fetch_assoc($RecZip);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td>網址：</td>
        <td><label for="l_url"></label>
        <input name="l_url" type="text" id="l_url" value="<?php echo $row_RecLandscape['l_url']; ?>" /></td>
      </tr>
      <tr>
        <td>優惠簡介：</td>
        <td><label for="l_text"></label>
        <textarea name="l_text" cols="50" rows="5" id="l_text"><?php echo $row_RecLandscape['l_text']; ?></textarea></td>
      </tr>
      <tr>
        <td height="25">上傳圖片：</td>
        <td><p><img src="../images/landscape/<?php echo $row_RecLandscape['l_images']; ?>" width="200" /><br />
          *圖片限定jpg,png格式，小於3MB的檔案(圖片長寬為455*300px)<br />
          <input name="l_images" type="file" id="l_images" value="上傳檔案" size="50" />
        </p></td>
      </tr>
    </table>
    <p align="center"><input type="submit" value="送出" /> <input type="reset" value="重新填寫"  /> <input type="button" value="回上一頁" onclick="window.history.back()" /></p>
    <input type="hidden" name="MM_update" value="form1" />
  </form>
</div>
</body>
</html>