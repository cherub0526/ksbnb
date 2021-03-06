<?php require_once('../Connections/ksnews3.php'); ?>
<?php
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
	$url = strpos($_POST['adv_movie'],"=")+1;
  $insertSQL = sprintf("INSERT INTO banner_detail (adv_id, input_date,adv_title,adv_content,adv_date,adv_contact,adv_tel,adv_addr,adv_movie) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['v_id'], "text"),
					   GetSQLValueString(date("Y-m-d"), "date"),
					   GetSQLValueString($_POST['adv_title'], "text"),
					   GetSQLValueString($_POST['detail'], "text"),
					   GetSQLValueString(date("Y-m-d"), "date"),
					   GetSQLValueString($_POST['adv_contact'], "text"),
					   GetSQLValueString($_POST['adv_tel'], "text"),
                       GetSQLValueString($_POST['adv_addr'], "text"),
					   GetSQLValueString(substr($_POST['adv_movie'],$url), "text"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL, $ksnews3) or die(mysql_error());

  $insertGoTo = "banner_detail_add.php?id=".$_GET['id'];
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>詳細資訊</title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>
	Dropzone.options.myDropzone = {
  init: function() {
    this.on("success", function(file, response) {
      file.serverId = response; 

    });
    this.on("removedfile", function(file) {
      if (!file.serverId) { return; }
      $.post("delete.php?delphoto=true&m_username=<?php echo $_SESSION['MM_Username']; ?>&album_id=<?php echo $row_RecAlbum['album_id']; ?>&ap_subject=" + file.name); 
    });
  }}
</script>
<script type="text/javascript" src="../js/dropzone.js"></script>
<link href="../css/dropzone.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="content" class="cx_admin_table">
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="23" background="../images/board10.gif">&nbsp;</td>
      <td width="232" background="../images/board04.gif" align="left" style="font-size:0.8em">民宿 詳細內容         </td>
      <td width="569" background="../images/board04.gif">&nbsp;</td>
      <td width="11" background="../images/board05.gif">&nbsp;</td>
    </tr>
  </table>
</div>
  <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
    <table width="835" border="0" cellpadding="0">
     <tr>
        <td>
        </td>
      </tr>
      <tr>
      	<td>廣告標題：</td>
        <td><label for="adv_title"></label>
        <input name="adv_title" type="text" id="adv_title" value="" size="80" /></td>
      </tr>
	  <tr>
      	<td>廣告編號：</td>
        <td><?php echo $_GET['id'];?></td>
      </tr>
      <tr>
      	<td>商家電話：</td>
        <td><label for="adv_tel"></label>
        <input name="adv_tel" type="text" id="adv_tel" value="" size="80" /></td>
      </tr>
      <tr>
        <td>商家：</td>
        <td><label for="adv_contact"></label>
        <input name="adv_contact" type="text" id="adv_contact" value="" size="80" /></td>
      </tr>
      <tr>
        <td>商家地點：</td>
        <td><label for="adv_contact"></label>
        <input name="adv_addr" type="text" id="adv_addr" value="" size="80" /></td>
      </tr>
      <tr>
        <td width="145">影片來源：          </td>
        <td width="684"><label for="adv_movie"></label>
        <input name="adv_movie" type="text" id="adv_movie" size="70" /></td>
      </tr>
      <tr>
      	<td>詳細廣告內容</td>
        <td><label for="detail"></label>
        <textarea name="detail" cols="80" id="detail" wrap="soft" ></textarea></td>
      </tr>
    </table>
    <p align="center">
      <input name="v_id" type="hidden" id="v_id" value="<?php echo $_GET['id']; ?>" />
    <input type="submit" value="送出" /> <input type="reset" value="重新填寫"  /> <input type="button" value="回上一頁" onclick="window.history.back()" /></p>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="23" background="../images/board10.gif">&nbsp;</td>
      <td width="112" background="../images/board04.gif" align="left" style="font-size:0.8em">民宿 新增圖片 </td>
      <td width="689" background="../images/board04.gif">&nbsp;</td>
      <td width="11" background="../images/board05.gif">&nbsp;</td>
    </tr>
  </table>
</div>  
  <form action="file-upload.php" class="dropzone" name="myDropzone" id="myDropzone" style="width:840px">
    <table width="835" border="0" cellpadding="0">
     <tr>
        <td colspan="2">
        </td>
      </tr>
      <tr>
        <td width="145" height="73">圖片來源：
          <input name="v_id" type="hidden" id="v_id" value="<?php echo $_GET['id']; ?>" />
          <input name="date" value="<?php echo date("Y-m-d h:i:s");?>" type="hidden" /></td>
        <td width="684"><h1>請把檔案拖曳到下方(jpg,png)</h1></td>
      </tr>
    </table>
    <p align="center">&nbsp;</p>
  </form>
  

<?php
include_once "ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("detail");
?>
</body>
</html>