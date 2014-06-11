<?php ob_start()?>
<?php
	require_once('Connections/ksnews3.php'); 
	require('admin_manage/clientGetObj.php');
	$str1 = $code->getBrowse();//瀏覽器： 
	$str2 = $code->getIP();//IP地址： 
	$str3 = $code->getOS();//操作系統：
	
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
	
	if(!isset($_COOKIE['index']) && $_COOKIE['index'] == "")
	{
		mysql_select_db($database_ksnews3,$ksnews3);
		$query_insert = sprintf("INSERT INTO viewcount_class (`view_time`,`view_ip`,`view_class`,`view_browser`) VALUES (%s,%s,%s,%s)",GetSQLValueString(date("Y-m-d H:i:s"),"date"),GetSQLValueString($str2,"text"),GetSQLValueString($row_RecProduct['level2_id'],"text"),GetSQLValueString($str1,"text"));
		mysql_query($query_insert,$ksnews3);
		
		mysql_select_db($database_ksnews3,$ksnews3);
		$query_insert = sprintf("INSERT INTO viewcount (`view_time`,`view_ip`,`view_os`,`view_browser`) VALUES (%s,%s,%s,%s)",GetSQLValueString(date("Y-m-d H:i:s"),"date"),GetSQLValueString($str2,"text"),GetSQLValueString($str3,"text"),GetSQLValueString($str1,"text"));
		mysql_query($query_insert,$ksnews3);
		
		setcookie('index','index',time()+5);
	}
	
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecBanner = sprintf("SELECT * FROM ad_show WHERE class = %s AND position = %s AND `on` = 0 AND banner_id > %s ORDER BY id DESC LIMIT %s", GetSQLValueString("161", "text"),GetSQLValueString("A", "text"),GetSQLValueString($b_cookie_RecBanner, "int"), GetSQLValueString("1", "int"));
$RecBanner = mysql_query($query_RecBanner, $ksnews3) or die(mysql_error());
$row_RecBanner = mysql_fetch_assoc($RecBanner);
$totalRows_RecBanner = mysql_num_rows($RecBanner);
if($totalRows_RecBanner == 0)
{
	mysql_select_db($database_ksnews3, $ksnews3);
	$query_RecBanner = sprintf("SELECT * FROM ad_show WHERE class = %s AND position = %s AND `on` = 0 ORDER BY id DESC LIMIT %s", GetSQLValueString("161", "text"),GetSQLValueString("A", "text"),GetSQLValueString("1", "int"));
	$RecBanner = mysql_query($query_RecBanner, $ksnews3) or die(mysql_error());
	$row_RecBanner = mysql_fetch_assoc($RecBanner);
	$totalRows_RecBanner = mysql_num_rows($RecBanner);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>更生民宿網</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script type="text/javascript" src="js/tab.js"></script>
  <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

  <link href="css/slider.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
  #th {
	background-image: url(images/newhl_14.gif);
	width: 224px;
	height: 50px;
	clear: both;
	background-repeat: no-repeat;
   }
  #economy {
     background-color: #FEFEFE;
  }
  #cx_search table {
    font-size: 0.8em;
    border: 1px solid #9C6;
  }
  #reczipcode {
    width: 140px;
    font-size: 1.0em;
    text-decoration: none;
    margin-bottom: 10px;
    margin-right: 10px;
    margin-left: 10px;
    display: inline-block;
  }
  #reczipcode a {
    font-size: 1.2em;
    text-decoration: none;
    width: 150px;
  }
  </style>
