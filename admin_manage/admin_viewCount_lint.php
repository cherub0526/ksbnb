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

//指定日期人數統計
if((isset($_POST['f_year']) && $_POST['f_year']!="") && (isset($_POST['f_month']) && $_POST['f_month']!="")&&(isset($_POST['f_day']) && $_POST['f_day']!=""))
{
	mysql_select_db($database_ksnews3, $ksnews3);
	$query_RecDate = sprintf("SELECT * FROM viewcount_class WHERE view_time LIKE %s",GetSQLValueString($_POST['f_year']."-".$_POST['f_month']."-".$_POST['f_day']."%","date"));
	$RecDate = mysql_query($query_RecDate, $ksnews3) or die(mysql_error());
	$row_RecDate = mysql_fetch_assoc($RecDate);
	$totalRows_RecDate = mysql_num_rows($RecDate);
	
	echo "<script>alert('".$_POST['f_year']."-".$_POST['f_month']."-".$_POST['f_day']." 當天瀏覽人數：".$totalRows_RecDate." 人')</script>";
}

//範圍人數統計
if((isset($_POST['s_year']) && $_POST['s_year']!="") && (isset($_POST['s_month']) && $_POST['s_month']!="")&&(isset($_POST['s_day']) && $_POST['s_day']!=""))
{
	$date1 = date("Y-m-d H:i:s",mktime(0,0,0,$_POST['s_month'],$_POST['s_day'],$_POST['s_year']));
	$date2 = date("Y-m-d H:i:s",mktime(23,59,59,$_POST['t_month'],$_POST['t_day'],$_POST['t_year']));
	
	mysql_select_db($database_ksnews3, $ksnews3);
	$query_RecDate = sprintf("SELECT * FROM viewcount_class WHERE view_time >= %s AND view_time <= %s",GetSQLValueString($date1,"date"),GetSQLValueString($date2,"date"));
	$RecDate = mysql_query($query_RecDate, $ksnews3) or die(mysql_error());
	$row_RecDate = mysql_fetch_assoc($RecDate);
	$totalRows_RecDate = mysql_num_rows($RecDate);
	
	echo "<script>alert('".substr($date1,0,10)."~".substr($date2,0,10)." 瀏覽人數：".$totalRows_RecDate." 人')</script>";
}


mysql_select_db($database_ksnews3, $ksnews3);
$query_RecCount = "SELECT * FROM viewcount";
$RecCount = mysql_query($query_RecCount, $ksnews3) or die(mysql_error());
$row_RecCount = mysql_fetch_assoc($RecCount);
$totalRows_RecCount = mysql_num_rows($RecCount);

mysql_select_db($database_ksnews3, $ksnews3);
$query_Recip = "SELECT * FROM viewcount GROUP BY view_ip";
$Recip = mysql_query($query_Recip, $ksnews3) or die(mysql_error());
$row_Recip = mysql_fetch_assoc($Recip);
$totalRows_Recip = mysql_num_rows($Recip);

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecLevel2 = "SELECT * FROM level2 ORDER BY level1_id,level2_id ASC";
$RecLevel2 = mysql_query($query_RecLevel2, $ksnews3) or die(mysql_error());
$row_RecLevel2 = mysql_fetch_array($RecLevel2);
$totalRows_RecLevel2 = mysql_num_rows($RecLevel2);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#content {
	background-color: #F3F3F3;
	float: left;
	width: 835px;
}
</style>
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/date.js"></script>

</head>

<body>
<div id="content">
<div id="top_nav">
<table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="21" background="../images/board10.gif">&nbsp;</td>
      <td width="100" background="../images/board04.gif" align="left" style="font-size:0.8em">瀏覽人次 統計</td>
      <td width="701" background="../images/board04.gif" style="font-size:0.8em">&nbsp;</td>
      <td width="13" background="../images/board04.gif">&nbsp;</td>
    </tr>
  </table>
