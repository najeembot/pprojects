<?php
// displaying the target chat person location information
if (@empty($_SERVER['HTTP_REFERER'])) {
    @header("location: ./");
} else {
@ob_start();
@session_start();
@require_once "connect_db.php";
$api_details = $json_data['api_details'];
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="msvalidate.01" content="A2175D7DBFD9B1668012448807EFABC8" />
    <meta name="google-site-verification" content="Ot7digfb6ZQJppEQGIqDM2Gt2Dld4149wcyI26ZOdD8" />
    <meta name="yandex-verification" content="9b3d2af6e3081d2d" />
    <title>Chatz - Locate</title>
    <link rel="icon" type="image/x-icon" href="img/site_icon.ico" />
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?php echo $api_details['API2'][1]; ?>&lang=en_US" type="text/javascript">
    </script>
  </head>
  <body id="locate_page"> 
  <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript">
        let url = window.location.href;
        let user_ip = url.slice(url.indexOf('?user_ip=') + 9, url.length);
        let lat, long;
        // looping through all data from ipstack api regarding the geolocation of the selected user
        fetch("http://api.ipstack.com/"+user_ip+"?access_key=<?php echo $api_details['API1'][1]; ?>").then((resp) => {
            return resp.json().then((data) => {
                lat = data['latitude'];
                long = data['longitude'];
                console.log(data);
                for (key in data) {
                    if (typeof data[key] === 'object') {
                        for (i in data[key]) {
                            if (i == 'languages') {
                                document.querySelector("#location_data").innerHTML += "<h5>"+i.replace(/_/gi," ")+":</h5><p>"+data[key][i][0]['name']+"</p>"; 
                            } else if (i == 'country_flag') {
                                document.querySelector("#location_data").innerHTML += "<h5>"+i.replace(/_/gi," ")+":</h5><img src='"+data[key][i]+"' width='80' height='90' />";
                            } else {
                                document.querySelector("#location_data").innerHTML += "<h5>"+i.replace(/_/gi," ")+":</h5><p>"+data[key][i]+"</p>";   
                            } 
                        }
                    } else {
                        document.querySelector("#location_data").innerHTML += "<h5>"+key.replace(/_/gi," ")+":</h5><p>"+data[key]+"</p>";
                    }
                }
            })
        })
    // The ymaps.ready() function will be called when
    // all the API components are loaded and the DOM tree is generated.
    ymaps.ready(init);
    function init() {  
        // Creating the map. 
           var myMap = new ymaps.Map("map", {
           center: [lat, long], // centering the map view on location
           zoom: 14
        }),
        myGeoObject = new ymaps.GeoObject({
           geometry: {
               type: "Point", // geometry type - point
               coordinates: [lat, long] // centered Geo object or placemark on user's location
            }
        });
        myMap.geoObjects.add(myGeoObject); // Placing the geo object on the map.
    }
</script>
<noscript>Sorry your browser doesn't support javascript or your browser scripting might be disabled</noscript>
    <div class="row">
    <div class="large-10 medium-10 small-8 small-push-2 large-push-1 medium-push-1 columns">
    <br />
    <br />
    <h4 id="locate_title"><?php echo ucwords(strip_tags($_GET['user_fname']))." location"; // printing the located user full name ?></h4>
    <br />
    <!-- the user location on the map plus user location details listed -->
    <div id="map"></div><br />
    <div class="panel radius" id="location_data"></div>
    </div>
    </div>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
  $(document).foundation();
</script>
</body>
</html>
<?php 
}
// @copyRights NajeemB all rights reserved 
?>