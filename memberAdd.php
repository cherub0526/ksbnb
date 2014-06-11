<?php
session_start();
if(isset($_POST["captcha"])) {
	if(($_SESSION['captcha_code'] == $_POST['captcha']) && (!empty($_SESSION['captcha_code'])) ) {
		//Passed!
		$captcha_msg="Thank you";
	}else{
		// Not passed 8-(
		$captcha_msg="invalid code";
		if(isset($_POST["MM_insert"])){
	  		unset($_POST["MM_insert"]);
		}
		if(isset($_POST["MM_update"])){
			unset($_POST["MM_update"]);
		}
	}
}
class CaptchaImage {
	var $font = "monofont.ttf";
	function hex_to_dec($hexcolor){
	//convert hex hex values to decimal ones
	$dec_color=array('r'=>hexdec(substr($hexcolor,0,2)),'g'=>hexdec(substr($hexcolor,2,2)),'b'=>hexdec(substr($hexcolor,4,2)));
	return $dec_color;
	}
	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz'; 
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}
	function CaptchaImage($width='120',$height='30',$characters='6',$hex_bg_color='FFFFFF',$hex_text_color="FF0000",$hex_noise_color="CC0000", $img_file='captcha.jpg') {
		$rgb_bg_color=$this->hex_to_dec($hex_bg_color);
		$rgb_text_color=$this->hex_to_dec($hex_text_color);
		$rgb_noise_color=$this->hex_to_dec($hex_noise_color);
		$code = $this->generateCode($characters);
		/* font size will be 60% of the image height */
		$font_size = $height * 0.60;
		$image = @imagecreate($width, $height) or die('Cannot Initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, $rgb_bg_color['r'], $rgb_bg_color['g'],$rgb_bg_color['b']);
		$text_color = imagecolorallocate($image, $rgb_text_color['r'], $rgb_text_color['g'],$rgb_text_color['b']);
		$noise_color = imagecolorallocate($image, $rgb_noise_color['r'], $rgb_noise_color['g'],$rgb_noise_color['b']);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code);
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code);
		/* save the image */
		imagejpeg($image,$img_file);
		imagedestroy($image);
		echo "<img src=\"$img_file?".time()."\" width=\"$width\" height=\"$height\" alt=\"security code\" id=\"captchaImg\">";
		$_SESSION['captcha_code'] = $code;
	}

}
?>
<?php require_once('Connections/ksnews3.php'); ?>
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

mysql_select_db($database_ksnews3, $ksnews3);
$query_admin_mail = "SELECT mail FROM admin_email WHERE mail_id = 7";
$admin_mail = mysql_query($query_admin_mail, $ksnews3) or die(mysql_error());
$row_admin_mail = mysql_fetch_assoc($admin_mail);
$totalRows_admin_mail = mysql_num_rows($admin_mail);

