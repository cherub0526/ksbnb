<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <link href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css" />
  <link href="" rel="stylesheet" type="text/css" />
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script>
    $(document).on("mobileinit", function () {
      $.mobile.autoInitializePage = false;
      $.mobile.hashListeningEnabled = false;
    });

    function mobileInitPage() {
      $.mobile.hashListeningEnabled = true;
      $.mobile.initializePage();
    };
  </script>
  <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
  <script src="http://jqmdesigner.appspot.com/cordova.js"></script>
  <!-- GK Loader use RequireJS to load module -->
  <script src="http://requirejs.org/docs/release/2.1.9/minified/require.js"></script>
  <!--Plug in GK-->
  <script src="http://jqmdesigner.appspot.com/components/jquery.gk/jquery.gk.min.js"></script>
  <!-- Load GK components -->
  <script components="http://jqmdesigner.appspot.com/components/gk-ext/gmap.html,http://jqmdesigner.appspot.com/components/gk-ext/bxslider.html" callback="mobileInitPage" src="http://jqmdesigner.appspot.com/components/gk-loader/gk-loader.js"></script>
  <!-- Export JS  -->
  <script>
    $(document).on("pageshow", function () {
      /* Powered by http://bxslider.com/ */
      $(".bxslider").bxSlider();
    });
    /*** code gen by capture-photo  ***/
    $(document).on("gkComponentsReady", function () {
      $("#gk-421sM79-btn").on("click", function () {
        if (navigator.camera) {
          navigator.camera.getPicture(
            // Called when a photo is successfully retrieved
            function (imgData) {
              // Set image
              $("#gk-421sM79-img").attr("src", "data:image/jpeg;base64," + imgData);
            },
            // Called if something bad happens
            function (msg) {
              alert("Failed because: " + msg);
            },
            // Camera options
            {
              quality: 50,
              destinationType: navigator.camera.DestinationType.DATA_URL
            });
        }
      });
    });
    $(document).on("gkComponentsReady", function (w) {
      var img = [{
        "data-src": "http://www.dropmysite.com/images/social/icon-google.png?1386321977"
      }, {
        "data-src": "http://www.dropmysite.com/images/social/icon-facebook.png?1386321977"
      }, {
        "data-src": "http://www.dropmyemail.com/assets/icon-twitter-963acb3e091cfea4ef6394d6c3b9e388.png"
      }];
      $("#gk-421uSWo").gk("model", img);
      $("#gk-421uSWo").gk("onclick", function (e) {
        alert(e.target);
      });
    });
    /*** code gen by gk-position  ***/
    ;
    $(document).on("gkComponentsReady", function () {
      function onSuccess(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        $("#gk-4214P3s").html("Latitude: " + latitude + "<br /> Longitude: " + longitude);
      }

      function onError(error) {
        // onError Callback receives a PositionError object  
      }
      if (navigator.geolocation) {
        var watchID = navigator.geolocation.watchPosition(onSuccess, onError, {
          timeout: 10000
        });
      }
    });
  </script>
  <title>EZo App</title>
</head>

<body>
  <!-- Page: home  -->
  <div id="home" data-role="page">
    <div data-role="header" data-position="fixed" data-fullscreen="" data-theme="a">
      <h3>民宿網</h3>
    </div>
    <div role="main" class="ui-content">
      <div class="ui-field-contain">
        <label for="gk-4210zR4" class="ui-hidden-accessible"></label>
        <input type="search" name="" id="gk-4210zR4" placeholder="請輸入民宿名稱">
      </div>
      <ul is="bxslider" style="height:100%;width:100%" captions="true" class="bxslider">
        <li>
          <img style="width:100%;height:100%" src="http://i.imgur.com/b9h4ILl.png" title="Funky roots">
        </li>
        <li>
          <img style="width:100%;height:100%" src="http://i.imgur.com/vnxjGeS.jpg">
        </li>
        <li>
          <img style="width:100%;height:100%" src="http://i.imgur.com/9md2qds.jpg">
        </li>
      </ul>
      <div data-role="collapsibleset">
        <div data-role="collapsible" data-collapsed="true">
          <h3>花蓮縣</h3>
          <ul data-role="listview" data-inset="true">
            <li>
              <a href="#">
                <img src="http://jqmdesigner.appspot.com/images/image.png" class="ui-li-icon">Item</a>
            </li>
          </ul>
        </div>
        <div data-role="collapsible" data-collapsed="true">
          <h3>台東縣</h3>
          <ul data-role="listview" data-inset="true">
            <li>
              <a href="#">
                <img src="http://jqmdesigner.appspot.com/images/image.png" class="ui-li-icon">Item</a>
            </li>
          </ul>
        </div>
      </div>
      <div is="gmap" style="width:100%;height:200px;" zoom="12" address="Qianzhen, TW"></div>
    </div>
    <div data-role="footer" data-position="fixed">
      <div data-role="navbar">
        <ul>
          <li>
            <a data-icon="home">首頁</a>
          </li>
          <li>
            <a data-icon="grid">精選民宿</a>
          </li>
          <li>
            <a data-icon="grid">超值民宿</a>
          </li>
          <li>
            <a data-icon="grid">關於我們</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</body>

</html>
