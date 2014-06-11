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
$query_RecCity = "SELECT * FROM level1 ORDER BY level_id ASC";
$RecCity = mysql_query($query_RecCity, $ksnews3) or die(mysql_error());
$row_RecCity = mysql_fetch_assoc($RecCity);
$totalRows_RecCity = mysql_num_rows($RecCity);




?>
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
                <?php
do {  
if($row_RecCity['name']!="") {
?>
                <option value="<?php echo $row_RecCity['level_id']?>"><?php echo $row_RecCity['name']?></option>
                <?php
}} while ($row_RecCity = mysql_fetch_assoc($RecCity));
  $rows = mysql_num_rows($RecCity);
  if($rows > 0) {
      mysql_data_seek($RecCity, 0);
	  $row_RecCity = mysql_fetch_assoc($RecCity);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td width="67">鄉鎮：</td>
            <td width="68" align="center"><label for="b_zip"></label>
              <select name="b_zip" id="b_zip">
</select></td>
          </tr>
          
          <tr>
            <td>價格範圍：</td>
            <td><label for="lowprice"></label>
              <span id="sprytextfield1">
              <input name="lowprice" type="text" id="lowprice" size="10" />
<span class="textfieldInvalidFormatMsg">格式無效。</span></span> ~
<label for="highprice"></label>
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
<?php
mysql_free_result($RecCity);
?>
