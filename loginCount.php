<?php require_once('Connections/ksnews3.php'); ?>
<?php
@session_start();

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
<?php require_once('Connections/ksnews3.php'); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO user_count ( in_time, user_id, user_ip) VALUES ( %s, %s, %s)",
                       
					   GetSQLValueString($_POST['in_time'], "text"),
                       GetSQLValueString($_POST['user_id'], "text"),
                       GetSQLValueString($_POST['user_ip'], "text"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $sqlstr="select * from users left join priority on users.user=priority.user where users.user = '" . $_SESSION["MM_Username"]."'";
	   
   $row=mysql_fetch_assoc($res);  
   $num=mysql_num_rows($res);
   if($row['level_group']=='admin'){
	   $_SESSION['level']=$row['level'];
	   $_SESSION['allow']=$row['allow'];
	   $_SESSION['group']=$row['level_group'];
	   $_SESSION['username']=$_SESSION["MM_Username"];
	   
	   echo  $_SESSION['level'].'<br />';
	   echo  $_SESSION['allow'].'<br />';
	   echo  $_SESSION['group'].'<br />';
	   echo  $_SESSION['username'].'<br />';
   }
	   
   	   if($row['level_group']=='vender'){
	   $_SESSION['level']=$row['level'];
	   $_SESSION['allow']=$row['allow'];
	   $_SESSION['group']=$row['level_group'];
	   $_SESSION['username']=$_SESSION["MM_Username"];
	   $_SESSION['v_sid']=$row['v_id'];
	   
	   echo  $_SESSION['level'].'<br />';
	   echo  $_SESSION['allow'].'<br />';
	   echo  $_SESSION['group'].'<br />';
	   echo  $_SESSION['username'].'<br />';
	   echo $_SESSION['v_sid'];
	   }
	   
   
   	   if($row['level_group']=='member'){
	   $_SESSION['level']=$row['level'];
	   $_SESSION['allow']=$row['allow'];
	   $_SESSION['group']=$row['level_group'];
	   $_SESSION['username']=$_SESSION["MM_Username"];
	  // $_SESSION['v_sid']=$row['sid'];
	   
	   echo  $_SESSION['level'].'<br />';
	   echo  $_SESSION['allow'].'<br />';
	   echo  $_SESSION['group'].'<br />';
	   echo  $_SESSION['username'].'<br />';
	   //echo $_SESSION['v_sid'];
	   }
	   
	   
	   echo $sqlstr;

  
  
   $Result1 = mysql_query($insertSQL, $ksnews3) or die(mysql_error());

  $insertGoTo = "admin_manage/admin_ksbnb.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<script language=javascript> 
//0秒後，直接送出表單form1 
setTimeout("document.form1.submit()",0); 
</script>

<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <input name="in_time" type="hidden" id="in_time" value="<? echo time();?>">
  <input name="user_id" type="hidden" id="user_id" value="<? echo($_SESSION["MM_Username"]);?>">
  <input name="user_ip" type="hidden" id="user_ip" value="<? echo $_SERVER['REMOTE_ADDR'];?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>

