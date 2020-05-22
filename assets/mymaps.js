
  /*****SOLICITAR UBICACION*********/
  var Latitud= 0.0, Longitud= 0.0;

  var requestLocationPermission=   function( dothis ){
     if( navigator.geolocation){
    console.log("Solicitando permiso");
          navigator.geolocation.getCurrentPosition(  function(  position){
            Latitud= position.coords.latitude;
            Longitud= position.coords.longitude;
             dothis();
            //dis.crearMapa();
           // dis.configurarMarcador();
          }); 
  }};

  var MyMaps= function( contenedor, handler){
    console.log( contenedor);
    this.latitud= 0.0;
    this.longitud= 0.0;
    this.mymap= null;
    this.container= contenedor;
    this.marcador= "";
   
    dis= this; 

     
    
    this.crearMapa= function(){
         console.log("Creando mapa");
        this.mymap = L.map(  this.container).setView([51.505, -0.09], 5);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
          maxZoom: 18,
          attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
          id: 'mapbox/streets-v11',
          tileSize: 512,
          zoomOffset: -1
        }).addTo(  this.mymap);
        
    };

    

    this.configurarMarcador= function(){
        this.mymap.setView( [ this.latitud, this.longitud], 13);
        /********************CONFIGURAR MARCADOR *************************************/
        var taxicon= L.icon({
            iconUrl: 'http://localhost/taxi_web/assets/img/taxicon.png',
            shadowUrl: 'http://localhost/taxi_web/assets/img/taxicon-shadow.png',
  
            iconSize:     [50, 64], // size of the icon
            shadowSize:   [50, 64], // size of the shadow
            iconAnchor:   [22, 80], // point of the icon which will correspond to marker's location
            shadowAnchor: [10, 75],  // the same for the shadow
            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });
          //agrega un marcador al mapa en cierta lat long
          this.marcador= L.marker([ this.latitud, this.longitud], {draggable: true, icon: taxicon} );
          this.marcador.addTo( this.mymap);
          //agregar evento
        this.marcador.on('moveend', function(e){    handler(e.target._latlng) ; } ); 
          /*****************************************************************************/
        //VALORES INICIALES DE UBICACION
        handler(  this.obtenerCoordenada() );


      };
     this.obtenerCoordenada= function(){
        return   this.marcador.getLatLng() ;
    };

   this.latitud= Latitud; 
   this.longitud= Longitud;
   this.crearMapa(); 
  this.configurarMarcador();
   


  };
   

  