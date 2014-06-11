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

$colname_RecSearchBanner = "-1";
if (isset($_GET['id'])) {
  $colname_RecSearchBanner = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecSearchBanner = sprintf("SELECT * FROM banner_detail WHERE adv_id = %s", GetSQLValueString($colname_RecSearchBanner, "int"));
$RecSearchBanner = mysql_query($query_RecSearchBanner, $ksnews3) or die(mysql_error());
$row_RecSearchBanner = mysql_fetch_assoc($RecSearchBanner);
$totalRows_RecSearchBanner = mysql_num_rows($RecSearchBanner);

$colname_RecSearchBanner_pic = "-1";
if (isset($_GET['id'])) {
  $colname_RecSearchBanner_pic = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecSearchBanner_pic = sprintf("SELECT * FROM banner_pic WHERE banner_id = %s", GetSQLValueString($colname_RecSearchBanner_pic, "int"));
$RecSearchBanner_pic = mysql_query($query_RecSearchBanner_pic, $ksnews3) or die(mysql_error());
$row_RecSearchBanner_pic = mysql_fetch_assoc($RecSearchBanner_pic);
$totalRows_RecSearchBanner_pic = mysql_num_rows($RecSearchBanner_pic);
?> 
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&region=zh-tw"></script>
<script> 
		 var address = "<?php echo $row_RecSearchBanner['adv_addr']; ?>";
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
                     <!--alert("沒有地圖資料");
                 }
             },
             error: function ()
             {
                 alert("資料錯誤");
             }
         });	
</script>
<div class="row-bot">
<div class="slider-wrapper">    
    <div class="slider">
      <ul class="items">        
        <?php if(isset($row_RecSearchBanner_pic['banner_pic'])) { ?>
        <?php do{ ?>
        <li> <img src="timthumb.php?src=images/ksad/<?php echo $row_RecSearchBanner_pic['banner_pic']; ?>&w=1000" alt="" /></li>      
        <?php }while($row_RecSearchBanner_pic = mysql_fetch_assoc($RecSearchBanner_pic));} ?>
      </ul>
    </div>
</div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" >
  <tr>
    <td style="text-align:center"><h1><?php echo $row_RecSearchBanner['adv_title']; ?></h1></td>
  </tr>
  <tr>
    <td><?php echo $row_RecSearchBanner['adv_content']; ?></td>
  </tr>
  <tr>
    <td>
    <div id="map" style="width:1000px; height:500px;align=left"></div>
    </td>
  </tr>
  <tr>
    <td>商家名稱：<?php echo $row_RecSearchBanner['adv_contact']; ?></td>
  </tr>
  <tr>
    <td>商家電話：<?php echo $row_RecSearchBanner['adv_tel']; ?></td>
  </tr>
  <tr>
    <td>商家地點：<?php echo $row_RecSearchBanner['adv_addr']; ?></td>
  </tr>
  </table>
<h1>&nbsp;</h1>
</div>
