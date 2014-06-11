<?php require_once('../Connections/ksnews3.php'); ?>
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
?>
<script type="text/javascript" src="../js/jquery-1.6.1.min.js"></script>
<script type="text/javascript">
            $(document).ready(function(){
                //利用jQuery的ajax把縣市編號(CNo)傳到Town_ajax.php把相對應的區域名稱回傳後印到選擇區域(鄉鎮)下拉選單
                $('#position').change(function(){
                    var CNo= $('#position').val();
                    $.ajax({
                        type: "POST",
                        url: 'zone_ajax.php',
                        cache: false,
                        data:{
							CNo : CNo,
						},
                        error: function(){
                            alert('Ajax request 發生錯誤');
                        },
                        success: function(data){
                            $('#zone').html(data);
							$('#zip').html("<option value=''>選擇區塊</option>");
                        }
                    });
                });
                //根據選擇區域(鄉鎮)的編號傳到Zip_ajax.php把區域對應的郵遞區號印到指定的郵遞區號欄位
				
				$('#zone').change(function(){
					var zone = $('#zone').val();
					$.ajax({
						type: "POST",
                        url: 'zone_ajax.php',
                        cache: false,
						data:'zone='+zone,
						error:function(){
							alert('Ajax request 發生錯誤');
						},
						success:function(data){
							$('#zip').html(data);
						}
					});
				});
            });
        </script>
</head>

位置
<select name="position" id="position">
                        <option value="">選擇位置</option>
                        <?php
                        $position = "SELECT * FROM banner_position ORDER BY type_id ASC";
                        $position_rs = mysql_query($position);
                        while ($position_rows = mysql_fetch_array($position_rs)) {
                            ?>
                            <option value="<?php echo $position_rows["chained"] ?>"><?php echo $position_rows["type_name"]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <select name="zone" id="zone">
                      <option value="">選擇區塊</option>
</select>
					<select name="zip" id="zip">
                    <option value="" selected="selected">選擇區塊</option>
                    </select>

