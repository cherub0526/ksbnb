<?php
require_once('../Connections/ksnews3.php');
if(isset($_POST['CNo']) && isset($_POST['CNo'])!=""){
mysql_select_db($database_ksnews3,$ksnews3);
$zone = "select * from city where c_zone='" . $_POST["CNo"] . "'";
$zone_rs = mysql_query($zone);
$zone_num = mysql_num_rows($zone_rs);
if ($zone_num > 0) {//縣市編號帶入後如果有資料存在顯示底下區域內容回傳
    while ($zone_rows = mysql_fetch_array($zone_rs)) {
        echo "<option value='" . $zone_rows["c_zip"] . "'>" . $zone_rows["c_name"] . "</option>";
    }
} else {//縣市編號帶入後如果有資料存在顯示底下內容回傳
    echo "<option value=''>選擇區塊</option>";
}
}

if(isset($_POST['zone']) && isset($_POST['zone'])!=""){
mysql_select_db($database_ksnews3,$ksnews3);
$zip = "SELECT * FROM city WHERE c_zone='".$_POST['zone'] ."'";
$zip_rs = mysql_query($zip);
$zip_num = mysql_num_rows($zip_rs);
if ($zip_num > 0) {//縣市編號帶入後如果有資料存在顯示底下區域內容回傳
    while ($zip_rows = mysql_fetch_array($zip_rs)) {
        echo "<option value='" . $zip_rows["c_zip"] . "'>" . $zip_rows["c_name"] . "</option>";
    }
} else {//縣市編號帶入後如果有資料存在顯示底下內容回傳
    echo "<option value=''>選擇區塊</option>";
}
}
?>
