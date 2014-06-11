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

$colname_RecSearchBnb = "-1";
if (isset($_GET['id'])) {
  $colname_RecSearchBnb = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecSearchBnb = sprintf("SELECT * FROM product WHERE n_id = %s", GetSQLValueString($colname_RecSearchBnb, "int"));
$RecSearchBnb = mysql_query($query_RecSearchBnb, $ksnews3) or die(mysql_error());
$row_RecSearchBnb = mysql_fetch_assoc($RecSearchBnb);
$totalRows_RecSearchBnb = mysql_num_rows($RecSearchBnb);

$colname_RecProductDetail = "-1";
if (isset($_GET['id'])) {
  $colname_RecProductDetail = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecProductDetail = sprintf("SELECT * FROM product_detail WHERE v_id = %s", GetSQLValueString($colname_RecProductDetail, "text"));
$RecProductDetail = mysql_query($query_RecProductDetail, $ksnews3) or die(mysql_error());
$row_RecProductDetail = mysql_fetch_assoc($RecProductDetail);
$totalRows_RecProductDetail = mysql_num_rows($RecProductDetail);

$colname_RecVideo = "-1";
if (isset($_GET['id'])) {
  $colname_RecVideo = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecVideo = sprintf("SELECT * FROM product_vedio WHERE product_id = %s", GetSQLValueString($colname_RecVideo, "int"));
$RecVideo = mysql_query($query_RecVideo, $ksnews3) or die(mysql_error());
$row_RecVideo = mysql_fetch_assoc($RecVideo);
$totalRows_RecVideo = mysql_num_rows($RecVideo);

$colname_RecPic = "-1";
if (isset($_GET['id'])) {
  $colname_RecPic = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecPic = sprintf("SELECT * FROM product_pic WHERE product_id = %s ORDER BY productpic_id ASC", GetSQLValueString($colname_RecPic, "int"));
$RecPic = mysql_query($query_RecPic, $ksnews3) or die(mysql_error());
$row_RecPic = mysql_fetch_assoc($RecPic);
$totalRows_RecPic = mysql_num_rows($RecPic);


?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&region=zh-tw"></script>
<script> 
		 var address = "<?php echo $row_RecSearchBnb['address']; ?>";
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
    					 title: '<?php echo $row_RecSearchBnb['n_name']; ?>'
					 });
                 }
                 else
                 {
                     alert("沒有地圖資料");
                 }
             },
             error: function ()
             {
                 alert("資料錯誤");
             }
         });	
</script>
 
<div class="row-bot" style="width:690px">
<div class="slider-wrapper">    
    <div class="slider">
      <ul class="items">        
        <?php if(isset($row_RecSearchBnb['big_pic'])) { ?>
        <li><img src="timthumb.php?src=images/bnb/<?php echo $row_RecSearchBnb['big_pic']; ?>&w=680&h=350"/></li>
		<?php } ?>
        <?php do { ?>
        <?php if($totalRows_RecPic > 0 ) { ?>
          <li><img src="timthumb.php?src=images/photos/<?php echo $row_RecPic['product_title']; ?>&w=680&h=350"/></li>
          <?php } ?>
          <?php } while ($row_RecPic = mysql_fetch_assoc($RecPic)); ?>
      </ul>
    </div>
</div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-bottom:10px">
  <tr>
    <td width="67%"><h1><?php echo $row_RecSearchBnb['n_name']; ?></h1></td>
    <td width="33%"><a href="https://www.google.com.tw/maps/dir//<?php echo $row_RecSearchBnb['address']; ?>" target="_new">規劃路線</a></td>
  </tr>
  <tr>
    <td colspan="2" style="word-break:break-all"><?php echo nl2br($row_RecSearchBnb['n_detail']); ?></td>
  </tr>
  <?php do { ?>
    <?php if ($totalRows_RecProductDetail > 0) { // Show if recordset not empty ?>
      <tr>
        <td colspan="2" style="word-break:break-all"><?php echo $row_RecProductDetail['detail']; ?></td>
      </tr>
      <?php } // Show if recordset not empty ?>
    <?php } while ($row_RecProductDetail = mysql_fetch_assoc($RecProductDetail)); ?>
  <?php do { ?>
  <?php if($totalRows_RecVideo > 0) { ?>
    <tr>
      <td colspan="2"><h2><?php echo $row_RecVideo['productvedio_title']; ?></h2></td>
    </tr>
    <tr style="margin-bottom:50px">
      <td colspan="2" style="word-break:break-all"><iframe width="690" height="388" src="//www.youtube.com/embed/<?php echo $row_RecVideo['productvedio_url']; ?>" frameborder="0" allowfullscreen></iframe></td>
    </tr>
    <?php } ?>
    <?php } while ($row_RecVideo = mysql_fetch_assoc($RecVideo)); ?>
  <tr>
    <td colspan="2">Google 地圖
      <div id="map" style="width:690px; height:300px;align="left"></div></td>
  </tr>
</table>
</div>


<?php
mysql_free_result($RecSearchBnb);

mysql_free_result($RecProductDetail);

mysql_free_result($RecVideo);

mysql_free_result($RecPic);
?>
