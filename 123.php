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
<body>
<div id="body">
  <!-- 上方LOGO -->
	<style type="text/css">
#header {
	height: 16px;
	width: 990px;
}
#header_R {
	float: right;
	height: 16px;
	width: auto;
	font-family: "微軟正黑體", "標楷體", "細明體";
	font-size: 12px;
}
  #dete {
	float: left;
	height: 16px;
	width: 350px;
	font-family: "微軟正黑體", "標楷體", "新細明體";
}
  #logo {
	height: 62px;
	width: 990px;
	float: left;
	margin-top: 2px;
	background-image: url(images/kslogo2_1.gif);
}

#footer {
	float: left;
	height: 70px;
	width: 1000px;
	font-size: 14px;
	color: #666666;
	background-image: url(/images/bg_footer.gif);
	background-repeat: repeat-x;
}
#footer_pic {
	background-image: url(admin_ksnews/ckeditor/images/flooer_5.gif);
	float: left;
	height: 72px;
	width: 138px;
}
/*
#banner_logo {
	float: left;
	height: 62px;
	width: 200px;
	/* [disabled]border: 0.8px solid #990; */
/*	margin-left: 290px;
   display:inline; 
}
*/
  #logo_back {
	height: 62px;
	width: 500px;
	float: left;
	margin-top: 2px;
	background-image: url(images/KSbanner-2 (2)_remmant.jpg);
}
#banner_logo {
	float: left;
	height: 62px;
	width: 200px;
	/* [disabled]border: 0.8px solid #990; */

   /*display:inline; */
   margin-top: 2px;
  background-image: url(images/KSbanner-3 (2)_middle.jpg) 
}
#header_logo{
	height: 62px;
	width: 290px;
	float: left;
	margin-top: 2px;
	background-image: url(images/KSbanner-2 (2)_head.jpg);
	
}

</style>
<div id="header"> 
   <div id="dete">
      <SCRIPT language=JavaScript src="js/lunar.js"></SCRIPT>
   </div>
      <div id="header_R"> <div id="link1">
   <a href="index.php">&nbsp;回首頁</a> 
   <!--<a href="introduction.php">&nbsp;關於更生</a> 
   <!--<a href="useractionAssent.php" target="_blank">&nbsp;我有活動</a> 
   <a href="userPostAssent.php" target="_blank">&nbsp;線上投稿</a> -->
   <!--<a href="uorder_add.php" target="_blank">&nbsp;網路訂報</a> 
   <a href="banner_class.php" target="_blank">&nbsp;刊登廣告</a> 
   <a href="http://tw.stock.yahoo.com/s/tse.php" target="_blank">&nbsp;股市行情</a>
   <!--<a href="userBookAssent.php" target="_blank">&nbsp;線上投書</a>-->
   <!--<a href="login_vender.php">&nbsp;廠商登入與註冊</a>-->
 <a href="login.php">&nbsp;會員登入與註冊</a>
 <a href="admin_manage/login.php">&nbsp;管理者登入</a>
 </div></div>
   
<div id="cx_header">
    <a id="logo" class="divlink" href="index.php">logo</a>
  </div>

    <!-- 內容 -->
    <div id="cx_content">
      <!-- 左區塊 -->
      <div id="cx_left">
        <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
            $(document).ready(function(){
                //利用jQuery的ajax把縣市編號(CNo)傳到Town_ajax.php把相對應的區域名稱回傳後印到選擇區域(鄉鎮)下拉選單
                $('#city').change(function(){
                    var CNo= $('#city').val();
                    $.ajax({
                        type: "POST",
                        url: 'admin_manage/Town_ajax.php',
                        cache: false,
                        data:'city='+CNo,
                        error: function(){
                            alert('Ajax request 發生錯誤');
                        },
                        success: function(data){
                            $('#b_zip').html(data);
                        }
                    });
                });
            });
        </script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />


<div id="cx_search">
        <form action="search.php" method="post" id="form1" name="form1">   
        <table width="150px" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="21" colspan="2" align="center" style="background-color:#9FD4BA"><h3>民宿 快速搜尋</h3></td>
          </tr>
          <tr>
            <td>縣市：</td>
            <td align="center"><label for="city"></label>
              <select name="city" id="city">
                <option value="">請選擇縣市</option>
                                <option value="000001">花 蓮 縣</option>
                                <option value="000002">台 東 縣 </option>
                            </select></td>
          </tr>
          <tr>
            <td width="67">鄉鎮：</td>
            <td width="68" align="center"><label for="b_zip"></label>
              <select name="b_zip" id="b_zip">
			  <option value="">請選擇鄉鎮</option>
</select></td>
          </tr>
          
          <tr>
            <td>低於此價：</td>
            <td><label for="highprice"></label>
<span id="sprytextfield2">
<input name="highprice" type="text" id="highprice" size="10" />
<span class="textfieldInvalidFormatMsg">格式無效。</span></span></td>
          </tr>
          <tr>
            <td height="18">關鍵字：</td>
            <td width="6"><label for="key"></label>
              <input name="key" type="text" id="key" size="10" /></td>
          </tr>
          <tr>
            <td height="31" colspan="2" align="center"><a href="test.php">
              <button type="submit" id="sumbit">查詢</button>
            </a></td>
          </tr>
        </table></form>
      </div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {isRequired:false, useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {isRequired:false, useCharacterMasking:true});
