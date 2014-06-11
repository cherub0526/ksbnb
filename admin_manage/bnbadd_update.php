<?php require_once('../Connections/ksnews3.php'); ?>
<?php
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",3000000);
define("DESTINATION_FOLDER", "../images/bnb/");
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


mysql_select_db($database_ksnews3, $ksnews3);
$query_RecZip = "SELECT * FROM level2 ORDER BY level2_id ASC";
$RecZip = mysql_query($query_RecZip, $ksnews3) or die(mysql_error());
$row_RecZip = mysql_fetch_assoc($RecZip);
$totalRows_RecZip = mysql_num_rows($RecZip);

$colname_RecBnb = "-1";
if (isset($_GET['id'])) {
  $colname_RecBnb = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecBnb = sprintf("SELECT * FROM product WHERE n_id = %s", GetSQLValueString($colname_RecBnb, "int"));
$RecBnb = mysql_query($query_RecBnb, $ksnews3) or die(mysql_error());
$row_RecBnb = mysql_fetch_assoc($RecBnb);
$totalRows_RecBnb = mysql_num_rows($RecBnb);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if($_POST['level1_id']!="" && $_POST['level2_id']!=""){
		if(isset($newPicname))
		{
			unlink("../images/bnb/".$row_RecBnb['b_images']);
	  $updateSQL = sprintf("UPDATE product SET n_name=%s, v_id = %s, level1_id=%s, level2_id=%s, Description=%s, place=%s, r_date=%s, post_time=%s, address=%s, big_pic=%s, hot=%s, n_detail=%s WHERE n_id=%s",
						   GetSQLValueString($_POST['n_name'], "text"),
						   GetSQLValueString($_POST['v_id'], "int"),
						   GetSQLValueString($_POST['level1_id'], "int"),
						   GetSQLValueString($_POST['level2_id'], "int"),
						   GetSQLValueString($_POST['Description'], "text"),
						   GetSQLValueString($_POST['place'], "text"),
						   GetSQLValueString($_POST['r_date'], "date"),
						   GetSQLValueString($_POST['post_time'], "date"),
						   GetSQLValueString($_POST['address'], "text"),
						   GetSQLValueString($newPicname, "text"),
						   GetSQLValueString($_POST['b_economy'], "int"),
						   GetSQLValueString($_POST['n_detail'], "text"),
						   GetSQLValueString($_POST['n_id'], "int"));
	
		}
		else
		{
	  $updateSQL = sprintf("UPDATE product SET n_name=%s, v_id=%s, level1_id=%s, level2_id=%s, Description=%s, place=%s, r_date=%s, post_time=%s, address=%s, hot=%s, n_detail=%s WHERE n_id=%s",
						   GetSQLValueString($_POST['n_name'], "text"),
						   GetSQLValueString($_POST['v_id'], "int"),
						   GetSQLValueString($_POST['level1_id'], "int"),
						   GetSQLValueString($_POST['level2_id'], "int"),
						   GetSQLValueString($_POST['Description'], "text"),
						   GetSQLValueString($_POST['place'], "text"),
						   GetSQLValueString($_POST['r_date'], "date"),
						   GetSQLValueString($_POST['post_time'], "date"),
						   GetSQLValueString($_POST['address'], "text"),
						   GetSQLValueString($_POST['b_economy'], "int"),
						   GetSQLValueString($_POST['n_detail'], "text"),
						   GetSQLValueString($_POST['n_id'], "int"));
		}
	}
	else
	{
		if(isset($newPicname))
	{
		unlink("../images/bnb/".$row_RecBnb['b_images']);
  $updateSQL = sprintf("UPDATE product SET n_name=%s, v_id = %s, Description=%s, place=%s, r_date=%s, post_time=%s, address=%s, big_pic=%s, hot=%s, n_detail=%s WHERE n_id=%s",
                       GetSQLValueString($_POST['n_name'], "text"),
					   GetSQLValueString($_POST['v_id'], "int"),
                       GetSQLValueString($_POST['Description'], "text"),
                       GetSQLValueString($_POST['place'], "text"),
                       GetSQLValueString($_POST['r_date'], "date"),
                       GetSQLValueString($_POST['post_time'], "date"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($newPicname, "text"),
					   GetSQLValueString($_POST['b_economy'], "int"),
					   GetSQLValueString($_POST['n_detail'], "text"),
                       GetSQLValueString($_POST['n_id'], "int"));

	}
	else
	{
  $updateSQL = sprintf("UPDATE product SET n_name=%s, v_id=%s, Description=%s, place=%s, r_date=%s, post_time=%s, address=%s, hot=%s, n_detail=%s WHERE n_id=%s",
                       GetSQLValueString($_POST['n_name'], "text"),
					   GetSQLValueString($_POST['v_id'], "int"),
                       GetSQLValueString($_POST['Description'], "text"),
                       GetSQLValueString($_POST['place'], "text"),
                       GetSQLValueString($_POST['r_date'], "date"),
                       GetSQLValueString($_POST['post_time'], "date"),
                       GetSQLValueString($_POST['address'], "text"),
					   GetSQLValueString($_POST['b_economy'], "int"),
					   GetSQLValueString($_POST['n_detail'], "text"),
                       GetSQLValueString($_POST['n_id'], "int"));
	}
	}
  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($updateSQL, $ksnews3) or die(mysql_error());

  $updateGoTo = "bnbstore_detail.php";
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecLevel = "SELECT * FROM level1 ORDER BY level_id ASC";
$RecLevel = mysql_query($query_RecLevel, $ksnews3) or die(mysql_error());
$row_RecLevel = mysql_fetch_assoc($RecLevel);
$totalRows_RecLevel = mysql_num_rows($RecLevel);

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
<title>民宿資料新增</title>
<style type="text/css">
#content {
	float: left;
	width: 835px;
}
</style>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
  if(　parent.document.getElementById("frm").height < 500){
	  　parent.document.getElementById("frm").height = 700;
  }
  else{
　	   parent.document.getElementById("frm").height=document.body.scrollHeight;
  }
} 
window.onload=reSize;
</script>
<link href="../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
            $(document).ready(function(){
                //利用jQuery的ajax把縣市編號(CNo)傳到Town_ajax.php把相對應的區域名稱回傳後印到選擇區域(鄉鎮)下拉選單
                $('#level1_id').change(function(){
                    var CNo= $('#level1_id').val();
                    $.ajax({
                        type: "POST",
                        url: 'Town_ajax.php',
                        cache: false,
                        data:'city='+CNo,
                        error: function(){
                            alert('Ajax request 發生錯誤');
                        },
                        success: function(data){
                            $('#level2_id').html(data);
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
      <td width="144" background="../images/board04.gif" align="left" style="font-size:0.8em">民宿 更新 </td>
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
        <td width="145">中文名稱：</td>
        <td width="684"><label for="n_name"></label>
        <input name="n_name" type="text" id="n_name" value="<?php echo $row_RecBnb['n_name']; ?>" />
        <input name="n_id" type="hidden" id="n_id" value="<?php echo $row_RecBnb['n_id']; ?>" />
        <input name="r_date" type="hidden" id="r_date" value="<?php echo $row_RecBnb['r_date']; ?>" />
        <input name="post_time" type="hidden" id="post_time" value="<?php echo $row_RecBnb['post_time']; ?>" /></td>
      </tr>
      <tr>
        <td>精選民宿：</td>
        <td><label for="b_tel1"></label>
          <span id="spryradio1">
          <label>
            <input <?php if (!(strcmp($row_RecBnb['v_id'],"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="v_id" value="0" id="v_id_0" />
            不是</label>
          <label>
            <input <?php if (!(strcmp($row_RecBnb['v_id'],"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="v_id" value="1" id="v_id_1" />
            是</label>
          <br />
        <span class="radioRequiredMsg">請進行選取。</span></span></td>
      </tr>
      <tr>
        <td width="145">超值民宿：</td>
        <td width="684"><span id="spryradio2">
          <label>
            <input <?php if (!(strcmp($row_RecBnb['hot'],"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="b_economy" value="0" id="b_economy_0" />
            不是</label>
          <label>
            <input <?php if (!(strcmp($row_RecBnb['hot'],"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="b_economy" value="1" id="b_economy_1" />
            是</label>
          <br />
        <span class="radioRequiredMsg">請進行選取。</span></span></td>
      </tr>
      <tr>
        <td>原本鄉鎮：</td>
        <td><label for="b_zone"></label>
          <label for="level2_id1"></label>
          <label for="level1_id2"></label>
          <select name="level1_id1" id="level1_id1" disabled="disabled">
            <option value="" <?php if (!(strcmp("", $row_RecBnb['level1_id']))) {echo "selected=\"selected\"";} ?>>請選擇地區</option>
            <?php
do {  if($row_RecLevel['name']!=""){
?>
            <option value="<?php echo $row_RecLevel['level_id']?>"<?php if (!(strcmp((int)$row_RecLevel['level_id'], $row_RecBnb['level1_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecLevel['name']?></option>
            <?php
}} while ($row_RecLevel = mysql_fetch_assoc($RecLevel));
  $rows = mysql_num_rows($RecLevel);
  if($rows > 0) {
      mysql_data_seek($RecLevel, 0);
	  $row_RecLevel = mysql_fetch_assoc($RecLevel);
  }
?>
          </select>
          <select name="level2_id1" id="level2_id1" disabled="disabled">          
            <?php
do {  
?>
            <option value="<?php echo $row_RecZip['level2_id']?>"<?php if (!(strcmp((int)$row_RecZip['level2_id'], $row_RecBnb['level2_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecZip['name']?></option>
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
        <td>鄉鎮：</td>
        <td><label for="b_zone"></label>
          <label for="level2_id1"></label>
          <label for="level1_id2"></label>
          <select name="level1_id" id="level1_id">
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
          <select name="level2_id" id="level2_id">  

        </select></td>
      </tr>
      <tr>
        <td>網址：</td>
        <td><label for="Description"></label>
        <input name="Description" type="text" id="Description" value="<?php echo $row_RecBnb['Description']; ?>" size="70" /></td>
      </tr>
      
      <tr>
        <td>經營者姓名：</td>
        <td><label for="place"></label>
        <input name="place" type="text" id="place" value="<?php echo $row_RecBnb['place']; ?>" size="70" /></td>
      </tr>
      <tr>
        <td>民宿地址：</td>
        <td><label for="address"></label>
        <input name="address" type="text" id="address" value="<?php echo $row_RecBnb['address']; ?>" size="70" /></td>
      </tr>
      <tr>
        <td>最低價格：</td>
        <td><label for="price"></label>
        <input name="price" type="text" id="price" value="<?php echo $row_RecBnb['price']; ?>" size="70" /></td>
      </tr>
      <tr>
        <td>內容：</td>
        <td><label for="n_detail"></label>
        <textarea name="n_detail" cols="70" id="n_detail"><?php echo $row_RecBnb['n_detail']; ?></textarea></td>
      </tr>
      <tr>
        <td height="25" colspan="">上傳圖片：</td>
        <td><p><img src="../images/bnb/<?php echo $row_RecBnb['big_pic']; ?>" width="200" /><br />
          *圖片限定jpg,png格式，小於3MB的檔案(圖片長寬為455*300px)<br />
          <input name="b_images" type="file" id="b_images" value="上傳檔案" size="50" />
        </p></td>
        
      </tr>
    </table>
    <p align="center"><input type="submit" value="送出" /> <input type="reset" value="重新填寫"  /> <input type="button" value="回上一頁" onclick="window.history.back()" /></p>
    <input type="hidden" name="MM_update" value="form1" />
  </form>
</div>
<script type="text/javascript">
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1", {validateOn:["blur"]});
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio2", {validateOn:["blur"]});
</script>
<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("n_detail");
?>
</body>
</html>
<?php
//mysql_free_result($RecZip);

mysql_free_result($RecBnb);
?>