mysql_select_db($database_ksnews3, $ksnews3);
$query_post_agree = "SELECT post_agree_id, post_content FROM post_agree WHERE post_agree_id = 3";
$post_agree = mysql_query($query_post_agree, $ksnews3) or die(mysql_error());
$row_post_agree = mysql_fetch_assoc($post_agree);
$totalRows_post_agree = mysql_num_rows($post_agree);

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="index.php";
  $loginUsername = $_POST['username'];
   $loginUsername = $_POST['email'];
  //$LoginRS__query = sprintf("SELECT user FROM users WHERE user=%s OR email=%s", GetSQLValueString($loginUsername, "text"),GetSQLValueString($loginEmail, "text"));
  $LoginRS__query = sprintf("SELECT user FROM users WHERE user=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_ksnews3, $ksnews3);
  $LoginRS=mysql_query($LoginRS__query, $ksnews3) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$birthday=$_POST["year"]."-".$_POST["month"]."-".$_POST["day"];

session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更生房仲網_會員註冊</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<link href="web.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/ks_logo.ico"> 
<script language=javascript src="address.js"></script><!--引入郵遞區號.js檔案-->
<script src="SpryAssets/SpryData.js" type="text/javascript"></script>
<script language="javascript">
<!--
function chkUserID(idObj){ 
	if(idObj.value.length < 4){
		/*帳號欄位輸入不得少於4個字元，否則顯示提示訊息*/
		document.getElementById("idErrMsg").innerHTML = "<img src='images/icon-cross.gif' /><font color='red'> 帳號輸入請勿少於4個字元</font>";
	}else{
		/*確認無誤，採用GET方式傳遞帳號欄位輸入內容至member_idCheck.php頁面，進行帳號查詢，並傳回結果*/
		Spry.Utils.loadURL("GET","member_idCheck.php?username=" + idObj.value,false,uidchkRes);
	}
}
function uidchkRes(idreq){ /*下面依據查詢結果，顯示對應訊息*/
	var IDresult = idreq.xhRequest.responseText;
	if(IDresult!=0){
		document.getElementById("idErrMsg").innerHTML = "<img src='images/icon-cross.gif' /><font color='red'> 此帳號已被使用!!</font>";
	}else{
		document.getElementById("idErrMsg").innerHTML = "<img src='images/icon-tick.gif' /><font color='green'> 此帳號可註冊使用!</font>";
	}
}
function chkUserMail(mailObj){
	if(mailObj.value.length < 10){
		/*email欄位輸入不得少於4個字元，否則顯示提示訊息*/
		document.getElementById("emailErrMsg").innerHTML = "<img src='images/icon-cross.gif' /><font color='red'> email輸入請勿少於4個字元</font>";
	}else{
		/*確認無誤，採用GET方式傳遞email欄位輸入內容至member_emailCheck.php頁面，進行email查詢，並傳回結果*/
		Spry.Utils.loadURL("GET","member_emailCheck.php?email=" + mailObj.value,false,umailchkRes);
	}
}
function umailchkRes(mailreq){  /*下面依據查詢結果，顯示對應訊息*/
	var IDresult = mailreq.xhRequest.responseText;
	if(IDresult!=0){
		document.getElementById("emailErrMsg").innerHTML = "<img src='images/icon-cross.gif' /><font color='red'> 此email已被使用!!</font>";
	}else{
		document.getElementById("emailErrMsg").innerHTML = "<img src='images/icon-tick.gif' /><font color='green'> 此email可註冊使用!</font>";
	}
}			
-->
</script>
<style type="text/css">
#assent {
	float: right;
	height: 500px;
	width: 420px;
	margin-top: 4px;
}
#textfield {
	font-family: "新細明體","微軟正黑體", "標楷體";
	font-size: 14px;
}
#terms {
	width: 400px;
	height: 500px;
	overflow: auto;	/* 捲軸 */
	border: 1px solid #ccc;
	margin-bottom: 10px;
	padding: 10px;
	font-size: 16px;
}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/digitalspaghetti.password.js"></script>
<script type="text/javascript">
<!--
	$(function(){
		// 設定 verdicts 及 minCharMsg 等值
		$('#password').pstrength({
			verdicts: ["很弱","弱","普通","強","很強"],
			minCharText: "密碼最少要 %d 位"
		});

		// 加上新規則，如果密碼中包含 admin 則扣 10 分
		$("#password").pstrength.addRule("isAdmin", function (word, score) {
			return word.indexOf("admin")>-1 && score;
		}, -10, true);
	});
