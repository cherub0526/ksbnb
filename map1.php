<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//maps.google.com/maps?file=api&v=2&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
    var i;
    var split;

    function trans() {
        i = 0;
        $("#target").val("");
        var content = "台北市信義區市府路1號";
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

</head>

<body>
<div id="map" style="width:650px; height:350px;align=left"></div>
</body>
</html>