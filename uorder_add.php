<?php require_once('Connections/ksnews3.php'); ?>
<?
session_start(); //啟動session功能
header("Cache-control:private");//解決session 引起的回上一頁表單被清空

?>
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
<?

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$uorday=$_POST["year"]."-".$_POST["month"]."-".$_POST["day"];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO uorder (type, date, name, tel, mobile, fax, mail, addr, note, u_type) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['order_type'], "int"),
                       GetSQLValueString($uorday, "date"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['mobile'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['cusadr'], "text"),
                       GetSQLValueString($_POST['post_content'], "text"),				                      
					   GetSQLValueString($_POST['u_type'], "text")
					   );

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL, $ksnews3) or die(mysql_error());

  $insertGoTo = "complete_order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  

  //將訊息發信給管理者
/*  mb_internal_encoding('UTF-8');//指定發信使用UTF-8編碼，防止信件標題亂碼
  $servicemail=$_POST['admin_mail'];
  //指定網站管理員服務信箱  更生:keng-shen5@umail.hinet.net
  $webname="更生新聞_線上訂報系統";//寫入網站名稱
  $email=$_POST['admin_mail'];//上一頁中會員輸入的信箱
  $subject=$webname."更生新聞_線上訂報系統";//信件標題
  $subject=mb_encode_mimeheader($subject, 'UTF-8');//指定標題將雙位元文字編碼為單位元字串，避免亂碼
  //指定信件內容
  $body="親愛的管理者，有用戶新增加一筆線上訂報資訊:\n<br />
         用戶姓名:".$_POST['uname']."\n<br />
         訂報日期:".$uorday."\n<br />
		 訂報地點:".$_POST['cusadr']."\n<br />
		 連絡電話:".$_POST['phone']."\n<br />
		 ";
  //郵件檔頭設定
  $headers = "MIME-Version: 1.0\r\n";//指定MIME(多用途網際網路郵件延伸標準)版本
  $headers .= "Content-type: text/html; charset=utf-8\r\n";//指定郵件類型為HTML格式
  $headers .= "From:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail."> \r\n";//指定寄件者資訊
  $headers .= "Reply-To:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//指定信件回覆位置
  $headers .= "Return-Path:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//被退信時送回位置
  //使用mail函數寄發信件
  mail ($email,$subject,$body,$headers);
  //將新密碼發信給使用者結束
                           ↓？         */                 
require("PHPMailer/class.phpmailer.php");
 mb_internal_encoding('UTF-8');   
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true; // turn on SMTP authentication
//這幾行是必須的
$mail->CharSet = "utf-8";
$mail->Encoding = "base64";
$mail->Username = "silence211080@gmail.com";
$mail->Password = "95407023";
//這邊是你的gmail帳號和密碼

$mail->FromName = "更生新聞_線上訂報系統";
// 寄件者名稱(你自己要顯示的名稱)
$webmaster_email = "silence211080@gmail.com";
//回覆信件至此信箱


$email=$row_admin_mail['mail'];
// 收件者信箱$_POST['admin_mail'];
$name="更生新聞_線上訂報系統";
// 收件者的名稱or暱稱
$mail->From = $webmaster_email;


$mail->AddAddress($email,$name);
$mail->AddReplyTo($webmaster_email,"Squall.f");
//這不用改

$mail->WordWrap = 50;
//每50行斷一次行

//$mail->AddAttachment("/XXX.rar");
// 附加檔案可以用這種語法(記得把上一行的//去掉)

$mail->IsHTML(true); // send as HTML

//$mail->Subject = mb_encode_mimeheader($webname, 'UTF-8')."信件標題";


$mail->Subject = "更生新聞_線上訂報系統";
// 信件標題
$mail->Body = "親愛的管理者，有用戶新增加一筆線上訂報資訊:\n<br />
         用戶姓名:".$_POST['uname']."\n<br />
         訂報日期:".$uorday."\n<br />
		 訂報地點:".$_POST['cusadr']."\n<br />
		 連絡電話:".$_POST['phone']."\n<br />";
//信件內容(純文字版)

