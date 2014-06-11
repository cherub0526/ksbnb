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
//自訂變數$password記錄隱藏欄位傳送過來的已加密舊密碼
$password=$_POST["password"];
//如果新密碼passwordNew輸入欄位不是空的
if($_POST["passwordNew"]!=""){
	     //自訂變數$password就變更，改為記錄md5加密的passwordNew
	     $password=$_POST["passwordNew"];
	}
	
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  
  $checkdate_array=explode('-',$_POST['expire']);
  if(!checkdate($checkdate_array[1],$checkdate_array[2],$checkdate_array[0]))
  {echo "<script>window.alert("."'有效日期輸入錯誤，請依照西元年-月-日作輸入'".")</script>";
	//echo checkdate($checkdate_array[1],$checkdate_array[2],$checkdate_array[0]);
	$error=1;
  }
  		if($_POST['username']=="" || !isset($_POST['username']))
	{
		echo "<script>window.alert("."'帳號不可空白'".");</script>";
		$error=1;
	}
	/*
	if($_POST['password']=="" || !isset($_POST['password']))
	{
		echo "<script>window.alert("."'密碼不可空白'".");</script>";
		$error=1;
	}
	*/
	if($_POST['uname']=="")
	{
		echo "<script>window.alert("."'姓名不可空白'".");</script>";
		$error=1;
	}
	if($_POST['phone']=="")
	{
		echo "<script>window.alert("."'電話不可空白'".");</script>";
		$error=1;
	}
	if($_POST['mobile']=="")
	{echo "<script>window.alert("."'手機不可空白'".");</script>";
		$error=1;
	}
	if($_POST['email']=="")
	{echo "<script>window.alert("."'信箱不可空白'".");</script>";
		$error=1;
	}
	
	if($_POST['email']!="")
	{
		//echo "<script>window.alert("."'帳號不可空白'".")<script>";
		mysql_select_db($database_ksnews3,$ksnews3);
		$sql_check_user="select * from user_info where email='".$_POST['email']."' AND user_id <> ".$_GET['id'];
		$rec_check_user=mysql_query($sql_check_user);
		//$row_check_user=mysql_fetch_assoc($rec_check_user);
		//$num_check_user=mysql_num_rows($rec_check_user);
		//echo $sql_check_user;
		/*if($num_check_user>0)
		{echo '<script>alert("信箱不可重複");</script>';
			$error=1;
		}*/
		
	}
	
		if($_POST['username']!="")
	{
		/*echo "<script>window.alert("."'帳號不可空白'".")</script>";*/
		$sql_check_user="select * from users where user='".$_POST['username']."' AND user_id <> ".$_GET['id'];
		$rec_check_user=mysql_query($sql_check_user);
		//$row_check_user=mysql_fetch_assoc($rec_check_user);
		if($row_check_user['user_id']!="")
		{echo '<script>window.alert("帳號不可重複");</script>';
			$error=1;
		}
		
	}
	
	
	
	if($_POST['edu']=="" || !isset($_POST['edu']))
	{echo "<script>window.alert("."'學歷不可空白'".");</script>";
		$error=1;
	}
	if($_POST['sex']=="" || !isset($_POST['sex']))
	{echo "<script>window.alert("."'性別不可空白'".");</script>";
		$error=1;
	}
	if($_POST['cusadr']=="" || !isset($_POST['cusadr']))
	{echo "<script>window.alert("."'地址不可空白'".");</script>";
		$error=1;
	}
	if($_POST['cityarea']=="" || !isset($_POST['cityarea']))
	{echo "<script>window.alert("."'居住地區不可空白'".");</script>";
		$error=1;
	}
	if($_POST['Area']=="" || !isset($_POST['Area']))
	{echo "<script>window.alert("."'居住縣市不可空白'".");</script>";
		$error=1;
	}
	if($_POST['cuszip']=="" || !isset($_POST['cuszip']))
	{echo "<script>window.alert("."'郵遞區號不可空白，請勾選居住縣市地區，系統將自動為您填上'".");</script>";
		$error=1;
	}
  //print_r($checkdate_array);
  $updateSQL = sprintf("UPDATE users SET `user`=%s, pass=%s,level=%s WHERE user_id=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($password, "text"),
                       GetSQLValueString($_POST['level'], "text"),
                      // GetSQLValueString($_POST['verify'], "int"),
                       GetSQLValueString($_POST['id'], "int"));
	if($error!=1){
  mysql_select_db($database_ksnews3, $ksnews3);
  //echo $updateSQL;
  $Result1 = mysql_query($updateSQL, $ksnews3) or die(mysql_error());
  
    $updateSQL_user_info=sprintf("UPDATE user_info set name=%s,tel=%s,mobile=%s,company=%s,
  								email=%s,edu=%s,sex=%s,note=%s,expire=%s,times=%s,addr=%s
								,cuszip=%s,cityarea=%s,Area=%s where user_id=%s"
,GetSQLValueString($_POST['uname'], "text"),
GetSQLValueString($_POST['phone'], "text"),
GetSQLValueString($_POST['mobile'], "text"),
GetSQLValueString($_POST['company'], "text"),
GetSQLValueString($_POST['email'], "text"),
GetSQLValueString($_POST['edu'], "text"),
GetSQLValueString($_POST['sex'], "text"),
GetSQLValueString('0000000', "text"),
GetSQLValueString($_POST['expire'], "text"),
GetSQLValueString(0, "text"),
GetSQLValueString($_POST['cusadr'], "text"),
GetSQLValueString($_POST['cuszip'], "text"),
GetSQLValueString($_POST['cityarea'], "text"),
GetSQLValueString($_POST['Area'], "text"),
GetSQLValueString($_POST['id'], "int")
);

  mysql_select_db($database_ksnews3, $ksnews3);
  //echo $updateSQL_user_info;
  $Result1 = mysql_query($updateSQL_user_info, $ksnews3) or die(mysql_error());
  
  	   $level_check_change="update priority set sub_group = ".$_POST['level']." where user='{$_POST['username']}'";
	     	   $level_check_change="update priority set sub_group =".$_POST['level']."where user='{$_POST['username']}'";
   if($_POST['olduser']!=$_POST['username'])
	{  $level_check_change="update priority set sub_group =".$_POST['level'].", user='".$_POST['username']."'  where user='{$_POST['olduser']}'";
}   

     mysql_select_db($database_ksnews3, $ksnews3);
	 mysql_query($level_check_change,$ksnews3);
	 //echo $level_check_change;
  
  
/*if($_POST['level']=='member'){
  $updateGoTo = "admin_member.php";
  }
  else
  {
	  $updateGoTo = "admin_user.php";}
      if($_POST['olduser']!=$_POST['username'] && $_SESSION['username']==$_POST['olduser'])    
	  $updateGoTo = "../logout.php";
  	  if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  if($error!=1)
  header(sprintf("Location: %s", $updateGoTo));
  }
}

$colname_member = "-1";
if (isset($_GET['id'])) {
  $colname_member = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_member = sprintf("SELECT * FROM users LEFT JOIN user_info ON user_info.user_id = users.user_id
 WHERE users.user_id = %s", GetSQLValueString($colname_member, "int"));
// echo $query_member;
$member = mysql_query($query_member, $ksnews3) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台-更生房仲網</title>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Language" content="zh-tw" />
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<script language=javascript src="js/address.js"></script><!--引入郵遞區號.js檔案-->
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
</head>

<body>
<div id="main">
<?php //include("header.php"); ?>
<? //include("right_zone.php");?>
<div id="admin_main2">
  <form id="form3" name="form3" method="POST" action="<?php echo $editFormAction; ?>" class="cx_admin_table">
 
    <table width="540" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board03.gif" /></td>
        <td width="505" align="left" background="../images/board04.gif">&nbsp; <span class="font_black">親愛的管理員，您正在編輯會員[<?php echo $row_member['user']; ?></span><span class="font_red">&nbsp; &nbsp;</span><span class="font_black">]的資料</span></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="540" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td height="30" align="right" class="board_add">帳號：</td>
        <td align="left" class="board_add"><label>
	 <?php if($_SESSION['group']=='admin' && $_SESSION['level']=='1'){ ?>
          <input name="username" type="text" id="username" value="<?php echo $row_member['user']; ?>" />
	            <input name="olduser" type="hidden" id="olduser" value="<?php echo $row_member['user']; ?>" />

        </label><?php }else{ echo $row_member['user']; ?>
	  <input name="username" type="hidden" id="username" value="<?php echo $row_member['user']; ?>" />
	  <?php } ?>
	
        </label></td>
      </tr>
      <tr>
        <td width="81" height="30" align="right" class="board_add">姓名：</td>
        <td width="451" align="left" class="board_add"><label>
          <input name="uname" type="text" id="uname" value="<?php echo $row_member['name']; ?>" />
        </label></td>
      </tr>
       <?php if($_SESSION['group']=='admin'){ ?>
      <tr>
        <td height="30" align="right" class="board_add">等級：</td>
        <td align="left" class="board_add"><label>
          <select name="level" id="level">
			<?php 
			  $sql_vender_level_all="select * from admin_level";
			  $rec_vender_level_all=mysql_query($sql_vender_level_all,$ksnews3);
			  $row_vender_level_all=mysql_fetch_assoc($rec_vender_level_all);
			  
			  $sql_vender_level="select * from users  where user='{$row_member['user']}'"
			  ;
			  $rec_vender_level=mysql_query($sql_vender_level);
			 $row_vender_level=mysql_fetch_assoc($rec_vender_level);
			 $rec_vender_level_all=mysql_query($sql_vender_level_all,$ksnews3);
			  $row_vender_level_all=mysql_fetch_assoc($rec_vender_level_all);
			  $rec_vender_level_all=mysql_query($sql_vender_level_all,$ksnews3);
			   while($row_vender_level_all=mysql_fetch_assoc($rec_vender_level_all))
			  {
				  if($row_vender_level_all['id']==$row_vender_level['level'])
				  {echo '<option selected="selected" value="'.$row_vender_level_all['id'].'" >'.$row_vender_level_all['level'];}
				  else{echo '<option value="'.$row_vender_level_all['id'].'" >'.$row_vender_level_all['level'];}
			  }
			   
			?>
          </select>
        </label></td>
      </tr><?php } ?>
      <tr>
        <td height="30" align="right" class="board_add">有效期間:</td>
        <td align="left" class="board_add"><label for="expire"></label>
          <input name="expire" type="text" id="expire" value="<?php echo $row_member['expire']; ?>" />
        yyyy-mm-dd</td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">變更密碼：</td>
        <td align="left" class="board_add"><label>
          <input name="passwordNew" type="text" id="passwordNew" size="15" value="<?php echo $row_member['pass']; ?>" />
        </label><span class="font_red">*如需變更密碼才輸入!
          <input name="password" type="hidden" id="password" value="<?php echo $row_member['pass']; ?>" />
        </span></td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">E-mail：</td>
        <td align="left" class="board_add"><label>
          <input name="email" type="text" id="email" value="<?php echo $row_member['email']; ?>" size="35" />
        </label><br />
        <span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到註冊信及訂閱之會員電子報。</span></td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">學歷：</td>
        <td align="left" class="board_add"><label>
          <input <?php if (!(strcmp($row_member['edu'],"國小"))) {echo "checked=\"checked\"";} ?> name="edu" type="radio" id="edu_0" value="國小" checked="checked" />
          國小</label>
          <label>
            <input <?php if (!(strcmp($row_member['edu'],"國中"))) {echo "checked=\"checked\"";} ?> type="radio" name="edu" value="國中" id="edu_1" />
            國中</label>
          <label>
            <input <?php if (!(strcmp($row_member['edu'],"高中職"))) {echo "checked=\"checked\"";} ?> type="radio" name="edu" value="高中職" id="edu_2" />
            高中職</label>
          <label>
            <input <?php if (!(strcmp($row_member['edu'],"專科"))) {echo "checked=\"checked\"";} ?> type="radio" name="edu" value="專科" id="edu_3" />
            專科</label>
          <label>
            <input <?php if (!(strcmp($row_member['edu'],"大學"))) {echo "checked=\"checked\"";} ?> type="radio" name="edu" value="大學" id="edu_4" />
            大學</label>
          <label>
            <input <?php if (!(strcmp($row_member['edu'],"碩士"))) {echo "checked=\"checked\"";} ?> type="radio" name="edu" value="碩士" id="edu_5" />
            碩士</label>
          <label>
            <input <?php if (!(strcmp($row_member['edu'],"博士"))) {echo "checked=\"checked\"";} ?> type="radio" name="edu" value="博士" id="edu_6" />
        博士</label></td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">公司：</td>
        <td align="left" class="board_add"><input name="company" type="text" id="company" value="<?php echo $row_member['company']; ?>" /></td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">性別：</td>
        <td align="left" class="board_add"><label>
          <input <?php if (!(strcmp($row_member['sex'],"man"))) {echo "checked=\"checked\"";} ?> name="sex" type="radio" id="radio" value="man" checked="checked" />
          男</label>
          <label><input <?php if (!(strcmp($row_member['sex'],"woman"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="radio2" value="woman" />
        女&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label></td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">手機：</td>
        <td align="left" class="board_add"><input name="mobile" type="text" id="mobile" value="<?php echo $row_member['mobile']; ?>" /></td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">電話：</td>
        <td align="left" class="board_add"><label>
          <input name="phone" type="text" id="phone" value="<?php echo $row_member['tel']; ?>" />
        </label></td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">郵遞區號：</td>
        <td align="left" class="board_add">
          <select name="Area" title="<?php echo $row_member['Area']; ?>" onChange="citychange(this.form)">
                         <option value="基隆市">基隆市</option>
              <option value="臺北市">臺北市</option>
              <option value="新北市">新北市</option>
              <option value="桃園縣">桃園縣</option>
              <option value="新竹市">新竹市</option>
              <option value="新竹縣">新竹縣</option>
              <option value="苗栗縣">苗栗縣</option>
              <option value="臺中市">臺中市</option>              
              <option value="彰化縣">彰化縣</option>
              <option value="南投縣">南投縣</option>
              <option value="雲林縣">雲林縣</option>
              <option value="嘉義縣">嘉義縣</option>
              <option value="臺南市">臺南市</option>             
              <option value="高雄市">高雄市</option>             
              <option value="屏東縣">屏東縣</option>
              <option value="臺東縣">臺東縣</option>
              <option value="花蓮縣" selected="selected">花蓮縣</option>
              <option value="宜蘭縣">宜蘭縣</option>
              <option value="澎湖縣">澎湖縣</option>
              <option value="金門縣">金門縣</option>
              <option value="連江縣">連江縣</option>
          </select>                          
          <select onChange="areachange(this.form)" name="cityarea">
             <option value="花蓮市" selected="selected">花蓮市</option>
              <option value="新城鄉">新城鄉</option>
              <option value="吉安鄉">吉安鄉</option>
              <option value="壽豐鄉">壽豐鄉</option>
              <option value="秀林鄉">秀林鄉</option>
              <option value="鳳林鎮">鳳林鎮</option>
              <option value="光復鄉">光復鄉</option>
              <option value="豐濱鄉">豐濱鄉</option>
              <option value="瑞穗鄉">瑞穗鄉</option>
              <option value="萬榮鄉">萬榮鄉</option>
              <option value="玉里鎮">玉里鎮</option>
	      <option value="富里鄉">富里鄉</option>	      
              <option value="卓溪鄉">卓溪鄉</option>         
	      </select>
          <input type="hidden" value="100" name="Mcode" />
          <input name="cuszip" value="<?php echo $row_member['cuszip']; ?>" size="5" maxlength="5" readonly="readOnly" />
        </td>
      </tr>
      <tr>
        <td height="30" align="right" class="board_add">完整地址：</td>
        <td align="left" class="board_add"><span class="bs">
          <input name="cusadr" type="text" id="cusadr" value="<?php echo $row_member['addr']; ?>" size="60" />
        </span></td>
      </tr>
      <tr>
        <td height="40" colspan="2" align="center"><label>
          <input type="submit" name="button" id="button" value="更新資料" /> </label>
          <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
          <input name="id" type="hidden" id="id" value="<?php echo $row_member['user_id']; ?>" />
       </td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form3" />
  </form>
</div>
</div>

</body>
</html>
<?php
mysql_free_result($member);
?>