//-->
</script>
<?php 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "memberadd")) {

		if($_POST['username']=="" || !isset($_POST['username']))
	{
		echo "<script>window.alert("."'帳號不可空白'".")</script>";
		$error=1;
	}
	if($_POST['password']=="" || !isset($_POST['password']))
	{echo "<script>window.alert("."'密碼不可空白'".")</script>";
		$error=1;
	}
	if($_POST['uname']=="" || !isset($_POST['uname']))
	{echo "<script>window.alert(".'姓名不可空白'.")</script>";
		$error=1;
	}
	if($_POST['phone']=="")
	{echo "<script>window.alert("."'電話不可空白'".")</script>";
		$error=1;
	}
	if($_POST['mobile']=="")
	{echo "<script>window.alert("."'手機不可空白'".");history.back(0);</script>";
		$error=1;
	}
	if($_POST['email']=="")
	{echo "<script>window.alert("."'信箱不可空白'".")</script>";
		$error=1;
	}
		if($_POST['email']!="")
	{
		echo  "<script>window.alert("."'帳號不可空白'".")</script>";
		$sql_check_user="select * from user_info where email='".$_POST['email']."'";
		$rec_check_user=mysql_query($sql_check_user);
		$row_check_user=mysql_fetch_assoc($rec_check_user);
		if($row_check_user['user_id']!="")
		{echo '<script>window.alert("信箱不可重複");</script>';
			$error=1;

		}
		
	}
		if($_POST['username']!="")
	{
		echo  "<script>window.alert("."'帳號不可空白'".")</script>";
		$sql_check_user="select * from users where user='".$_POST['username']."'";
		$rec_check_user=mysql_query($sql_check_user);
		$row_check_user=mysql_fetch_assoc($rec_check_user);
		if($row_check_user['user_id']!="")
		{echo '<script>window.alert("帳號不可重複");history.back(0)</script>';
			$error=1;
		}
		
	}
	
	
	
	if($_POST['edu']=="" || !isset($_POST['edu']))
	{echo "<script>window.alert("."'學歷不可空白'".")</script>";
		$error=1;
	}
	if($_POST['sex']=="" || !isset($_POST['sex']))
	{echo "<script>window.alert("."'性別不可空白'".")</script>";
		$error=1;
	}
	if($_POST['cusadr']=="" || !isset($_POST['cusadr']))
	{echo "<script>window.alert("."'地址不可空白'".")</script>";
		$error=1;
	}
	if($_POST['cityarea']=="" || !isset($_POST['cityarea']))
	{echo "<script>window.alert("."'居住地區不可空白'".")</script>";
		$error=1;
	}
	if($_POST['Area']=="" || !isset($_POST['Area']))
	{echo "<script>window.alert("."'居住縣市不可空白'".")</script>";
		$error=1;
	}
	if($_POST['cuszip']=="" || !isset($_POST['cuszip']))
	{echo "<script>window.alert("."'郵遞區號不可空白，請勾選居住縣市地區，系統將自動為您填上'".")</script>";
		$error=1;
	}

  $insertSQL = sprintf("INSERT INTO users (user, pass ,level, level_group, join_date  ,join_time , verify) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
					   GetSQLValueString("1", "int"),
                       GetSQLValueString("member", "text"),
                       GetSQLValueString(date("Y-m-d"), "date"),
					   GetSQLValueString(date("YmdHis"), "date"),                      
					   GetSQLValueString("0", "int"));
 if($error!=1){
  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL, $ksnews3) or die(mysql_error());
  echo $insertSQL;
 $insertSQL_user_info=sprintf("INSERT INTO user_info(name,tel,mobile,
company,email,edu,sex,note,expire,times,addr,cuszip,cityarea,Area) 

VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s , %s)


",
GetSQLValueString($_POST['uname'], "text"),
GetSQLValueString($_POST['phone'], "text"),
GetSQLValueString($_POST['mobile'], "text"),
GetSQLValueString($_POST['company'], "text"),
GetSQLValueString($_POST['email'], "text"),
GetSQLValueString($_POST['edu'], "text"),
GetSQLValueString($_POST['sex'], "text"),
GetSQLValueString($_POST['note'], "text"),
GetSQLValueString((date("Y")+1).'-'.date("m-d H:i:s"), "text"),
GetSQLValueString(0, "text"),
GetSQLValueString($_POST['cusadr'], "text"),
GetSQLValueString($_POST['cuszip'], "text"),
GetSQLValueString($_POST['cityarea'], "text"),
GetSQLValueString($_POST['Area'], "text")
);
  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL_user_info, $ksnews3) or die(mysql_error());
     echo $insertSQL_user_info;
   
 
 $group_priority_level="select * from group_allow where `group`='member' order by sub_group desc limit 0,1";
 $rec_priority_level=mysql_query($group_priority_level,$ksnews3);
 $row_priority_level=mysql_fetch_assoc($rec_priority_level);
 
 $insertSQL_user_priority=sprintf("INSERT INTO priority(user,`group` ,sub_group ,
name,allow) 

VALUES(%s, %s, %s, %s, %s)


