<?php
include '../Connections/ksnews3.php';
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

mysql_select_db($database_ksnews3,$ksnews3);
$Town = sprintf("SELECT * FROM level2 WHERE level1_id= %s ORDER BY level2_id ASC",GetSQLValueString($_POST["city"],"text"));
$Town_rs = mysql_query($Town);
echo $Town_rs;
$Town_num = mysql_num_rows($Town_rs);
if ($Town_num > 0) {//縣市編號帶入後如果有資料存在顯示底下區域內容回傳
    echo "<option value=''>請選擇鄉鎮</option>";
    while ($Town_rows = mysql_fetch_array($Town_rs)) {
        echo "<option value='" . $Town_rows["level2_id"] . "'>" . $Town_rows["name"] . "</option>";
    }
} else {//縣市編號帶入後如果有資料存在顯示底下內容回傳
    echo "<option value=''>請選擇鄉鎮</option>";
}
?>