</script>
              </div>

      <!-- 中區塊 -->
      <div id="cx_middle">
          <div id="cx_m_top">
                        

<table width="690" border="0" cellpadding="0" cellspacing="0"  style="word-break:break-all">
  <tr>
    <td><h1>傑森櫃子民宿</h1></td>
  </tr>
  <tr>
    <td><p>
	　</p>
</td>
  </tr>
</table>
            
          </div>
                 
          <div id="cx_m_nav">	        
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
  font-size: 1.0em;
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
	font-size: 1.0em;
}

div.tab_container .tab_content h2 {
  margin: 0 0 20px;
}
.sec_tab {
  width: 650px;	/* 第2個頁籤區塊的寬度 */
}
</style>
  
<link rel="stylesheet" type="text/css" href="lib/jquery.ad-gallery.css">
<script type="text/javascript" src="lib/jquery.ad-gallery.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&region=zh-tw"></script>
<script> 
		 var address = "花蓮縣吉安鄉福興村舊村六街41號";
         $.ajax({
             type: "post",
             dataType: "json",
             url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + address + "&sensor=false&language=zh-tw",
             success: function (data)
             {
 
                 if (data.status == "OK")
                 {
                     var mapOptions = {
                         zoom: 18,
                         center: new google.maps.LatLng(data.results[0].geometry.location.lat,
                      	 data.results[0].geometry.location.lng),
                         mapTypeId: google.maps.MapTypeId.ROADMAP
                     }
 
                     var map = new google.maps.Map(document.getElementById("map"),mapOptions);
					 var marker = new google.maps.Marker({
						 position: map.getCenter(),
    					 map: map,
    					 title: ''
					 });
                 }
                 else
                 {
                     <!--alert("沒有地圖資料");
                 }
             },
             error: function ()
             {
                 alert("資料錯誤");
             }
         });	
</script>
	<div class="abgne_tab">
		<ul class="tabs">
        			<li><a href="#tab1">地圖</a></li>
                                    <li><a href="#tab3">相簿</a></li>
                            <li><a href="#tab4">詳細資訊</a></li>
        		</ul>
 
		<div class="tab_container">
			<div id="tab1" class="tab_content">
				<div id="map" style="width:650px; height:350px;align=left"></div>
			</div>
			<div id="tab2" class="tab_content">
				<h2></h2>
							    <p><iframe width="650" height="488" src="//www.youtube.com/embed/" frameborder="0" allowfullscreen></iframe></p>
				              </div>
            <div id="tab3" class="tab_content">
<div id="gallery" class="ad-gallery">
      <div class="ad-image-wrapper">
      </div>
      <div class="ad-controls">
      </div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
          <li>
                <a href="images/bnb/2014042917073302.jpg">
                  <img src="timthumb.php?src=images/bnb/2014042917073302.jpg&w=50&h=50&zc=0&q=100" class="image0">
                  </a>
              </li>
                      </ul>
        </div>
      </div>
    </div>
			</div>
            <div id="tab4" class="tab_content">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cx_admin_table">
			    <tr>
				      <td width="24%">最低房價</td>
				      <td width="76%">0</td>
		        </tr>
				    <tr>
				      <td>所屬交通路線</td>
				      <td></td>
			        </tr>
				    <tr>
				      <td>旅遊景點</td>
				      <td></td>
			        </tr>
				    <tr>
				      <td>網址</td>
				      <td><a href="http://www.graceland.com.tw/" target="_new">http://www.graceland.com.tw/</a></td>
			        </tr>
				    <tr>
				      <td><a href="https://www.google.com.tw/maps/dir//花蓮縣吉安鄉福興村舊村六街41號" target="_new">我要規劃路線</td>
				      <td>花蓮縣吉安鄉福興村舊村六街41號</td>
			        </tr>
		      </table>
            </div>
		</div>
	</div>
      	  </div>
    		<div id="cx_m_botton">
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>



</div>			
			<div id="cx_m_botton">

</div>    
    </div>

    <!-- 右區塊 -->
    <div id="cx_right">
      <div id="cx_travel">更生旅遊網</div>      <div id="cx_active" style="font-size:0.8em">
  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                </table>

</div>
<div id="cx_active" style="font-size:0.8em">
  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                </table>

</div>
<div id="cx_active" style="font-size:0.8em">
  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                </table>

</div>
<div id="cx_active" style="font-size:0.8em">
  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                </table>

</div>
      <div id="cx_right_banner">
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>



</div>
    </div>
  </div>

  <!-- footer -->
  <div id="cx_footer">
    <div id="copyright" align="center" style="font-size:0.8em">TEL : (038)340131 ext 317 / FAX:(038)341406 地址：97048 花蓮市五權街三十六號<br />
    對本網站的意見請寄 <a href="mailto:keng-shen@umail.hinet.net">keng-shen@umail.hinet.net</a><br />
    最佳瀏覽解析度：1024 x 768 pixel in Microsoft Internet Explorer 8.0+ 版權所有 更生日報 All Rights Reserved 2008</div>
</div></div>
<script>
$(window).load(function() {
	$('.slider')._TMS({
		duration:1000,
		easing:'easeOutQuint',
		preset:'diagonalFade',
		slideshow:4000,
		banners:false,
		pauseOnHover:true,
		pagination:true,
		pagNums:false
	});
});
</script>
</body>
</html>
