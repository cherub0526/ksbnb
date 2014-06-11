<?php require_once('../Connections/connSQL.php'); ?>
<?php
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",3000000);
define("DESTINATION_FOLDER", "../images/economy/");
define("no_error", "admin_banner.php");
define("yes_error", "admin_banner_1_3Add.php");
$_accepted_extensions_ = "jpg,gif,png";
if(strlen($_accepted_extensions_) > 0){
	$_accepted_extensions_ = @explode(",",$_accepted_extensions_);
} else {
	$_accepted_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['b_images'])){ //如果你的上傳檔案欄位不是取banner_pic，請將你的欄位名稱取代所有banner_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['b_images']['tmp_name']) && $HTTP_POST_FILES['b_images']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['b_images'];
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
  $insertSQL = sprintf("INSERT INTO bnb_economy (b_name, b_area, b_zip, b_tel1, b_tel2, b_url, b_manager, b_email, b_address, b_economy, b_images) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['b_name'], "text"),
					   GetSQLValueString($_POST['b_area'], "text"),
                       GetSQLValueString($_POST['b_zip'], "int"),
                       GetSQLValueString($_POST['b_tel1'], "int"),
                       GetSQLValueString($_POST['b_tel2'], "int"),
                       GetSQLValueString($_POST['b_url'], "text"),
                       GetSQLValueString($_POST['b_manager'], "text"),
                       GetSQLValueString($_POST['b_email'], "text"),
                       GetSQLValueString($_POST['b_address'], "text"),
                       GetSQLValueString($_POST['b_economy'], "text"),
                       GetSQLValueString($newPicname, "text"));

  echo $insertSQL;
  mysql_select_db($database_connSQL, $connSQL);
  $Result1 = mysql_query($insertSQL, $connSQL) or die(mysql_error());

  $insertGoTo = "bnbeconomy.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connSQL, $connSQL);
$query_RecZip = "SELECT * FROM zipcode WHERE City = '花蓮縣' ORDER BY Id ASC";
$RecZip = mysql_query($query_RecZip, $connSQL) or die(mysql_error());
$row_RecZip = mysql_fetch_assoc($RecZip);
$totalRows_RecZip = mysql_num_rows($RecZip);

mysql_select_db($database_connSQL, $connSQL);
$query_RecCity = "SELECT * FROM city ORDER BY c_id ASC";
$RecCity = mysql_query($query_RecCity, $connSQL) or die(mysql_error());
$row_RecCity = mysql_fetch_assoc($RecCity);
$totalRows_RecCity = mysql_num_rows($RecCity);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>超值套裝優惠</title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
function reSize(){
　　parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
<script type="text/javascript">
$(document).ready(function(){
                //利用jQuery的ajax把縣市編號(CNo)傳到Town_ajax.php把相對應的區域名稱回傳後印到選擇區域(鄉鎮)下拉選單
                $('#b_area').change(function(){
                    var CNo= $('#b_area').val();
                    $.ajax({
                        type: "POST",
                        url: 'Town_ajax.php',
                        cache: false,
                        data:'city='+CNo,
                        error: function(){
                            alert('Ajax request 發生錯誤');
                        },
                        success: function(data){
                            $('#b_zip').html(data);
                        }
                    });
                });
        });
</script>
</head>

<body>
<div id="content" class="cx_admin_table">
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="23" background="../images/board10.gif">&nbsp;</td>
      <td width="144" background="../images/board04.gif" align="left" style="font-size:0.8em">超值套裝優惠 新增 </td>
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
        <td width="684"><label for="b_name"></label>
        <input type="text" name="b_name" id="b_name" /></td>
      </tr>
      <tr>
        <td>鄉鎮：</td>
        <td><label for="b_zone"></label>
          <label for="b_zip"></label>
          <label for="b_area2"></label>
          <select name="b_area" id="b_area">
            <option value="">請選擇縣市</option>
            <?php
do {  
?>
            <option value="<?php echo $row_RecCity['c_name']?>"><?php echo $row_RecCity['c_name']?></option>
            <?php
} while ($row_RecCity = mysql_fetch_assoc($RecCity));
  $rows = mysql_num_rows($RecCity);
  if($rows > 0) {
      mysql_data_seek($RecCity, 0);
	  $row_RecCity = mysql_fetch_assoc($RecCity);
  }
?>
          </select>
          <select name="b_zip" id="b_zip">            
            <option value=""></option>            
        </select></td>
      </tr>
      <tr>
        <td>電話：</td>
        <td><label for="b_tel1"></label>
        <input type="text" name="b_tel1" id="b_tel1" /></td>
      </tr>
      <tr>
        <td>手機：</td>
        <td><label for="b_tel2"></label>
        <input type="text" name="b_tel2" id="b_tel2" /></td>
      </tr>
      <tr>
        <td>網址：</td>
        <td><label for="b_url"></label>
        <input type="text" name="b_url" id="b_url" /></td>
      </tr>
      
      <tr>
        <td>經營者姓名：</td>
        <td><label for="b_manager"></label>
        <input type="text" name="b_manager" id="b_manager" /></td>
      </tr>
      <tr>
        <td>E-mail :</td>
        <td><label for="b_email"></label>
        <input type="text" name="b_email" id="b_email" /></td>
      </tr>
      <tr>
        <td>民宿地址：</td>
        <td><label for="b_address"></label>
        <input type="text" name="b_address" id="b_address" /></td>
      </tr>
      <tr>
        <td>優惠簡介：</td>
        <td><label for="b_economy"></label>
        <textarea name="b_economy" cols="50" rows="5" id="b_economy"></textarea></td>
      </tr>
      <tr>
        <td height="25">上傳圖片：</td>
        <td><p>*圖片限定jpg,png格式，小於3MB的檔案(圖片長寬為455*300px)<br />
          <input name="b_images" type="file" id="b_images" value="上傳檔案" size="50" />
        </p></td>
      </tr>
    </table>
    <p align="center"><input type="submit" value="送出" /> <input type="reset" value="重新填寫"  /> <input type="button" value="回上一頁" onclick="window.history.back()" /></p>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
</div>
<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("b_economy");

?>
</body>
</html>
<?php
mysql_free_result($RecZip);

mysql_free_result($RecCity);
?>
