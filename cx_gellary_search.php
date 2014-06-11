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

mysql_select_db($database_ksnews3, $ksnews3);
$query_Recbnb = "SELECT * FROM ad_show WHERE position = 'B' AND class = 'B1' ORDER BY rand() ASC LIMIT 15";
$Recbnb = mysql_query($query_Recbnb, $ksnews3) or die(mysql_error());
$row_Recbnb = mysql_fetch_assoc($Recbnb);
$totalRows_Recbnb = mysql_num_rows($Recbnb);
?>
<div id="cx_gellary1">
  <div id="content">
    <div class="rotator">
      <ul id="rotmenu">
        <?php 
		do {
			mysql_select_db($database_ksnews3,$ksnews3);
			$query_search =  sprintf("SELECT * FROM banner WHERE banner_id = %s",GetSQLValueString($row_Recbnb['banner_id'],"int"));
			$RecSearch = mysql_query($query_search,$ksnews3);
			$row_search = mysql_fetch_assoc($RecSearch);
		
		?>
        <li>        
          <a href="<?php echo $row_Recbnb['b_url']; ?>"><?php echo mb_substr($row_search['banner_title'],0,7,'utf-8'); ?></a>
          <div style="display:none;">
            <div class="info_image">images/ksad/<?php echo $row_search['banner_pic']; ?></div>
            <div class="info_heading">Our Works</div>
          </div>
        </li>
        <?php } while ($row_search = mysql_fetch_assoc($RecSearch)); ?>
      </ul>
      <div id="rot1">
        <img src="" alt="" width="100%" height="400px" class="bg"/>
      </div>
    </div>
  </div>  
</div>

<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/rotmenu_search.js"></script>
<?php
mysql_free_result($Recbnb);
?>