",
GetSQLValueString($_POST['username'], "text"),
GetSQLValueString('member', "text"),
GetSQLValueString($row_priority_level['sub_group'], "text"),
GetSQLValueString($_POST['uname'], "text"),
GetSQLValueString($row_priority_level['allow'], "text")

); 
  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL_user_priority, $ksnews3); //or die(mysql_error());
   echo $insertSQL_user_priority;
  $insertGoTo = "memberAddSuccess.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //加入會員成功後，寄發會員信
/*  mb_internal_encoding('UTF-8');//指定發信使用UTF-8編碼，防止信件標題亂碼
  $servicemail=$row_admin_mail['mail'];//指定網站管理員服務信箱，請修改為自己的有效mail
  $webname="更生房仲網";//寫入網站名稱
  $email=$_POST['email'];//上一頁傳來的會員email
  $subject=$_POST['name']."您好，歡迎您加入".$webname;//信件標題
  $subject=mb_encode_mimeheader($subject, 'UTF-8');//指定標題將雙位元文字編碼為單位元字串，避免亂碼
  //指定信件內容
  $body="親愛的會員".$_POST['uname']."您好，歡迎您加入更生房仲網網站成為會員，以下是您的會員資料:<br />
         您的帳號是".$_POST['username']."<br />您的密碼是".$_POST['password']."<br />
         請妥善保存您的資料，如有任何問題歡迎與我們聯絡，謝謝!!any problem，you can touch us，thank you!!";
  //郵件檔頭設定
  $headers = "MIME-Version: 1.0\r\n";//指定MIME(多用途網際網路郵件延伸標準)版本
  $headers .= "Content-type: text/html; charset=utf-8\r\n";//指定郵件類型為HTML格式
  $headers .= "From:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail."> \r\n";//指定寄件者資訊
  $headers .= "Reply-To:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//指定信件回覆位置
  $headers .= "Return-Path:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//被退信時送回位置
  //使用mail函數寄發信件
  mail ($email,$subject,$body,$headers);
//加入會員成功後，寄發會員信結束*/

  include('PHPMailer/class.phpmailer.php');
      mb_internal_encoding('UTF-8');
	  $mail=new PHPMailer();
	  $mail->IsSMTP();
	  $mail->Host = "msa.hinet.net";
	  $mail->CharSet= "UTF-8";
	  $mail->From = "keng-shen5@umail.hinet.net";
	  $mail->FromName = "更生房仲網帳密";
	  $mail->Subject = "更生房仲網帳密";
	  $mail->AddAddress($_POST['email'],"更生房仲網");
	  
	  $body = "會員{$_POST['username']}您好，您的帳密如下：\n<br />
	  帳號 ： {$_POST['username']} \n<br />
	  密碼 ： {$password} \n<br />";
	  $body = eregi_replace("[\]",'',$body);
	  $mail -> AltBody = "會員{$_POST['username']}您好，您的帳密如下：\n<br />
	  帳號 ： {$_POST['username']} \n<br />
	  密碼 ： {$password} \n<br />";
	  $mail->MsgHTML($body);

if(!$mail->Send()) {
  echo "寄信發生錯誤：" . $mail->ErrorInfo;
} else {
  echo "寄信成功";
}

 echo "<script>document.location.href=".'"memberAddSuccess.php"'.";</script>";
	}
 }


?>
</head>

<body>


<div id="main">
<?php include("header.php"); ?>
  <?php if(!empty($row_post_agree['post_content'])) { ?>
  <div id="assent">  
   <div id="terms">
   <?php echo nl2br($row_post_agree['post_content']); ?>
    </div>   
  </div><?php } ?>
