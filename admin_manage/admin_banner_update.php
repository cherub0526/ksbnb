<?php require_once('../Connections/ksnews3.php'); ?>
<?php


if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",3000000);
define("DESTINATION_FOLDER", "../images/ksad/");
define("no_error", "admin_banner.php");
define("yes_error", "admin_banner_1_3Add.php");
$_accepted_extensions_ = "jpg,gif,png";
if(strlen($_accepted_extensions_) > 0){
	$_accepted_extensions_ = @explode(",",$_accepted_extensions_);
} else {
	$_accepted_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['banner_pic2'])){ //如果你的上傳檔案欄位不是取banner_pic，請將你的欄位名稱取代所有banner_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['banner_pic2']['tmp_name']) && $HTTP_POST_FILES['banner_pic2']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['banner_pic2'];
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
				$newPicname2=date("YmdHis02.").$_ext_;//變數$newname取得新檔案名，供寫入資料庫
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
//	---------------------------------------------
//	Pure PHP Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",3000000);
define("DESTINATION_FOLDER", "../images/ksad/");
define("no_error", "admin_banner.php");
define("yes_error", "admin_banner_1_3Add.php");
$_accepted_extensions_ = "jpg,gif,png";
if(strlen($_accepted_extensions_) > 0){
	$_accepted_extensions_ = @explode(",",$_accepted_extensions_);
} else {
	$_accepted_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['banner_pic'])){ //如果你的上傳檔案欄位不是取banner_pic，請將你的欄位名稱取代所有banner_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['banner_pic']['tmp_name']) && $HTTP_POST_FILES['banner_pic']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['banner_pic'];
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
			if(@copy($_tmp_name_,DESTINATION_FOLDER . "/" . date("YmdHis01.").$_ext_)){ //修改自動重新命名
				$newPicname=date("YmdHis01.").$_ext_;//變數$newname取得新檔案名，供寫入資料庫
			//	header("Location: " . no_error);
			} else {
				echo "<script>history.back()</script>";//回上一頁
			//	exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>history.back()</script>";//回上一頁
		//    exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
	}
}


$end = $_POST['downdate'];
$enddate = date("Y-m-d",strtotime('+'.$end.' day'));

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecPosition = "SELECT * FROM `banner_position`";
$RecPosition = mysql_query($query_RecPosition, $ksnews3) or die(mysql_error());
$row_RecPosition = mysql_fetch_assoc($RecPosition);
$totalRows_RecPosition = mysql_num_rows($RecPosition);

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecZone = "SELECT * FROM `city` ORDER BY id ASC";
$RecZone = mysql_query($query_RecZone, $ksnews3) or die(mysql_error());
$row_RecZone = mysql_fetch_assoc($RecZone);
$totalRows_RecZone = mysql_num_rows($RecZone);


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

