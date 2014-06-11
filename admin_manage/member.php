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
mysql_select_db($database_ksnews3, $ksnews3);
$query_admin_mail = "SELECT mail FROM admin_email WHERE mail_id = 7";
$admin_mail = mysql_query($query_admin_mail, $ksnews3) or die(mysql_error());
$row_admin_mail = mysql_fetch_assoc($admin_mail);
$totalRows_admin_mail = mysql_num_rows($admin_mail);


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO users (user, pass ,level, level_group, join_date  ,join_time , verify) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['pass'], "text"),
					   GetSQLValueString("3", "int"),
                       GetSQLValueString("admin", "text"),
                       GetSQLValueString(date("Y-m-d"), "date"),
					   GetSQLValueString(date("Y-m-d H:i:s"), "date"),                      
					   GetSQLValueString("0", "int"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL, $ksnews3) or die(mysql_error());
  
  $insertSQL_user_info=sprintf("INSERT INTO user_info(name,tel,mobile,company,email,edu,sex,note,expire,times,addr,cuszip,cityarea,Area) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s , %s)",
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
						GetSQLValueString($_POST['Area'], "text"));
						
	mysql_select_db($database_ksnews3, $ksnews3);
 	$Result1 = mysql_query($insertSQL_user_info, $ksnews3) or die(mysql_error());
	
	 $group_priority_level="SELECT * FROM group_allow WHERE `group`='admin' ORDER BY sub_group ASC LIMIT 0,1";	
	 $rec_priority_level=mysql_query($group_priority_level,$ksnews3);
	 $row_priority_level=mysql_fetch_assoc($rec_priority_level);
	 
	 $insertSQL_user_priority=sprintf("INSERT INTO priority(user,`group` ,sub_group ,name,allow) VALUES (%s, %s, %s, %s, %s)",
								GetSQLValueString($_POST['user'], "text"),
								GetSQLValueString('admin', "text"),
								GetSQLValueString($row_priority_level['sub_group'], "text"),
								GetSQLValueString($_POST['uname'], "text"),
								GetSQLValueString($row_priority_level['allow'], "text")); 
	  mysql_select_db($database_ksnews3, $ksnews3);
	  $Result1 = mysql_query($insertSQL_user_priority, $ksnews3); //or die(mysql_error());
	  
  //加入會員成功後，寄發會員信
  mb_internal_encoding('UTF-8');//指定發信使用UTF-8編碼，防止信件標題亂碼
  $servicemail=$row_admin_mail['mail'];//指定網站管理員服務信箱，請修改為自己的有效mail
  $webname="更生民宿網";//寫入網站名稱
  $email=$_POST['email'];//上一頁傳來的會員email
  $subject=$_POST['uname']."您好，歡迎您加入".$webname;//信件標題
  $subject=mb_encode_mimeheader($subject, 'UTF-8');//指定標題將雙位元文字編碼為單位元字串，避免亂碼
  //指定信件內容
  $body="親愛的會員".$_POST['uname']."您好，歡迎您加入更生民宿網網站成為會員，以下是您的會員資料:<br />
         您的帳號是".$_POST['user']."<br />您的密碼是".$_POST['pass']."<br />
         請妥善保存您的資料，如有任何問題歡迎與我們聯絡，謝謝!!any problem，you can touch us，thank you!!";
  //郵件檔頭設定
  $headers = "MIME-Version: 1.0\r\n";//指定MIME(多用途網際網路郵件延伸標準)版本
  $headers .= "Content-type: text/html; charset=utf-8\r\n";//指定郵件類型為HTML格式
  $headers .= "From:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail."> \r\n";//指定寄件者資訊
  $headers .= "Reply-To:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//指定信件回覆位置
  $headers .= "Return-Path:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//被退信時送回位置
  //使用mail函數寄發信件
  mail ($email,$subject,$body,$headers);
//加入會員成功後，寄發會員信結束	  

  $insertGoTo = "member_detail.php";
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理者新增</title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#content {
	background-color: #F3F3F3;
	float: left;
	width: 835px;
}
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<script type="text/javascript" src="js/address.js"></script>

<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="content">
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="22" background="../images/board10.gif">&nbsp;</td>
      <td width="101" background="../images/board04.gif" align="left" style="font-size:0.8em">管理者新增</td>
      <td width="703" background="../images/board04.gif">&nbsp;</td>
      <td width="10" background="../images/board05.gif">&nbsp;</td>
    </tr>
  </table>
