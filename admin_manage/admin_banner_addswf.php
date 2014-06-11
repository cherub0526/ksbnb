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

$end = $_POST['enddate'];
$enddate = date("Y-m-d",strtotime('+'.$end.' day'));

$array = array('title'=>'標題','commerce'=>'商家','uname'=>'商家帳號','update'=>'上架日','downdate'=>'上架天數','position'=>'位置','zone'=>'區塊','sorting'=>'排序','banner_type'=>'型態');
foreach($array as $key => $value)
{
	if(isset($_POST[$key]) && $_POST[$key]=="")
	{
		echo "<script>alert('請輸入".$value."!!!')</script>";
		unset($_POST["MM_insert"]);
	}
}

if($_POST['zip']!=""){
	$le2=$_POST['zip'];
}
else{
  	$le2=$_POST['zone'];
}
  
if(gettype($le2)!='int'){
	if($_POST['zone']=='E'){
		$le2=160;
	}
	if($_POST['zone']=='F'){
		$le2=174;
	}
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO banner (`banner_title`, `commerce`, `uname`, `update`, `startdate`, `downdate`, `banner_url`, `banner_position`, `class`, `level`, `sorting`, `banner_type`, `banner_pic`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['commerce'], "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['update'], "date"),
					   GetSQLValueString($_POST['update'], "date"),
                       GetSQLValueString($_POST['downdate'], "int"),
                       GetSQLValueString($_POST['banner_url'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['zone'], "text"),
					   GetSQLValueString($le2, "text"),
                       GetSQLValueString($_POST['sorting'], "int"),
                       GetSQLValueString($_POST['banner_type'], "int"),
                       GetSQLValueString($newPicname, "text")
					   /*GetSQLValueString($_POST['price'], "int")*/);

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL, $ksnews3) or die(mysql_error());
}
$newid = mysql_insert_id(); 

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if($_POST['zip']!=""){
	$le2=$_POST['zip'];
}
else{
  	$le2=$_POST['zone'];
}
  
if(gettype($le2)!='int'){
	if($_POST['zone']=='E'){
		$le2=160;
	}
	if($_POST['zone']=='F'){
		$le2=174;
	}
}

	$insertSQL = sprintf("INSERT INTO ad_show (`banner_id`,`level`,`position`,`class`,`sorting`) VALUES (%s, %s, %s, %s, %s)",
						GetSQLValueString($newid, "int"),
						GetSQLValueString($le2, "text"),
						GetSQLValueString($_POST['position'], "text"),
						GetSQLValueString($_POST['zone'], "text"),
						GetSQLValueString($_POST['sorting'], "int"));
	
	mysql_select_db($database_ksnews3,$ksnews3);
	$Result1 = mysql_query($insertSQL,$ksnews3) or die(mysql_error());
	
	$insertGoTo = "admin_banner_addswf.php";
    header(sprintf("Location: %s", $insertGoTo));
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增 SWF 廣告</title>
<link href="../css/admin_manage.css" rel="stylesheet" type="text/css" />
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
  <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
    <table width="821" border="0" cellpadding="1">
      <tr>
        <td width="115" class="cx_admin_table">新增 SWF 廣告</td>
        <td width="690" class="cx_admin_table">&nbsp;</td>
      </tr>
      <tr>
        <td class="cx_admin_table">標題</td>
        <td class="cx_admin_table"><input type="text" name="title" id="title"  value="<?php echo $_POST['title'];?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">商家</td>
        <td class="cx_admin_table"><input type="text" name="commerce" id="commerce"  value="<?php echo $_POST['commerce'];?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">商家帳號</td>
        <td class="cx_admin_table"><input type="text" name="uname" id="uname"  value="<?php echo $_POST['uname'];?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">上架日</td>
        <td class="cx_admin_table"><input name="update" type="text" id="update" value="<?php echo date("Y-m-d");?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">上架天數</td>
        <td class="cx_admin_table"><input type="text" name="downdate" id="downdate"  value="<?php echo $_POST['downdate'];?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">廣告連結</td>
        <td class="cx_admin_table"><input type="text" name="banner_url" id="banner_url"  value="<?php echo $_POST['banner_url'];?>" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">頻道</td>
        <td class="cx_admin_table"><?php require_once("cx_position.php"); ?>  
          
          排序
  <input type="text" name="sorting" id="sorting" onkeypress="IsNum(event)"  value="<?php echo $_POST['sorting'];?>"  /><input name="banner_type" type="hidden" id="banner_type" value="0" /></td>
      </tr>
      <tr>
        <td class="cx_admin_table">廣告區塊</td>
        <td class="cx_admin_table"><ul>
          <li>首頁頂天          400*100</li>
          <li>右下版位          145*145</li>
          <li>中上版位          450*300</li>
          <li>中版位            692*150</li>
          <li>中下版位          692*150 </li>
        </ul></td>
      </tr>
      <tr>
        <td class="cx_admin_table">SWF 廣告</td>
        <td class="cx_admin_table"><input type="file" id="banner_pic" name="banner_pic" />
        <br />
        **限制檔案格式為：SWF，檔案尺寸不能超過300KB，超連結請直接製作在檔案中!!</td>
      </tr>
    </table>
    <p align="center">
    <input type="submit" name="button" id="button" value="新增廣告">
      <input type="reset" name="button2" id="button2" value="重設">
    <input type="button" onclick="window.history.back();" value="回上一頁"/></p>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  </div>
</div>
</body>
</html>