$colname_RecUpdate = "-1";
if (isset($_GET['id'])) {
  $colname_RecUpdate = $_GET['id'];
}

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecUpdate = sprintf("SELECT * FROM banner WHERE banner_id = %s", GetSQLValueString($colname_RecUpdate, "int"));
$RecUpdate = mysql_query($query_RecUpdate, $ksnews3) or die(mysql_error());
$row_RecUpdate = mysql_fetch_assoc($RecUpdate);
$totalRows_RecUpdate = mysql_num_rows($RecUpdate);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if(isset($newPicname) && isset($newPicname2)){
  $updateSQL = sprintf("UPDATE banner SET `banner_title`=%s, `commerce`=%s, `uname`=%s, `update`=%s, `startdate`=%s, `downdate`=%s, `banner_url`=%s, `banner_position`=%s, `class`=%s, `level`=%s, `sorting`=%s, `banner_type`=%s, `banner_pic`=%s, `banner_pic2`=%s WHERE banner_id=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['commerce'], "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['update'], "date"),
					   GetSQLValueString($_POST['update'], "date"),
                       GetSQLValueString($_POST['downdate'], "int"),
                       GetSQLValueString($_POST['banner_url'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['zone'], "text"),
					   GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['sorting'], "int"),
                       GetSQLValueString($_POST['banner_type'], "int"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($newPicname2, "text"),
                       GetSQLValueString($_POST['id'], "int"));					   
	}
	else if(isset($newPicname) && !isset($newPicname2)){
		  $updateSQL = sprintf("UPDATE banner SET `banner_title`=%s, `commerce`=%s, `uname`=%s, `update`=%s, `startdate`=%s, `downdate`=%s, `banner_url`=%s, `banner_position`=%s, `class`=%s, `level`=%s, `sorting`=%s, `banner_type`=%s, `banner_pic`=%s WHERE banner_id=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['commerce'], "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['update'], "date"),
					   GetSQLValueString($_POST['update'], "date"),
                       GetSQLValueString($_POST['downdate'], "int"),
                       GetSQLValueString($_POST['banner_url'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['zone'], "text"),
					   GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['sorting'], "int"),
                       GetSQLValueString($_POST['banner_type'], "int"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['id'], "int"));
		@unlink("../images/ksad".$row_RecUpdate['banner_pic']);
	}
	else if(!isset($newPicname) && isset($newPicname2)){
  $updateSQL = sprintf("UPDATE banner SET `banner_title`=%s, `commerce`=%s, `uname`=%s, `update`=%s, `startdate`=%s, `downdate`=%s, `banner_url`=%s, `banner_position`=%s, `class`=%s, `level`=%s, `sorting`=%s, `banner_type`=%s, `banner_pic2`=%s WHERE banner_id=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['commerce'], "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['update'], "date"),
					   GetSQLValueString($_POST['update'], "date"),
                       GetSQLValueString($_POST['downdate'], "int"),
                       GetSQLValueString($_POST['banner_url'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['zone'], "text"),
					   GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['sorting'], "int"),
                       GetSQLValueString($_POST['banner_type'], "int"),
                       GetSQLValueString($newPicname2, "text"),
                       GetSQLValueString($_POST['id'], "int"));
	@unlink("../images/ksad".$row_RecUpdate['banner_pic2']);
	}
	else{
  $updateSQL = sprintf("UPDATE banner SET `banner_title`=%s, `commerce`=%s, `uname`=%s, `update`=%s, `startdate`=%s, `downdate`=%s, `banner_url`=%s, `banner_position`=%s, `class`=%s, `level`=%s, `sorting`=%s, `banner_type`=%s WHERE banner_id=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['commerce'], "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['update'], "date"),
					   GetSQLValueString($_POST['update'], "date"),
                       GetSQLValueString($_POST['downdate'], "int"),
                       GetSQLValueString($_POST['banner_url'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['zone'], "text"),
					   GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['sorting'], "int"),
                       GetSQLValueString($_POST['banner_type'], "int"),
                       GetSQLValueString($_POST['id'], "int"));			
	}

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($updateSQL, $ksnews3) or die(mysql_error());

  $updateGoTo = "admin_banner.php";
  header(sprintf("Location: %s", $updateGoTo));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/admin_manage.css" rel="stylesheet" type="text/css" />
<script src="../Scripts/swfobject_modified.js" type="text/javascript"></script>
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
</head>

<body>
<div id="body">
<div id="top_nav">
  <table width="821" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="23" background="../images/board10.gif">&nbsp;</td>
      <td width="144" background="../images/board04.gif" align="left" style="font-size:0.8em">上架圖文廣告管理區 </td>
      <td width="650" background="../images/board04.gif"><a href="admin_banner_addswf.php" target="frm"><img src="../images/icon_addswf.gif" width="61" height="19" alt="增加SWF動畫廣告" /></a><a href="admin_banner_add.php" target="frm"><img src="../images/icon_addpic.gif" width="61" height="19" alt="增加圖像廣告" /></a><a href="admin_banner_add_newsdetail.php" target="frm"><img src="../images/icon_addfont.gif" width="61" height="19" alt="增加跑馬燈廣告" /></a><a href="admin_banner_add_newsClass.php" target="frm"><img src="../images/icon_addpic_news1.gif" width="113" height="19" alt="新聞分類整批增加" /></a><a href="admin_banner_add_newsdetails.php" target="frm"><img src="../images/icon_addpic_news2.gif" width="113" height="19" alt="新聞內文整批增加" /></a></td>
      <td width="10" background="../images/board05.gif">&nbsp;</td>
    </tr>
  </table>
