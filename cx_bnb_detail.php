<?php
require_once("Connections/ksnews3.php");
ob_start();
if ((isset($_GET['hits'])) && ($_GET['hits'] != "")) {
  $execSQL = "UPDATE product set times = times + 1 WHERE n_id=".$_GET['id'];
  if(!isset($_COOKIE['bnb'])) {
  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($execSQL, $ksnews3) or die(mysql_error());
  setcookie('bnb',$_SERVER['REMOTE_ADDR'],time()+5);//設定 cookie 避免用戶衝點擊數(單位：秒)
  }
  $execGoTo = "cx_bnb_detail.php?id=".$_GET['id'];
  header(sprintf("Location: %s", $execGoTo));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>民宿詳細資訊</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script type="text/javascript" src="js/tab.js"></script>
  <script src="js/tms-0.3.js"></script>
  <script src="js/tms_presets.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
<link href="css/slider.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
  #th {
    background-image: url(images/newhl_14.gif);
    width: 224px;
    height: 42px;
    clear: both;
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
<body onload="initialize()">
<div id="body">
  <!-- 上方LOGO -->
	<?php
	include('header.php');
    include("cx_header.php");
    ?>

    <!-- 內容 -->
    <div id="cx_content">
      <!-- 左區塊 -->
      <div id="cx_left">
        <?php include('cx_search.php'); ?>
        <?php //include('cx_left_banner.php');?>
      </div>

      <!-- 中區塊 -->
      <div id="cx_middle">
          <div id="cx_m_top">
            <?php //include("cx_bnb.php");?>
            <?php include('bnb_detail.php');?>            
          </div>
                 
          <div id="cx_m_nav">	        
              <?php //include('abgne_tab.php');?>
              <?php include('tab_detail.php');?>
      	  </div>
    		<?php 
			$b_level_RecBanner = "C1"; // 廣告變數(class)
			$b_position_RecBanner = "C"; // 廣告位置變數(position)A~Z
			$b_totalshow = 1;//顯示數量
			$b_cookie_time = 60*60*24*30; // cookie 紀錄時間(s)
			include('cx_m_botton.php');
			?>
			
			<?php  //下方文字區塊廣告
			$b_level_RecBanner = "M1"; // 廣告變數(level)
			$b_position_RecBanner = "C"; // 廣告位置變數(position)A~Z
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
	  $b_level_RecBanner = "C2"; // 廣告變數(class)
	  $b_position_RecBanner = "C"; // 廣告位置變數(position)A~Z
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