<div id="main3" align="center">
      <?php if(empty($_SESSION["MM_Username"])){//如果未驗證到會員登入的Session變數MM_Username，顯示本區塊 ?>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="memberadd" id="memberadd" onSubmit="return Validator.Validate(this,2)"> <?php if($_GET["requsername"]!=""){ ?>
    <table width="540" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" bgcolor="#FF0000" class="font_white">帳號或電子郵件已經註冊過了!!</td>
        </tr>
      </table> <?php }?>
      <table width="540" border="0" cellspacing="0" cellpadding="0" background="images/back11_2.gif">
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">&nbsp; <span class="font_black">歡迎您填妥資料，加入成為網站會員~~</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add"><label>
            <input type="text" name="uname" id="uname" value="<?php if($error=1){echo $_POST['uname'];} ?>" /><!--dataType="Chinese" msg="姓名只允許中文"-->
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">帳號：</td>
          <td align="left" class="board_add"><label>
            <input type="text" name="username" id="username" onblur="chkUserID(this)" value="<?php if($error=1){echo $_POST['username'];}?>" />
          </label><span class="font_red">* </span><span id="idErrMsg"> </span>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">密碼：</td>
          <td align="left" class="board_add"><label>
            <input name="password" type="password" id="password" size="15" value="<?php if($error=1){echo $_POST['password'];}?>" />
         * </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">確認密碼：</td>
          <td align="left" class="board_add"><label>
            <input name="repassword" type="password" id="repassword" size="15"  datatype="Repeat" to="password"  msg="確認密碼不一致"
	    value="<?php if($error=1){echo $_POST['repassword'];}?>"
	    />
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add"><label>
            <input name="email" type="text" id="email" size="35" value="<?php if($error=1){echo $_POST['email'];}?>" onblur="chkUserMail(this)" dataType="Email" msg="信箱格式不正確"/> 
          </label><span class="font_red">*</span><span id="emailErrMsg"> </span><br />
          <span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到註冊信及訂閱之會員電子報。</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">學歷：</td>
          <td align="left" class="board_add"><p>
            <label>
              <input name="edu" type="radio" id="edu_0" value="國小" checked="checked" />
              國小</label>
            
            <label>
              <input type="radio" name="edu" value="國中" id="edu_1" <?php if($error=1 && $_POST['edu']=='國中')echo 'checked="checked"'; ?>/>
              國中</label>
            
            <label>
              <input type="radio" name="edu" value="高中職" id="edu_2" <?php if($error=1 && $_POST['edu']=='高中職')echo 'checked="checked"'; ?> />
              高中職</label>
            
            <label>
              <input type="radio" name="edu" value="專科" id="edu_3" <?php if($error=1 && $_POST['edu']=='專科')echo 'checked="checked"'; ?> />
              專科</label>
            
            <label>
              <input type="radio" name="edu" value="大學" id="edu_4" <?php if($error=1 && $_POST['edu']=='大學')echo 'checked="checked"'; ?> />
              大學</label>
            
            <label>
              <input type="radio" name="edu" value="碩士" id="edu_5" <?php if($error=1 && $_POST['edu']=='碩士')echo 'checked="checked"'; ?> />
              碩士</label>
            
            <label>
              <input type="radio" name="edu" value="博士" id="edu_6"  <?php if($error=1 && $_POST['edu']=='博士')echo 'checked="checked"'; ?> />
              博士</label>
            
          </p></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">公司：</td>
          <td align="left" class="board_add"><label for="company"></label>
          <input type="text" name="company" id="company" value="<?php if($error=1){echo $_POST['company'];}?>" /></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add"><label>
            <input name="sex" type="radio" id="radio" value="M" checked="checked" />
          男</label>
        <label>  <input type="radio" name="sex" id="radio2" value="F" <?php if($error=1 && $_POST['sex']=='F')echo 'checked="checked"'; ?>/>
          女&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label></td>
        </tr>
        <tr>
        <tr>
          <td height="30" align="right" class="board_add">手機：</td>
          <td align="left" class="board_add"><label for="mobile"></label>
          <input type="text" name="mobile" id="mobile" dataType="Phone" value="<?php if($error=1){echo $_POST['mobile'];}?>"  msg="手機號碼不正確"/><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">電話：</td>
          <td align="left" class="board_add">
            <input type="text" name="phone" id="phone" dataType="Phone" value="<?php if($error=1){echo $_POST['phone'];}?>"  msg="電話號碼不正確"/>
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">郵遞區號：</td>
          <td align="left" class="board_add">
          <select onchange="citychange(this.form)" name="Area">
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
          <select onchange="areachange(this.form)" name="cityarea">

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
          </select>
                           <input type="hidden" value="100" name="Mcode" />
                           <input name="cuszip" value="100" size="5" maxlength="5" readonly="readOnly" />
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">完整地址：</td>
          <td align="left" class="board_add"><span class="bs">
            <input name="cusadr" type="text" id="cusadr" value="<?php if($error=1){echo $_POST['cusadr'];}?>" size="60" />
            <!--dataType="LimitB" min="10" max="40"  msg=" 地址必須在10到40個字之內"-->
          <span class="font_red">*</span><span id="emailErrMsg2"></span></span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">驗證碼：</td>
          <td align="left" class="board_add">
          <label>
            <input name="captcha" type="text" id="captcha" size="10"  datatype="Repeat" to="recaptcha" msg="驗證碼不一致"/>
          </label>
          &nbsp;
          <?php $captcha = new CaptchaImage(150,50,5,'3366CC','FFFFFF','000000');?>
          <input name="recaptcha" type="hidden" id="recaptcha" value="<?php echo $_SESSION['captcha_code']?>" /></td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <input type="submit" name="button" id="button" value="送出資料" /></label>
            <input type="reset" name="button2" id="button2" value="重設" />
            <input name="date" type="hidden" id="date" value="<?php echo date("Y-m-d H:i:s");?>" />
          </td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="memberadd" />
  </form>
    <?php }else{//否則顯示另依個區塊內容?>
    <div align="center"><img src="images/memberAdderr.gif"></div>
	<?php }?>