</head>
<body>
  <div id="body">
  <?php include("header.php");?>
    <!-- 上方LOGO -->
    <div id="cx_header">
      <a id="logo" class="divlink" href="index.php">logo</a>
      <?php
	  if($totalRows_RecBanner > 0) { 
	  $banner_RecAd = $row_RecBanner['banner_id'];
		mysql_select_db($database_ksnews3, $ksnews3);
		$query_RecAd = sprintf("SELECT * FROM banner WHERE banner_id = %s AND CURDATE() <= DATE_ADD( `startdate`  , INTERVAL `downdate` DAY ) ",GetSQLValueString($banner_RecAd,"int"));
		$RecAd = mysql_query($query_RecAd, $ksnews3) or die(mysql_error());
		$row_RecAd = mysql_fetch_assoc($RecAd);
		$totalRows_RecAd = mysql_num_rows($RecAd);
		
		mysql_select_db($database_ksnews3, $ksnews3);
		$query_RecDetail = sprintf("SELECT * FROM banner_detail WHERE adv_id = %s", GetSQLValueString($banner_RecAd,"int"));
		$RecDetail = mysql_query($query_RecDetail, $ksnews3) or die(mysql_error());
		$row_RecDetail = mysql_fetch_assoc($RecDetail);
		$totalRows_RecDetail = mysql_num_rows($RecDetail);
		
		if($totalRows_RecAd>0){
	  ?>
      
   <?php if($row_RecAd['banner_url']!=""){?>
  <a href="<?php echo $row_RecAd['banner_url'];?>" target="_new" title="<?php echo $row_RecAd['banner_title'];?>"><img src="images/ksad/<?php echo $row_RecAd['banner_pic']; ?>" width="400" height="100"/></a>
  <?php } else { if($totalRows_RecDetail>0) {?>
  <a target="_new" href="banner_detail.php?id=<?php echo $row_RecAd['banner_id'];?>&amp;hits=true" title="<?php echo $row_RecAd['banner_title'];?>">
  <img src="images/ksad/<?php echo $row_RecAd['banner_pic']; ?>" width="400" height="100"/></a>
  <?php } else { ?>
  <a target="_new" href="banner_detail_pic.php?id=<?php echo $row_RecAd['banner_id'];?>&amp;hits=true" title="<?php echo $row_RecAd['banner_title'];?>">
  <img src="images/ksad/<?php echo $row_RecAd['banner_pic']; ?>" width="400" height="100"/></a>  
  <?php }}}} ?>
    </div>

    <!-- 內容 -->
    <div id="cx_content">
      <!-- 左區塊 -->
      <div id="cx_left">
        <?php include('cx_search.php'); ?>
        <?php include('bnb_hot.php');?>
      </div>

      <!-- 中區塊 -->
      <div id="cx_middle">    
            <div id="cx_m_top">
            <?php include('cx_gellary.php'); ?>
                <div id="cx_value">
                <?php include('economy.php'); ?>
                </div>
            <?php include('cx_text.php'); ?> 
          </div>

          <div id="cx_m_middle">
          <?php //中版位廣告
		  $b_level_RecBanner = "162"; // 廣告變數(level)
		  $b_position_RecBanner = "A"; // 廣告位置變數(position)A~Z
		  $b_totalshow = 1;//顯示數量
		  $b_cookie_time = 60*60*24*30; // cookie 紀錄時間(s)
		  include("banner_row.php");
		  ?>
          </div>
                   
    <div id="cx_m_nav">
     <?php include('abgne_tab.php') ;?>
    </div>
      	  
    <?php //中下版位廣告
	$b_level_RecBanner = "159"; // 廣告變數(level)
	$b_position_RecBanner = "A"; // 廣告位置變數(position)A~Z
	$b_totalshow = 1;//顯示數量
	$b_cookie_time = 60*60*24*30; // cookie 紀錄時間(s)
	include('cx_m_botton.php');
	?>
	
	<?php  //下方文字區塊廣告
	$b_level_RecBanner = "M1"; // 廣告變數(level)
	$b_position_RecBanner = "A"; // 廣告位置變數(position)A~Z
	$b_cookie_time = 60*60*24*30; // cookie 紀錄時間(s)
	include('cx_m_text.php');
	?>
	
    </div>

    <!-- 右區塊 -->
<div id="cx_right">
      <?php include('cx_travel.php');?>
      <?php 
      $array = array("生活消費" => '180',"職業訓練"=>'181',"活動情報"=>'182',"住宿資訊"=>'183');
      foreach($array as $value => $key)
      {
        $level = $key ; $title = $value; include('cx_active.php'); 
      }
      ?>
      <?php 
	  $b_level_RecBanner = "143"; // 廣告變數(level)
	  $b_position_RecBanner = "A"; // 廣告位置變數(position)A~Z
	  $b_totalshow = 1;//顯示數量
	  $b_cookie_time = 60*60*24*30; // cookie 紀錄時間(s)
	  include('cx_right_banner.php');
	  ?>
    </div>
  </div>

  <!-- footer -->
  <?php include('cx_footer.php'); ?>
</div>
</body>
</html>
