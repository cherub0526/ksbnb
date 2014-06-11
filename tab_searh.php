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

if(isset($_GET['city'])){
	$query_RecZip = sprintf("SELECT * FROM level2 WHERE level1_id = %s ORDER BY level2_id ASC", GetSQLValueString($colname_RecZip, "text"));
}
else
{
	$query_RecZip = sprintf("SELECT * FROM level2 WHERE level1_id = '000001' ORDER BY level2_id ASC");
}
$RecZip = mysql_query($query_RecZip, $ksnews3) or die(mysql_error());
$row_RecZip = mysql_fetch_assoc($RecZip);
$totalRows_RecZip = mysql_num_rows($RecZip);

$colname_RecContent = $_GET['city'];
mysql_select_db($database_ksnews3, $ksnews3);
if(isset($_GET['city'])){
$query_RecContent = sprintf("SELECT * FROM level2 WHERE level1_id = %s ORDER BY level2_id ASC", GetSQLValueString($colname_RecContent, "text"));
}
else
{
	$query_RecContent = sprintf("SELECT * FROM level2 WHERE level1_id = '000001' ORDER BY level2_id ASC");
}
$RecContent = mysql_query($query_RecContent, $ksnews3) or die(mysql_error());
$row_RecContent = mysql_fetch_assoc($RecContent);
$totalRows_RecContent = mysql_num_rows($RecContent);

?>
<head>
<script type="text/javascript">
	$(function(){
		// 預設顯示第一個 Tab
		var _showTab = 0;
		$('.abgne_tab').each(function(){
			// 目前的頁籤區塊
			var $tab = $(this);

			var $defaultLi = $('ul.tabs li', $tab).eq(_showTab).addClass('active');
			$($defaultLi.find('a').attr('href')).siblings().hide();
			
			// 當 li 頁籤被點擊時...
			// 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
			$('ul.tabs li', $tab).click(function() {
				// 找出 li 中的超連結 href(#id)
				var $this = $(this),
					_clickTab = $this.find('a').attr('href');
				// 把目前點擊到的 li 頁籤加上 .active
				// 並把兄弟元素中有 .active 的都移除 class
				$this.addClass('active').siblings('.active').removeClass('active');
				// 淡入相對應的內容並隱藏兄弟元素
				$(_clickTab).stop(false, true).fadeIn().siblings().hide();

				return false;
			}).find('a').focus(function(){
				this.blur();
			});
		});
	});
</script>
</head>


<ul class="tabs">
			<?php do { ?>
			  <li><a href="#tab<?php echo $row_RecZip['level2_id']; ?>"><?php echo $row_RecZip['name']; ?></a></li>
			<?php } while ($row_RecZip = mysql_fetch_assoc($RecZip)); ?>
		</ul>

		<div class="tab_container">
        <?php do { ?>
			<div id="tab<?php echo $row_RecContent['level2_id']; ?>" class="tab_content">
				<h2><?php echo $row_RecContent['name']; ?></h2>        
		<?php 
			$colname_RecZipCode = $row_RecContent['level2_id'];			
			mysql_select_db($database_ksnews3, $ksnews3);
			$query_RecZipCode = sprintf("SELECT * FROM product WHERE level2_id = %s ORDER BY n_id ASC", GetSQLValueString($colname_RecZipCode, "int"));
			$RecZipCode = mysql_query($query_RecZipCode, $ksnews3) or die(mysql_error());
			$row_RecZipCode = mysql_fetch_assoc($RecZipCode);
			$totalRows_RecZipCode = mysql_num_rows($RecZipCode);
		?>
        
  <?php do { ?>
				
  <?php if ($totalRows_RecZipCode > 0) { // Show if recordset not empty ?>  
  <?php if($row_RecZipCode['b_url']!=""){ ?>
  <span id="reczipcode">
  <a href="<?php echo $row_RecZipCode['b_url'];?>">
  <img src="images/star.png" width="16" height="16" /> <?php echo $row_RecZipCode['n_name']; ?></a></span>
  <?php } else { ?>
  <span id="reczipcode">
  <a href="cx_bnb_detail.php?id=<?php echo $row_RecZipCode['n_id'];?>&amp;hits=true"> 
  <img src="images/star.png" width="16" height="16" /> <?php echo $row_RecZipCode['n_name']; ?></a></span>
  <?php } ?>
  <?php } // Show if recordset not empty ?>                
        <?php } while($row_RecZipCode = mysql_fetch_assoc($RecZipCode)); ?>
		</div>
       	<?php } while($row_RecContent = mysql_fetch_assoc($RecContent)) ; ?>
		</div>