</div>
<div id="content" class="cx_admin_table">
  <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    <table width="835" border="0" cellpadding="1">
      <tr>
        <td width="115">新增 管理者 帳號</td>
        <td width="710">&nbsp;</td>
      </tr>
      <tr>
          <td width="115" height="22">姓名：</td>
          <td width="710" align="left" class="board_add"><span id="sprytextfield3">
            <label>
              <input type="text" name="uname" id="uname" />
            </label>
            <span class="textfieldRequiredMsg">請輸入姓名。</span></span><span style="color:#F00">* 
          
          </span></td>
        </tr>
      <tr>
        <td>管理者帳號</td>
        <td><span id="sprytextfield1">
        <input type="text" name="user" id="user"/>
        <span class="textfieldRequiredMsg">請輸入帳號。</span><span class="textfieldMinCharsMsg">未達到字元數目的最小值。</span><span class="textfieldMaxCharsMsg">已超出字元數目的最大值。</span></span><span style="color:#F00"> *至少需要到達六個字元 </span></td>
      </tr>
      <tr>
        <td>管理者密碼</td>
        <td><span id="sprypassword1">
        <input type="password" name="pass" id="pass"/>
        <span class="passwordRequiredMsg">請輸入密碼。</span><span class="passwordMinCharsMsg">未達到字元數目的最小值。</span><span class="passwordMaxCharsMsg">已超出字元數目的最大值。</span><span class="passwordInvalidStrengthMsg">密碼未達到指定的強度。</span></span><span style="color:#F00"> *包含一個字母與數字，最少六個字元</span></td>
      </tr>
      <tr>
        <td>確認輸入密碼</td>
        <td><span id="spryconfirm1">
          <input type="password" name="pass1" id="pass1" />
          <span class="confirmRequiredMsg">請輸入密碼。</span><span class="confirmInvalidMsg">密碼不相符。</span></span></td>
      </tr>
      <tr>
        <td>管理者 E-mail</td>
        <td><span id="sprytextfield2">
        <input type="text" name="email" id="email" />
        <span class="textfieldRequiredMsg">請輸入 E-mail。</span><span class="textfieldInvalidFormatMsg">錯誤的格式。</span></span><br /><span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到註冊信及訂閱之會員電子報。</span></td>
      </tr>
        <tr>
          <td height="30" class="board_add">學歷：</td>
          <td align="left" class="board_add"><p>
            <span id="spryradio1">
            <label>
              <input type="radio" name="edu" value="國小" id="edu_7" />
              國小</label>

            <label>
              <input type="radio" name="edu" value="國中" id="edu_8" />
              國中</label>

            <label>
              <input type="radio" name="edu" value="高中職" id="edu_9" />
              高中職</label>

            <label>
              <input type="radio" name="edu" value="專科" id="edu_10" />
              專科</label>

            <label>
              <input type="radio" name="edu" value="大學" id="edu_11" />
              大學</label>

            <label>
              <input type="radio" name="edu" value="碩士" id="edu_12" />
              碩士</label>

            <label>
              <input type="radio" name="edu" value="博士" id="edu_13" />
              博士</label>

          <span class="radioRequiredMsg">請進行選取。</span></span><span style="color:#F00">* </span></p></td>
        </tr>
        <tr>
          <td height="30" class="board_add">公司：</td>
          <td align="left" class="board_add"><label for="company"></label>
            <span id="sprytextfield4">
            <input name="company" type="text" id="company" />
          <span class="textfieldRequiredMsg">請輸入公司名稱。</span></span><span style="color:#F00">* </span></td>
        </tr>
        <tr>
          <td height="30" class="board_add">性別：</td>
          <td align="left" class="board_add"><label>
            <input name="sex" type="radio" id="radio" value="M" checked="checked" />
          男</label>
         <label> <input type="radio" name="sex" id="radio2" value="F" <?php if($error=1 && $_POST['sex']=='F')echo 'checked="checked"'; ?> />
          女&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label></td>
        </tr>
        <tr>
          <td height="30" class="board_add">手機：</td>
          <td align="left" class="board_add"><label for="mobile"></label>
            <span id="sprytextfield5">
            <input type="text" name="mobile" id="mobile" />
          <span class="textfieldRequiredMsg">請輸入手機號碼。</span><span class="textfieldInvalidFormatMsg">錯誤的格式。</span></span><span style="color:#F00">* </span></td>
        </tr>
        <tr>
          <td height="30" class="board_add">電話：</td>
          <td align="left" class="board_add"><span id="sprytextfield6">
          <label onfocus="YY_checkform('memberadd','email','S','2','請檢查email欄位');YY_checkform('memberadd','captcha','recaptcha','6','請檢查圖形驗證碼欄位');return document.MM_returnValue">
            <input type="text" name="phone" id="phone" />
          </label>
          <span class="textfieldRequiredMsg">請輸入家用號碼。</span><span class="textfieldInvalidFormatMsg">錯誤的格式。</span></span></td>
        </tr>
        <tr>
          <td height="30" class="board_add">郵遞區號：</td>
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
                           <input type="hidden" value="100" name="Mcode" />
                           <input name="cuszip" value="100" size="5" maxlength="5" readonly="readOnly" />
          </td>
        </tr>
        <tr>
          <td height="30" class="board_add">完整地址：</td>
          <td align="left" class="board_add"><span class="bs"><span id="sprytextfield7">
            <input name="cusadr" type="text" id="cusadr" size="60" />
          <span class="textfieldRequiredMsg">需要有一個值。</span></span><span style="color:#F00">*</span><span id="emailErrMsg2"></span></span></td>
        </tr>
    </table>
    <p align="center">
    <input type="submit" name="button" id="button" value="新增">
      <input type="reset" name="button2" id="button2" value="重設">
    <input type="button" onclick="window.history.back();" value="回上一頁"/></p>
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"], minChars:6, maxChars:12});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:6, maxChars:12, validateOn:["blur"], minAlphaChars:1, minNumbers:1});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "pass1", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {validateOn:["blur"]});
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "phone_number", {format:"phone_custom", validateOn:["blur"], pattern:"0000-000000", useCharacterMasking:true});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "phone_number", {format:"phone_custom", pattern:"00-0000000", useCharacterMasking:true});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
</script>
</body>
</html>