if(!$mail->Send()){
echo "寄信發生錯誤：" . $mail->ErrorInfo;
//如果有錯誤會印出原因
}
else{
echo "寄信成功";
} 
   $_SESSION['uname']=$_POST['uname'];
  $_SESSION['cusadr']=$_POST['cusadr'];
  $_SESSION['phone']=$_POST['phone'];
  //$_SESSION['action_datedow']=$_POST['action_datedow'];
  $_SESSION['uorday']=$uorday;
  header(sprintf("Location: %s", $insertGoTo));
}

?>
<?php
mysql_select_db($database_ksnews3, $ksnews3);
$query_order_type = "SELECT * FROM order_type";
$order_type = mysql_query($query_order_type, $ksnews3) or die(mysql_error());
$row_order_type = mysql_fetch_assoc($order_type);
$totalRows_order_type = mysql_num_rows($order_type);
?>
<?php
mysql_select_db($database_ksnews3, $ksnews3);
$query_admin_mail = "SELECT * FROM admin_email WHERE mail_id = 3";
$admin_mail = mysql_query($query_admin_mail, $ksnews3) or die(mysql_error());
$row_admin_mail = mysql_fetch_assoc($admin_mail);
$totalRows_admin_mail = mysql_num_rows($admin_mail);

$colname_Ruser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Ruser = $_SESSION['MM_Username'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_Ruser = sprintf("SELECT * FROM users WHERE `user` = %s", GetSQLValueString($colname_Ruser, "text"));
$Ruser = mysql_query($query_Ruser, $ksnews3) or die(mysql_error());
$row_Ruser = mysql_fetch_assoc($Ruser);
$totalRows_Ruser = mysql_num_rows($Ruser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更生房仲網 線上訂報系統</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<link rel="shortcut icon" href="images/ks_logo.ico"> 
<link href="web.css" rel="stylesheet" type="text/css" />
<script language=javascript src="address.js"></script><!--引入郵遞區號.js檔案-->
	<style type="text/css">
	#write {
	margin-left: 130px;
	height: auto;
	float: left;
	margin-top: 5px;
}
	</style>
</head>

<body>
<div id="main">
  <?php require("header.php"); ?> 
  <div id="write">
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1"onSubmit="return Validator.Validate(this,2)">
<table width="750" border="0.5" cellpadding="2" cellspacing="0">
        <tr>
          <td height="30" align="center" class="board_add">訂報日期</td>
          <td align="left" class="board_add"><select name="year" id="year">
             <option selected="selected"><? echo(date("Y"));?></option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=2011;y<=thisYear;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="month" id="month">
            <option><? echo(date("n"));?></option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="day" id="day">
            <option><? echo(date("j"));?></option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select>
          <input name="admin_mail" type="hidden" id="admin_mail" value="<?php echo $row_admin_mail['mail']; ?>" /></td>
        </tr>
        <tr>
          <td width="62" height="30" align="center" class="board_add">選擇方案</td>
          <td width="630" align="left" class="board_add"><label for="order_type"></label>
            <select name="order_type" id="order_type">
              <?php
do {  
?>
              <option value="<?php echo $row_order_type['seq']?>"<?php if (!(strcmp($row_order_type['seq'], $row_order_type['t_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_order_type['detail']?></option>
              <?php
} while ($row_order_type = mysql_fetch_assoc($order_type));
  $rows = mysql_num_rows($order_type);
  if($rows > 0) {
      mysql_data_seek($order_type, 0);
	  $row_order_type = mysql_fetch_assoc($order_type);
  }
?>
          </select>            <label for="title"></label></td>
        </tr>
        <tr>
          <td height="139" align="center" class="board_add">基本資料：</td>
          <td align="left" class="board_add"><table width="598" height="189" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="75" height="33" align="left">※用戶姓名：</td>
              <td width="215" align="left"><label>
            <input name="uname" type="text" id="uname" value="<?php echo $row_Ruser['name']; ?>" dataType="Chinese" msg="真實姓名只允許中文"/>
          </label></td>
              <td width="308" colspan="2" rowspan="4" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td height="26" align="left">※電話：</td>
              <td align="left"><input name="phone" type="text" id="phone" value="<?php echo $row_Ruser['tel']; ?>" dataType="Phone"  msg="電話號碼不正確"/></td>
            </tr>
            <tr>
              <td height="26" align="left">手機：</td>
              <td align="left"><label for="mobile"></label>
                <input name="mobile" type="text" id="mobile" value="<?php echo $row_Ruser['mobile']; ?>" /></td>
            </tr>
            <tr>
              <td height="26" align="left">傳真：</td>
              <td align="left"><label for="fax"></label>
                <input type="text" name="fax" id="fax" /></td>
            </tr>
            <tr>
              <td height="34" align="left">E-mail：</td>
              <td colspan="3" align="left"><label for="email"></label>
                <input name="email" type="text" id="email" value="<?php echo $row_Ruser['email']; ?>" size="35" /></td>
            </tr>
            <tr>
              <td height="44" align="left">※投報地址：</td>
<td align="left"><select onchange="citychange(this.form)" name="Area">
                              <option value="基隆市">基隆市</option>
                              <option value="臺北市" selected="selected">臺北市</option>
                              <option value="臺北縣">臺北縣</option>
                              <option value="桃園縣">桃園縣</option>
                              <option value="新竹市">新竹市</option>
                              <option value="新竹縣">新竹縣</option>
                              <option value="苗栗縣">苗栗縣</option>
                              <option value="臺中市">臺中市</option>
                              <option value="臺中縣">臺中縣</option>
                              <option value="彰化縣">彰化縣</option>
                              <option value="南投縣">南投縣</option>
                              <option value="雲林縣">雲林縣</option>
                              <option value="嘉義縣">嘉義縣</option>
                              <option value="臺南市">臺南市</option>
                              <option value="臺南縣">臺南縣</option>
                              <option value="高雄市">高雄市</option>
                              <option value="高雄縣">高雄縣</option>
                              <option value="屏東縣">屏東縣</option>
                              <option value="臺東縣">臺東縣</option>
                              <option value="花蓮縣">花蓮縣</option>
                              <option value="宜蘭縣">宜蘭縣</option>
                              <option value="澎湖縣">澎湖縣</option>
                              <option value="金門縣">金門縣</option>
                              <option value="連江縣">連江縣</option>
                          </select>
                          <select onchange="areachange(this.form)" name="cityarea">
                                <option value="中正區" selected="selected">中正區</option>
                                <option value="大同區">大同區</option>
                                <option value="中山區">中山區</option>
                                <option value="松山區">松山區</option>
                                <option value="大安區">大安區</option>
                                <option value="萬華區">萬華區</option>
                                <option value="信義區">信義區</option>
                                <option value="士林區">士林區</option>
                                <option value="北投區">北投區</option>
                                <option value="內湖區">內湖區</option>
                                <option value="南港區">南港區</option>
                                <option value="文山區">文山區</option>
</select>
                           <input type="hidden" value="100" name="Mcode" />
                           <input name="cuszip" value="100" size="5" maxlength="5" readonly="readOnly" />
                       
              </td>
              <td colspan="2" align="left"><input name="cusadr" type="text" id="cusadr" value="<?php echo $row_Ruser['addr']; ?>" size="40"  dataType="LimitB" min="10" max="80"  msg=" 地址必須在10到40個字之內"/></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30" align="center" class="board_add"> 訂戶類別</td>
          <td align="left" class="board_add"><p>
            <label>
              <input name="u_type" type="radio" id="u_type_0" value="0" checked="checked" />
              新客戶</label>
            <label>
              <input type="radio" name="u_type" value="1" id="u_type_1" />
              老客戶</label>
          </p></td>
        </tr>
        <tr>
          <td height="30" align="center" class="board_add">備註其他：</td>
          <td align="left" class="board_add">
    <label for="post_content"></label>
    <textarea name="post_content" cols="80" rows="10" id="post_content" ></textarea>
 </td>
    </tr>
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <input type="submit" name="button" id="button" value="送出資料" />
            <input type="reset" name="button2" id="button2" value="重設" />
          </label></td>
        </tr>
    </table>
<input type="hidden" name="MM_insert" value="form1" />

</form>
  </div><?php include("cx_footer.php"); ?>
</div>

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
mysql_free_result($order_type);

mysql_free_result($admin_mail);

mysql_free_result($Ruser);
?>