</div>
<div id="content">
  <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST" enctype="multipart/form-data">
    <table width="821" border="0" cellpadding="1">
      <tr>
        <td width="115" class="cx_admin_table">更新 廣告</td>
        <td width="690" class="cx_admin_table"><input name="id" type="hidden" id="id" value="<?php echo $row_RecUpdate['banner_id']; ?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">標題</td>
        <td class="cx_admin_table"><input name="title" type="text" id="title" value="<?php echo $row_RecUpdate['banner_title']; ?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">商家</td>
        <td class="cx_admin_table"><input name="commerce" type="text" id="commerce" value="<?php echo $row_RecUpdate['commerce']; ?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">商家帳號</td>
        <td class="cx_admin_table"><input name="uname" type="text" id="uname" value="<?php echo $row_RecUpdate['uname']; ?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">上架日</td>
        <td class="cx_admin_table"><input name="update" type="text" id="update" value="<?php echo $row_RecUpdate['startdate']; ?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">上架天數</td>
        <td class="cx_admin_table"><input name="downdate" type="text" id="downdate" value="<?php echo $row_RecUpdate['downdate']; ?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">廣告連結</td>
<td class="cx_admin_table"><input name="banner_url" type="text" id="banner_url" value="<?php echo $row_RecUpdate['banner_url']; ?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">原本位置</td>
        <td class="cx_admin_table">
		
		<select name="b_position" id="b_position" disabled="disabled" >
          <?php