</div>
<table width="835" border="0" cellspacing="0" cellpadding="0" class="cx_admin_table">
  <tr>
    <td width="98">瀏覽人數總計：<?php echo $totalRows_RecCount;?></td>
    <td width="735">總訪客數(不同IP者)：<?php echo $totalRows_Recip; ?></td>
  </tr>
  <tr>
  <?php $array = array("今日瀏覽人數："=>date("Y-m-d"),"本月瀏覽人數："=>date("Y-m")); 
  	foreach($array as $key => $value)
	{
		$date_RecToday = $value;
		mysql_select_db($database_ksnews3, $ksnews3);
		$query_RecToday = sprintf("SELECT * FROM viewcount WHERE `view_time` LIKE %s", GetSQLValueString($date_RecToday."%", "date"));
		$RecToday = mysql_query($query_RecToday, $ksnews3) or die(mysql_error());
		$row_RecToday = mysql_fetch_assoc($RecToday);
		$totalRows_RecToday = mysql_num_rows($RecToday);
		echo "<td width=\"547\">".$key.$totalRows_RecToday."</td>";
	}
  ?>
  </tr>
  <tr>
    <td>搜尋指定日期統計人數：</td>
    <td><form id="form1" name="form1" method="post" action="admin_viewCount_lint.php" target="frm">
      <select name="f_year" id="f_year">
      <?php for($i= date("Y"); $i > date("Y")-10; $i--){ ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>
      年
      <label for="f_month"></label> 
      <select name="f_month" id="f_month">
      <?php for($i=1;$i<=12;$i++) { ?>
        <option value="<?php if($i<10) echo "0";echo $i ;?>" <?php //if (!(strcmp($i, (int)date("m")))) {echo "selected=\"selected\"";} ?> ><?php if($i<10) echo "0";echo $i ;?></option>
      <?php } ?>
      </select>
      月
<label for="f_day"></label>
      <select name="f_day" id="f_day">
	  <?php for($i=1;$i<=31;$i++) { ?>
      <option value="<?php if($i<10) echo "0";echo $i ;?>"><?php if($i<10) echo "0";echo $i ;?></option>
	  <?php } ?>
      </select>
      日
<input type="submit" value="查詢" />
    </form></td>
  </tr>
  <tr>
    <td>搜尋範圍統計人數：</td>
    <td><form id="form2" name="form2" method="post" action="admin_viewCount_lint.php" target="frm">
      <select name="s_year" id="s_year">
      <?php for($i= date("Y"); $i > date("Y")-10; $i--){ ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>
      年
      <label for="t_month"></label>      
      <select name="s_month" id="s_month">
      <?php for($i=1;$i<=12;$i++) { ?>
        <option value="<?php if($i<10) echo "0";echo $i ;?>" <?php //if (!(strcmp($i, (int)date("m")))) {echo "selected=\"selected\"";} ?> ><?php if($i<10) echo "0";echo $i ;?></option>
      <?php } ?>
      </select>
      月
      <label for="t_day"></label>
      <select name="s_day" id="s_day">
      <?php for($i=1;$i<=31;$i++) { ?>
      <option value="<?php if($i<10) echo "0";echo $i ;?>"><?php if($i<10) echo "0";echo $i ;?></option>
	  <?php } ?>
      </select>
      日 ~ 
      <select name="t_year" id="t_year">
      <?php for($i= date("Y"); $i > date("Y")-10; $i--){ ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>      
      年
      <label for="t_month"></label>      
      <select name="t_month" id="t_month">
      <?php for($i=1;$i<=12;$i++) { ?>
        <option value="<?php if($i<10) echo "0";echo $i ;?>" <?php //if (!(strcmp($i, (int)date("m")))) {echo "selected=\"selected\"";} ?> ><?php if($i<10) echo "0";echo $i ;?></option>
      <?php } ?>
      </select>
	  月
	  <label for="t_day"></label>
      <select name="t_day" id="t_day">
      <?php for($i=1;$i<=31;$i++) { ?>
      <option value="<?php if($i<10) echo "0";echo $i ;?>"><?php if($i<10) echo "0";echo $i ;?></option>
	  <?php } ?>
      </select>
      日
      <input type="submit" value="查詢" />
    </form></td>
  </tr>
</table>
<table width="835" border="0" cellspacing="0" cellpadding="0" class="cx_admin_table" style="text-align:center">
  <tr>
  	<td width="254"></td>
    <td width="127">上上月</td>
    <td width="112">上月</td>
    <td width="120">本月</td>
  </tr>
  <tr>
    <td width="254">&nbsp;</td>
  </tr>
    <?php
	$date1 = date("Y-m", strtotime('-2 month'))."-01";
	$date2 = date("Y-m", strtotime('-1 month'))."-01";
	do
	{
		$level2_name = $row_RecLevel2[3]; // level2_name
		echo "<tr><td width=\"254\">".$row_RecLevel2[3]."</td>";
		
		//上上月統計
		mysql_select_db($database_ksnews3,$ksnews3);
		$query_search = sprintf("SELECT * FROM hits_count WHERE t_level = %s AND t_date = %s",GetSQLValueString($row_RecLevel2[0],"int"),GetSQLValueString($date1,"date"));
		$result_search = mysql_query($query_search,$ksnews3);
		$row_search = mysql_fetch_assoc($result_search);
		//$num_search = mysql_num_rows($result_search);
		
		echo "<td>".$row_search['t_times']."</td>";
		
		//上月統計
		mysql_select_db($database_ksnews3,$ksnews3);
		$query_search = sprintf("SELECT * FROM hits_count WHERE t_level = %s AND t_date = %s",GetSQLValueString($row_RecLevel2[0],"int"),GetSQLValueString($date2,"date"));
		$result_search = mysql_query($query_search,$ksnews3);
		$row_search = mysql_fetch_assoc($result_search);
		//$num_search = mysql_num_rows($result_search);
		
		echo "<td>".$row_search['t_times']."</td>";
		
		//本月統計
		mysql_select_db($database_ksnews3,$ksnews3);
		$query_search = sprintf("SELECT * FROM hits_count WHERE t_level = %s AND t_date = %s",GetSQLValueString($row_RecLevel2[0],"int"),GetSQLValueString(date("Y-m")."-01","date"));
		$result_search = mysql_query($query_search,$ksnews3);
		$row_search = mysql_fetch_assoc($result_search);
		//$num_search = mysql_num_rows($result_search);
		
		echo "<td>".$row_search['t_times']."</td>";
		
	}while($row_RecLevel2 = mysql_fetch_array($RecLevel2));
	?>
</table>


</div>
</body>
</html>
<?php
mysql_free_result($RecToday);

mysql_free_result($RecCount);
?>
