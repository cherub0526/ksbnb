<?php
session_start();
if(isset($_POST["uCheck"])) {
	if(($_SESSION['captcha_code'] == $_POST['uCheck']) && (!empty($_SESSION['captcha_code'])) ) {
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['uCheck'])) {
  $loginUsername=$_POST['uCheck'];
  $password=$_POST['pCheck'];
  $MM_fldUserAuthorization = "level";
  $MM_redirectLoginSuccess = "loginCount.php";
  $MM_redirectLoginFailed = "login.php?loginerror=1";
  $MM_redirecttoReferrer = true;
//  if(!isset($sum)){$sum=1;}
  mysql_select_db($database_ksnews3, $ksnews3);
  	
  //$LoginRS__query=sprintf("SELECT user, pass, level ,errorcount FROM users WHERE user=%s AND pass=%s",
 // GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
 
   $LoginRS__query=sprintf("SELECT user, pass, level FROM users WHERE user=%s AND pass=%s AND level_group='vender'",
   GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $ksnews3) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $loginFoundrow=mysql_fetch_assoc($LoginRS);
  //if ($loginFoundUser && $loginFoundrow['errorcount']<5) {
    if ($loginFoundUser) {
	
	
    $loginStrGroup  = mysql_result($LoginRS,0,'level');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
 }
  else {
  
  /*
   mysql_select_db($database_ksnews3, $ksnews3);
  
  $sql_check="select * from users where user='".mysql_real_escape_string($_POST['uCheck'])."'";
  $rec_check=mysql_query($sql_check,$ksnews3);
  $row_check=mysql_fetch_assoc($rec_check);
  
  
  if($row_check['errorcount']<5){
   $sql_error="update users set errorcount='".$sum."' where user='".mysql_real_escape_string($_POST['uCheck'])."'";
    $rec_error($sql_error,$ksnews3);
	echo $sql_error;
	$sum++;
	echo $LoginRS__query;
	}
	
	if($row_check['errorcount']>=5){
	echo "<script>alert('帳號凍結中');window.location.href='index.php';</script>";
	
	}
	*/
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<? $originUrl=$_SERVER["HTTP_REFERER"];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更生房仲網_會員登入</title>
<link rel="shortcut icon" href="images/ks_logo.ico"> 
<link href="web.css" rel="stylesheet" type="text/css" />
<style type="text/css">
a{text-decoration:none;}
#main {
	height: auto;
	width: 990px;
	margin-right: auto;
	margin-left: auto;
}
#login {
	float: left;
	height: 400px;
	width: 990px;
}
</style>
<script type="text/javascript">
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.66
//copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+myErr)}
  document.MM_returnValue = (myErr=='');
}
</script>
</head>

<body>
<div id="main">
<?php require("header.php"); ?>
<div id="login"><form ACTION="<?php echo $loginFormAction; ?>" method="POST" name="memberLogin" id="memberLogin" onsubmit="YY_checkform('memberLogin','captcha','#recaptcha','6','圖片驗證錯誤');return document.MM_returnValue">
<table width="990" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="140">
    </td>
    <td width="95" align="center">&nbsp;</td>
    <td width="217">&nbsp;</td>
    <td width="473">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center"> <? if($_GET['loginerror']!=""){?>
      帳號或密碼錯誤，請重新登入!!
      <? }?></td>
    <td align="center">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">帳　　號：</td>
    <td><input name="uCheck" type="text" class="inputstyle1" id="uCheck" value="<?php if(isset($_COOKIE['rmUsername']))echo $_COOKIE['rmUsername'];?>" /></td>
    <td rowspan="2"><label>
              <input type="image" name="imageField" id="imageField" src="images/memberzonebtn3.gif" />
            </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">登入密碼：</td>
    <td><input name="pCheck" type="password" class="inputstyle1" id="pCheck" value="<?php if(isset($_COOKIE['rmPassword']))echo $_COOKIE['rmPassword'];?>" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">圖片驗證：</td>
    <td colspan="2" rowspan="2"><?php $captcha = new CaptchaImage(150,50,5,'CCCCCC','0033FF','00FFFF');?>
      <input name="captcha" type="text" id="captcha" value="" size="10" />
      <span style="font-size: 12px">英文分大小寫</span>
      <input name="recaptcha" type="hidden" id="recaptcha" value="<? echo $_SESSION['captcha_code']?>" /><input type="button" value="驗證碼重新產生" onclick="self.location.href='login.php'"/></td>
    </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td align="center" valign="middle"></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"></td>
    <td><input name="remember" type="checkbox" id="remember" value="1" checked="checked" />記住我的帳號密碼</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><label>忘記密碼:</label></td>
    <td colspan="2">如果您忘記了登入密碼, 請按<a href="memberLostPass.php" class="font_red2">這裡重新設定密碼</a></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><a href="venderAdd.php">廠商會員註冊</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="19">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table></form>

</div>
<?php require("cx_footer.php"); ?>
</div>
</body>
</html>