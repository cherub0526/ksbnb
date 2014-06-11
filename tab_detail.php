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

$colname_RecProduct = "-1";
if (isset($_GET['id'])) {
  $colname_RecProduct = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecProduct = sprintf("SELECT * FROM product WHERE n_id = %s", GetSQLValueString($colname_RecProduct, "int"));
$RecProduct = mysql_query($query_RecProduct, $ksnews3) or die(mysql_error());
$row_RecProduct = mysql_fetch_assoc($RecProduct);
$totalRows_RecProduct = mysql_num_rows($RecProduct);

$analyze = explode(";",$row_RecProduct['Description']);
$travel = explode(":",$analyze[0]);
$route = explode(":",$analyze[1]); 

$colname_RecVideo = "-1";
if (isset($_GET['id'])) {
  $colname_RecVideo = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecVideo = sprintf("SELECT * FROM product_vedio WHERE product_id = %s", GetSQLValueString($colname_RecVideo, "int"));
$RecVideo = mysql_query($query_RecVideo, $ksnews3) or die(mysql_error());
$row_RecVideo = mysql_fetch_assoc($RecVideo);
$totalRows_RecVideo = mysql_num_rows($RecVideo);

$colname_RecPhotos = "-1";
if (isset($_GET['id'])) {
  $colname_RecPhotos = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecPhotos = sprintf("SELECT * FROM product_pic WHERE product_id = %s", GetSQLValueString($colname_RecPhotos, "int"));
$RecPhotos = mysql_query($query_RecPhotos, $ksnews3) or die(mysql_error());
$row_RecPhotos = mysql_fetch_assoc($RecPhotos);
$totalRows_RecPhotos = mysql_num_rows($RecPhotos);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//maps.google.com/maps?file=api&v=2&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
    var i;
    var split;

    function trans() {
        i = 0;
        var content = "<?php echo $row_RecProduct['address'];?>";
        split = content.split("\n");
        delayedLoop();
    }

    function delayedLoop() {
        addressToLatLng(split[i]);
        if (++i == split.length) {
            return;
        }
        window.setTimeout(delayedLoop, 1500);
    }

    function addressToLatLng(addr) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            "address": addr
        }, function (results, status) {
            if ($("#c").attr('checked'))
            {
                addr = addr + "=";
            }
            else {
                addr = "";
            }
            if (status == google.maps.GeocoderStatus.OK) {
                var content = $("#target").val();
                /*$("#target").val(content + addr + results[0].geometry.location.lat() + "," + results[0].geometry.location.lng() + "\n");*/
				var lat = results[0].geometry.location.lat();
				var lng = results[0].geometry.location.lng();
				initialize(lat,lng);
            } else {
                var content = $("#target").val();
                $("#target").val(content + addr + "查無經緯度" + "\n");
            }
        });
    }   

    function initialize(lat,lng) {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(
            document.getElementById('map'));
        map.setCenter(new GLatLng(lat, lng), 17);
        map.setUIToDefault();

        map.addOverlay(new GMarker(new GLatLng(lat, lng)));

      }
    }	
	
	trans();
</script>



	<div class="abgne_tab">
		<ul class="tabs">
        <?php if($row_RecProduct['address']!="") {?>
			<li><a href="#tab1">地圖</a></li>
        <?php } ?>
        <?php if($totalRows_RecVideo>0) {?>
			<li><a href="#tab2">影片</a></li>
        <?php } ?>
        <?php if($row_RecProduct['big_pic']!="" || $totalRows_RecPhotos > 0) {?>
            <li><a href="#tab3">相簿</a></li>
        <?php } ?>
        <?php if($row_RecProduct['Description']!="") {?>
            <li><a href="#tab4">詳細資訊</a></li>
        <?php } ?>
		</ul>
 
		<div class="tab_container">
			<div id="tab1" class="tab_content">
				<div id="map" style="width:650px; height:350px;align=left"></div>
			</div>
			<div id="tab2" class="tab_content">
				<h2><?php echo $row_RecVideo['productvedio_title']; ?></h2>
				<?php do { ?>
			    <p><iframe width="650" height="488" src="//www.youtube.com/embed/<?php echo $row_RecVideo['productvedio_url']; ?>" frameborder="0" allowfullscreen></iframe></p>
				  <?php } while ($row_RecVideo = mysql_fetch_assoc($RecVideo)); ?>
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
                <a href="images/bnb/<?php echo $row_RecProduct['big_pic']; ?>">
                  <img src="timthumb.php?src=images/bnb/<?php echo $row_RecProduct['big_pic']; ?>&w=50&h=50&zc=0&q=100" class="image0">
                  </a>
              </li>
            <?php if($totalRows_RecPhotos > 0) { do { ?>            
              <li>
                <a href="images/photos/<?php echo $row_RecPhotos['product_pic']; ?>">
                  <img src="timthumb.php?src=images/photos/<?php echo $row_RecPhotos['product_pic']; ?>&w=50&h=50&zc=0&q=100" class="image0">
                  </a>
              </li>
              <?php } while ($row_RecPhotos = mysql_fetch_assoc($RecPhotos));} ?>
          </ul>
        </div>
      </div>
    </div>
			</div>
            <div id="tab4" class="tab_content">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cx_admin_table">
			    <tr>
				      <td width="24%">最低房價</td>
				      <td width="76%"><?php echo $row_RecProduct['price']; ?></td>
		        </tr>
				    <tr>
				      <td>所屬交通路線</td>
				      <td><?php echo $travel[1]; ?></td>
			        </tr>
				    <tr>
				      <td>旅遊景點</td>
				      <td><?php echo $route[1]; ?></td>
			        </tr>
				    <tr>
				      <td>網址</td>
				      <td><?php echo $row_RecProduct['discrict']; ?></td>
			        </tr>
				    <tr>
				      <td><a href="https://www.google.com.tw/maps/dir//<?php echo $row_RecProduct['address'];?>" target="_new">我要規劃路線</td>
				      <td><?php echo $row_RecProduct['address'];?></td>
			        </tr>
		      </table>
            </div>
		</div>
	</div>
