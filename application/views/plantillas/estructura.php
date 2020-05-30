<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="manifest" href="/manifest.json">

	<title>TAXICARGAS </title>
	<link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
	<link rel="stylesheet" href="<?= base_url("/assets/taxi.css") ?>" /> 
    <style>
    
    .container {
		width: auto;
		max-width: 680px;
		padding: 0 15px;
		}

	.footer {
	background-color: #f5f5f5;
	}

</style>
</head>

<body class="d-flex   flex-column   h-100 bg-warning">

 
<main role="main" class="flex-shrink-0 align-content-center"  >
  
	<div class="container-fluid m-1" id="principal" >  
				
       
            
          
	</div><!-- end container fluid -->
</main>

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
    <script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
    <script src="<?= base_url("/assets/my_js.js")?>"  ></script>
    <script src="<?= base_url("/assets/fcm/firebase-app.js")?>"  ></script>
	<script src="<?= base_url("/assets/fcm/firebase-messaging.js")?>"  ></script>
    <script src="<?= base_url("/assets/fcm/init.js")?>"  ></script>
    
	<script>

//permiso para recibir notificaciones
function permiso( ev){

    if( ev.target.checked ){
        let hacer= function(){
            //obtener token
        Fcm.obtenerToken().
        then( function( ag) {
            $("input[name=id_token]").val(  ag); 
            //habilitar boton
            $("button[type=submit]").removeClass("invisible");
            $("button[type=submit]").addClass("visible");  

        }).catch( function(){  console.log("Error al obtener token de registro");   });
            };

        let hacer_= function(){
            $("#defaultCheck1").prop("checked", false); 
            $("button[type=submit]").removeClass("visible");
            $("button[type=submit]").addClass("invisible");
        };

        //solicita permiso al usuario para enviarle notificaciones
        //luego se instala el service worker
        Fcm.requestPermission( hacer, hacer_ );
    }else{
        alert("Para continuar con el registro, habilite las notificaciones por favor");
        $("button[type=submit]").removeClass("visible");
        $("button[type=submit]").addClass("invisible");
        
    }
   
}
   

  

 

			
	</script>

</body>
</html>