do {  
?>
          <option value="<?php echo $row_RecPosition['chained']?>"<?php if (!(strcmp($row_RecPosition['chained'], $row_RecUpdate['banner_position']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecPosition['type_name']?></option>
          <?php
} while ($row_RecPosition = mysql_fetch_assoc($RecPosition));
  $rows = mysql_num_rows($RecPosition);
  if($rows > 0) {
      mysql_data_seek($RecPosition, 0);
	  $row_RecPosition = mysql_fetch_assoc($RecPosition);
  }
?>
          </select>
          <label for="b_zone"></label>
          <select name="b_zone" id="b_zone" disabled="disabled">
            <?php
do {  
?>
            <option value="<?php echo $row_RecZone['c_zone']?>"<?php if (!(strcmp($row_RecZone['c_zone'].$row_RecZone['c_zip'], $row_RecUpdate['banner_position'].$row_RecUpdate['class']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecZone['c_name']?></option>
            <?php
} while ($row_RecZone = mysql_fetch_assoc($RecZone));
  $rows = mysql_num_rows($RecZone);
  if($rows > 0) {
      mysql_data_seek($RecZone, 0);
	  $row_RecZone = mysql_fetch_assoc($RecZone);
  }
?>
          </select></td>
      </tr>
      <tr>
        <td class="cx_admin_table">選擇位置</td>
        <td class="cx_admin_table">
		<?php require_once("cx_position.php"); ?>  

排序
<input type="text" name="sorting" id="sorting" onkeypress="IsNum(event)" value="<?php echo $row_RecUpdate['sorting']; ?>" /><input name="banner_type" type="hidden" id="banner_type" value="<?php echo $row_RecUpdate['banner_type']; ?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">廣告區塊</td>
        <td class="cx_admin_table"><ul>
          <li>首頁頂天         400*62</li>
          <li>首頁右側         270*150 </li>
          <li>首頁左中         100*418 </li>
          <li>首頁中央         275*150</li>
          <li>首頁下(巨幅刊版) 980*200</li>
          <li>分類新聞中央 240*150 </li>
          <li>分類新聞右側 270*150 </li>
          <li>分類新聞下方 200*450</li>
          <li>活動右側         270*150 </li>
          <li>活動沒照片時的圖片 448*448 </li>
          <li>新聞無照片時的廣告 480*285</li>
          <li>新聞內文無照片 420*280</li>
          <li>新聞內文右側          270*150</li>
        </ul></td>
      </tr>
      <tr>
        <td class="cx_admin_table">廣告圖片(前)</td>
        <td class="cx_admin_table"><?php if(isset($row_RecUpdate['banner_pic'])) {?>
        <?php if($row_RecUpdate['banner_type'] == 0) { ?>
        <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100" height="100">
          <param name="movie" value="../images/ksad/<?php echo $row_RecUpdate['banner_pic']; ?>" />
          <param name="quality" value="high" />
          <param name="wmode" value="opaque" />
          <param name="swfversion" value="6.0.65.0" />
          <!-- 此 param 標籤會提示使用 Flash Player 6.0 r65 和更新版本的使用者下載最新版本的 Flash Player。如果您不想讓使用者看到這項提示，請將其刪除。 -->
          <param name="expressinstall" value="../Scripts/expressInstall.swf" />
          <!-- 下一個物件標籤僅供非 IE 瀏覽器使用。因此，請使用 IECC 將其自 IE 隱藏。 -->
          <!--[if !IE]>-->
          <object type="application/x-shockwave-flash" data="../images/ksad/<?php echo $row_RecUpdate['banner_pic']; ?>" width="100" height="100">
            <!--<![endif]-->
            <param name="quality" value="high" />
            <param name="wmode" value="opaque" />
            <param name="swfversion" value="6.0.65.0" />
            <param name="expressinstall" value="../Scripts/expressInstall.swf" />
            <!-- 瀏覽器會為使用 Flash Player 6.0 和更早版本的使用者顯示下列替代內容。 -->
            <div>
              <h4>這個頁面上的內容需要較新版本的 Adobe Flash Player。</h4>
              <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="取得 Adobe Flash Player" width="112" height="33" /></a></p>
            </div>
            <!--[if !IE]>-->
          </object>
          <!--<![endif]-->
        </object>
<?php }else{ ?>
        <img src="../images/ksad/<?php echo $row_RecUpdate['banner_pic']; ?>" width="100" /><br /><?php }} ?>
        <input name="banner_pic" type="file" id="banner_pic" size="50" />
        <br />
        **限制檔案格式為：JPG、GIF、PNG、SWF，檔案尺寸不能超過3MB，如需背景透明圖檔，請使用PNG圖檔 
        請盡量低於100KB</td>
      </tr>
      <?php if($row_RecUpdate['banner_type'] != 0) { ?>
      <tr>
        <td class="cx_admin_table">廣告圖片(後)</td>
        <td class="cx_admin_table">
        <?php if(isset($row_RecUpdate['banner_pic2'])) {?>
        <img src="../images/ksad/<?php echo $row_RecUpdate['banner_pic2']; ?>" width="100" /><br /><?php } ?>
        <input name="banner_pic2" type="file" id="banner_pic2" size="50" />
        <br />
        **限制檔案格式為：JPG、GIF、PNG，檔案尺寸不能超過3MB，如需背景透明圖檔，請使用PNG圖檔 
        請盡量低於100KB</td>
      </tr><?php } ?>
    </table>
    <p align="center">
    <input type="submit" name="button" id="button" value="更新廣告">
      <input type="button" onclick="window.history.back();" value="回上一頁"/></p>
    <input type="hidden" name="MM_update" value="form1" />
  </form>
  </div>
</div>
<script type="text/javascript">
swfobject.registerObject("FlashID");
</script>
</body>
</html>
<?php
mysql_free_result($RecUpdate);
?>
