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

$colname_RecZip = $_GET['city'];
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecZip = sprintf("SELECT * FROM level2 WHERE level1_id = %s ORDER BY level2_id ASC", GetSQLValueString($colname_RecZip, "text"));
$RecZip = mysql_query($query_RecZip, $ksnews3) or die(mysql_error());
$row_RecZip = mysql_fetch_assoc($RecZip);
$totalRows_RecZip = mysql_num_rows($RecZip);

$colname_RecContent = $_GET['city'];
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecContent = sprintf("SELECT * FROM level2 WHERE level1_id = %s ORDER BY level2_id ASC", GetSQLValueString($colname_RecContent, "text"));
$RecContent = mysql_query($query_RecContent, $ksnews3) or die(mysql_error());
$row_RecContent = mysql_fetch_assoc($RecContent);
$totalRows_RecContent = mysql_num_rows($RecContent);
?>

<style type="text/css">
.abgne_tab {
	clear: left;
	width: 99%;
	margin-top: 10px;
	margin-right: 0;
	margin-bottom: 10px;
	margin-left: 0;
	float: left;
}
ul.tabs {
	width: 100%;
	height: 32px;
	border-bottom: 1px solid #999;
	border-left: 1px solid #999;
}
ul.tabs li {
  float: left;
  height: 31px;
  line-height: 30px;
  overflow: hidden;
  position: relative;
  margin-bottom: -1px;	/* 讓 li 往下移來遮住 ul 的部份 border-bottom */
  border: 1px solid #999;
  border-left: none;
  font-size: 0.8em;
  background-color: #9C6;
}
ul.tabs li a {
	display: block;
	padding: 0 5px;
	color: #000;
	border: 1px solid #fff;
	text-decoration: none;
}
ul.tabs li a:hover {
  background: #9C6;
}
ul.tabs li.active  {
  background: #fff;
  border-bottom: 1px solid #fff;
}
ul.tabs li.active a:hover {
  background: #fff;
}
div.tab_container {
	clear: left;
	width: 100%;
	border: 1px solid #999;
	border-top: none;
	background: #fff;
}
div.tab_container .tab_content {
	padding: 20px;
	font-size: 0.8em;
}

div.tab_container .tab_content h2 {
  margin: 0 0 20px;
}
.sec_tab {
  width: 600px;	/* 第2個頁籤區塊的寬度 */
}
</style>
<script>
$(function(){
	$('a#click').click(function(){		
		var city = $(this).siblings('#city').val();	
		$.ajax({
			type : "GET",
			url : "tab_searh.php",
			data :'city='+ city,
			error:function(){
				alert('Ajax request 發生錯誤');
			},
			success:function(data){
				$("#abgne_tab").html(data);
			}
		});
	})
})
</script>

  
  <ul class="tabs">
    <?php 
    $RecDetail = sprintf("SELECT * FROM level1 ORDER BY level_id");
    $Result = mysql_query($RecDetail,$ksnews3);
    $row_RecDetail = mysql_fetch_assoc($Result);
    ?>
    <?php do { ?>
    <?php if($row_RecDetail['name'] != ""){ ?>
    <li><a href="#abgne_tab" id="click"><?php echo $row_RecDetail['name']; ?></a><input id="city" type="hidden" value="<?php echo $row_RecDetail['level_id']; ?>" /></li>
    <?php } ?>
    <?php } while ($row_RecDetail = mysql_fetch_assoc($Result)); ?>
  </ul>
  
<div class="abgne_tab" id="abgne_tab">   
<?php include("tab_searh.php");?>
</div>

        <?php 
        mysql_free_result($RecZip);
        mysql_free_result($RecContent);

        ?>