<?php ob_start();?>
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
  <style type="text/css">
  .rotator{
	background-color:#222;
	width:680px;
	height:400px;
	position:relative;
	font-family:'Myriad Pro',Arial,Helvetica,sans-serif;
	color:#fff;
	text-transform:uppercase;
	letter-spacing:-1px;
	border:3px solid #f0f0f0;
	overflow:hidden;
	-moz-box-shadow:0px 0px 10px #222;
	-webkit-box-shadow:0px 0px 10px #222;
	box-shadow:0px 0px 10px #222;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
img.bg{
    position:absolute;
    top:0px;
    left:0px;
}
.rotator ul{
    list-style:none;
    position:absolute;
    right:0px;
    top:0px;
    margin-top:2px;
    z-index:999999;
}
.rotator ul li{
	display:block;
	float:left;
	clear:both;
	width:100px;
}
.rotator ul li a{
    width:100px;
    float:right;
    clear:both;
    padding-left:10px;
    text-decoration:none;
    display:block;
    height:20px;
    line-height:20px;
    background-color:#222;
    margin:1px -20px 1px 0px;
    opacity:0.7;
    color:#f0f0f0;
    font-size:0.8em;
    border:2px solid #000;
    border-right:none;
    outline:none;
    text-shadow:-1px 1px 1px #000;
    -moz-border-radius:10px 0px 0px 20px;
    -webkit-border-top-left-radius:5px;
    -webkit-border-bottom-left-radius:20px;
    border-top-left-radius:10px;
    border-bottom-left-radius:20px;
}
.rotator ul li a:hover{
      text-shadow:0px 0px 2px #fff;
}
.rotator .heading{
    position:absolute;
    top:0px;
    left:0px;
    width:680px;
}
.rotator .heading h1{
    text-shadow:-1px 1px 1px #555;
    font-weight:normal;
    font-size:0.8em;
    padding:20px;
}

a.more{
    color:orange;
    text-decoration:none;
    text-transform:uppercase;
    font-size:0.8em;
}
a.more:hover{
    color:#fff;
}


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
    <!-- 上方LOGO -->
  <?php include("header.php");?>
    <!-- 上方LOGO -->
    <div id="cx_header">
      <a id="logo" class="divlink" href="index.php">logo</a>
    </div>

    <!-- 內容 -->
    <div id="cx_content">
      <!-- 左區塊  -->
      <div id="cx_left">
        <?php include('cx_search.php'); ?>
        <?php include('bnb_hot.php');?>
      </div>
      
      <!-- 中區塊 -->
      <div id="cx_middle">    
            <div id="cx_m_top" >
            <?php include('cx_gellary_search.php'); ?>
			<?php include('cx_text.php'); ?> 
          </div>

          <div id="cx_m_middle">
          <?php 
		  $b_level_RecBanner = "B3"; // 廣告變數(level)
		  $b_position_RecBanner = "B"; // 廣告位置變數(position)A~Z
		  $b_totalshow = 1;//顯示數量
		  $b_cookie_time = 60*60*24*30; // cookie 紀錄時間(s)
		  include('banner_row.php');
		  ?>
          </div>
                   
    <div id="cx_m_nav">
    <?php include('abgne_tab.php') ;?>
    <?php 
	$b_level_RecBanner = "B4"; // 廣告變數(level)
	$b_position_RecBanner = "B"; // 廣告位置變數(position)A~Z
	$b_totalshow = 1;//顯示數量
	$b_cookie_time = 60*60*24*30; // cookie 紀錄時間(s)
	include('cx_m_botton.php');
	?>
	<?php  //下方文字區塊廣告
	$b_level_RecBanner = "M1"; // 廣告變數(level)
	$b_position_RecBanner = "B"; // 廣告位置變數(position)A~Z
	$b_cookie_time = 60*60*24*30; // cookie 紀錄時間(s)
	include('cx_m_text.php');
	?>
    </div>
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
	  $b_level_RecBanner = "B2"; // 廣告變數(level)
	  $b_position_RecBanner = "B"; // 廣告位置變數(position)A~Z
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
