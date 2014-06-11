<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" type="text/css"  href="./css/test.css">
    
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&region=zh-tw"></script>
<script> 
		 var address = "花蓮縣光復鄉大全村中山路一段82巷23號";
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
    					 title: 'Click to zoom'
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
<style type="text/css">
html { height: 100% }
body { height: 100%; margin: 0; padding: 0 }
#map { height: 95% ; width: 100% }
#address { width:40%  }
</style>
  </head>
  <body onload = "btnClick()" >
    <div id="map"></div>
      <div id = "panel">
        <input id="address" value="高雄市燕巢區橫山路59號">
        <button>Button</button>
      </div>
  </body>
</html>