</div>
<?php include("cx_footer.php"); ?></div>

</body>
</html>
<script>
 Validator = {

 Require : /.+/,

 Email :/.+/,

 Phone :  /^[0-9]\d{7,11}$/,

 Mobile : /^((\(\d{3}\))|(\d{3}\-))?13\d{9}$/,

 Url : /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/,

 IdCard : /^\d{15}(\d{2}[A-Za-z0-9])?$/,

 Currency : /^\d+(\.\d+)?$/,

 Number : /^\d+$/,

 Zip : /^[1-9]\d{5}$/,

 QQ : /^[1-9]\d{4,8}$/,

 Integer : /^[-\+]?\d+$/,

 Double : /^[-\+]?\d+(\.\d+)?$/,

 English : /^[A-Za-z]+$/,

 Chinese :  /^[\u0391-\uFFE5]+$/,

 UnSafe : /^(([A-Z]*|[a-z]*|\d*|[-_\~!@#\$%\^&\*\.\(\)\[\]\{\}<>\?\\\/\'\"]*)|.{0,5})$|\s/,

 IsSafe : function(str){return !this.UnSafe.test(str);},

 SafeString : "this.IsSafe(value)",

 Limit : "this.limit(value.length,getAttribute('min'),  getAttribute('max'))",

 LimitB : "this.limit(this.LenB(value), getAttribute('min'), getAttribute('max'))",

 Date : "this.IsDate(value, getAttribute('min'), getAttribute('format'))",

 Repeat : "value == document.getElementsByName(getAttribute('to'))[0].value",

 Range : "getAttribute('min') < value && value < getAttribute('max')",

 Compare : "this.compare(value,getAttribute('operator'),getAttribute('to'))",

 Custom : "this.Exec(value, getAttribute('regexp'))",

 Group : "this.MustChecked(getAttribute('name'), getAttribute('min'), getAttribute('max'))",

 ErrorItem : [document.forms[0]],

 ErrorMessage : ["資料輸入錯誤：\t\t\t\t"],

 Validate : function(theForm, mode){

  var obj = theForm || event.srcElement;

  var count = obj.elements.length;

  this.ErrorMessage.length = 1;

  this.ErrorItem.length = 1;

  this.ErrorItem[0] = obj;

  for(var i=0;i<count;i++){

   with(obj.elements[i]){

    var _dataType = getAttribute("dataType");

    if(typeof(_dataType) == "object" || typeof(this[_dataType]) == "undefined")  continue;

    this.ClearState(obj.elements[i]);

    if(getAttribute("require") == "false" && value == "") continue;

    switch(_dataType){

     case "Date" :

     case "Repeat" :

     case "Range" :

     case "Compare" :

     case "Custom" :

     case "Group" : 

     case "Limit" :

     case "LimitB" :

     case "SafeString" :

      if(!eval(this[_dataType])) {

       this.AddError(i, getAttribute("msg"));

      }

      break;

     default :

      if(!this[_dataType].test(value)){

       this.AddError(i, getAttribute("msg"));

      }

      break;

    }

   }

  }

  if(this.ErrorMessage.length > 1){

   mode = mode || 1;

   var errCount = this.ErrorItem.length;

   switch(mode){

   case 2 :

    for(var i=1;i<errCount;i++)

     this.ErrorItem[i].style.color = "red";

   case 1 :

    alert(this.ErrorMessage.join("\n"));

    this.ErrorItem[1].focus();

    break;

   case 3 :

    for(var i=1;i<errCount;i++){

    try{

     var span = document.createElement("SPAN");

     span.id = "__ErrorMessagePanel";

     span.style.color = "red";

     this.ErrorItem[i].parentNode.appendChild(span);

     span.innerHTML = this.ErrorMessage[i].replace(/\d+:/,"*");

     }

     catch(e){alert(e.description);}

    }

    this.ErrorItem[1].focus();

    break;

   default :

    alert(this.ErrorMessage.join("\n"));

    break;

   }

   return false;

  }

  return true;

 },

 limit : function(len,min, max){

  min = min || 0;

  max = max || Number.MAX_VALUE;

  return min <= len && len <= max;

 },

 LenB : function(str){

  return str.replace(/[^\x00-\xff]/g,"**").length;

 },

 ClearState : function(elem){

  with(elem){

   if(style.color == "blue")

    style.color = "";

   var lastNode = parentNode.childNodes[parentNode.childNodes.length-1];

   if(lastNode.id == "__ErrorMessagePanel")

    parentNode.removeChild(lastNode);

  }

 },

 AddError : function(index, str){


  this.ErrorItem[this.ErrorItem.length] = this.ErrorItem[0].elements[index];

  this.ErrorMessage[this.ErrorMessage.length] = this.ErrorMessage.length + ":" + str;

 },

 Exec : function(op, reg){

  return new RegExp(reg,"g").test(op);

 },

 compare : function(op1,operator,op2){

  switch (operator) {

   case "NotEqual":

    return (op1 != op2);

   case "GreaterThan":

    return (op1 > op2);

   case "GreaterThanEqual":

    return (op1 >= op2);

   case "LessThan":

    return (op1 < op2);

   case "LessThanEqual":

    return (op1 <= op2);

   default:

    return (op1 == op2);            

  }

 },

 MustChecked : function(name, min, max){

  var groups = document.getElementsByName(name);

  var hasChecked = 0;

  min = min || 1;

  max = max || groups.length;

  for(var i=groups.length-1;i>=0;i--)

   if(groups[i].checked) hasChecked++;

  return min <= hasChecked && hasChecked <= max;

 },

 IsDate : function(op, formatString){

  formatString = formatString || "ymd";

  var m, year, month, day;

  switch(formatString){

   case "ymd" :

    m = op.match(new RegExp("^\\s*((\\d{4})|(\\d{2}))([-./])(\\d{1,2})\\4(\\d{1,2})\\s*$"));

    if(m == null ) return false;

    day = m[6];

    month = m[5]--;

    year =  (m[2].length == 4) ? m[2] : GetFullYear(parseInt(m[3], 10));

    break;

   case "dmy" :

    m = op.match(new RegExp("^\\s*(\\d{1,2})([-./])(\\d{1,2})\\2((\\d{4})|(\\d{2}))\\s*$"));

    if(m == null ) return false;

    day = m[1];

    month = m[3]--;

    year = (m[5].length == 4) ? m[5] : GetFullYear(parseInt(m[6], 10));

    break;

   default :

    break;

  }

  var date = new Date(year, month, day);

        return (typeof(date) == "object" && year == date.getFullYear() && month == date.getMonth() && day == date.getDate());

  function GetFullYear(y){return ((y<30 ? "20" : "19") + y)|0;}

 }

 }

 </script>
<?php
mysql_free_result($admin_mail);

mysql_free_result($post_agree);
?>
