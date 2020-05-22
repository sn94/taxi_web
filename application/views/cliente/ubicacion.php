<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>

  <iframe src="https://www.google.com/maps/@-25.3489085,-57.4514132,15z" id="mimap"></iframe> 



    <div id="map"></div>
    <script type="text/javascript" src="../assets/jquery/jquery-3.4.1.min.js"></script>
    <script>


      function useGoogleMap( lat, lon){
        let ruta= "https://maps.googleapis.com/maps/api/js?key=AIzaSyCWMYnHa93l-Lg9vyWQ5lgnLLmv2c3Vc18&latlng="+  lat + "," + lon +"&sensor=false";
        var img= document.createElement("img");
        img.src= ruta;
        document.getElementById("map").appendChild( img) ;
                  
      }

      function analizar(){
        $.ajax({
          url:"https://www.google.com/maps/@-25.3489085,-57.4514132,15z",
          success:
              function(res){
                console.log( res);
              },
          headers: { "Access-Control-Allow-Origin": "*"}
        });
      }
    function solicitarUbicacion(){
                    //Pedir activación de ubicación
            if (navigator.geolocation) navigator.geolocation.getCurrentPosition(function(pos) {
                
                //Si es aceptada guardamos lo latitud y longitud
                var lat = pos.coords.latitude;
                var lon = pos.coords.longitude;
                console.log("lat", lat, "long", lon);
                useGoogleMap( lat, lon);
            }, function(error) {

                //Si es rechazada enviamos de error por consola
                console.log('Ubicación no activada');
            });

    }
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
    </script>
     
  </body>
</html>