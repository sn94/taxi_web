<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="manifest" href="/taxi_web/manifest.json">

	<title>TAXICARGA-PROVEEDORES DISPONIBLES </title>
	<link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
    <link rel="stylesheet" href="<?= base_url("/assets/taxi.css")."?v=".rand() ?>" /> 
    <link rel="stylesheet" href="<?= base_url("/assets/jqueryui/jquery-ui.css") ?>" />

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
  
	<div class="container-fluid m-1" >  
				
               	
    <div class="container  bg-warning">
        <h1 class="text-center">
            <?= $tipo=="c"? "NUEVO CLIENTE": "NUEVO PROVEEDOR" ?>
        </h1>
    </div>
<div class="container">

   
    <?php   echo form_open("usuario/sign_up/$tipo") ;  ?>
        <div class="row">
                       
            <div class="col-md-6">
                       
                Nick:<input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Nick de usuario" name="nick">
                Contrase&ntilde;a:<input class="form-control form-control-sm form-control-md mt-1" type="password" placeholder="Clave" name="passw">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Nombres" name="nombre">
                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Apellidos" name="apellido">
                <select class="form-control form-control-sm form-control-md mt-1"    id="depart"  ></select>
                <input type="hidden" name="depart"> 

                <select class="form-control form-control-sm form-control-md mt-1"   id="ciudad"></select>
                <input type="hidden" name="ciudad"> 

                <input class="form-control form-control-sm form-control-md mt-1" type="text" placeholder="Barrio" name="barrio">
                <br>
                <!--TOKEN DE REGISTRO CLOUD MESSAGING -->
                <input type="hidden" name="id_token">
                <input type="hidden" name="modo" value="<?=  $tipo ?>">
        
            </div>
            <div class="col-md-6"> 
                            
                <input class="form-control form-control-sm form-control-md mt-1" type="tel" placeholder="Telefono" name="telefono">
                <input class="form-control form-control-sm form-control-md mt-1" type="tel" placeholder="Celular" name="celular">
                <label for="est_civil"  >Estado civil:</label>
                <select name="est_civil" id="" class="form-control form-control-sm form-control-md">
                    <option value="S">SOLTERO/A</option>
                    <option value="C">CASADO/A</option>
                    <option value="CO">CONCUBINO/A</option>
                    <option value="V">VIUDO/A</option>
                </select>
                <input class="form-control form-control-sm form-control-md mt-1" type="text" readonly placeholder="Fecha de nacimiento" name="fecha_nac" id="fechanac">
                <input class="form-control form-control-sm form-control-md mt-1" type="number" placeholder="Nro. de cedula" name="cedula" oninput="numericInput(event)">
                <?= form_error('cedula'); ?>

                <!--AUTORIZAR NOTIFICACIONES -->
                <div class="form-check" id="notification-verify">
                    <input onchange="permiso(event)" class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">

                        Enviarme notificaciones sobre nuevos clientes

                    </label>
                </div>
                <div id="mensaje" >  </div>
                <button type="submit" class="btn btn-success btn-sm d-block invisible">ENVIAR</button>
                              
            </div>
        </div> 
    </form>
</div>
            
          
				 
</div><!-- end container fluid -->
</main> 

<?php   $this->load->view("plantillas/footer"); ?>
	 


	<script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
    <script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
    <script src="<?= base_url("/assets/jqueryui/jquery-ui.js") ?>" ></script>
    <script src="<?= base_url("/assets/my_js.js")?>"  ></script>
    <script src="<?= base_url("/assets/citydata.js") ?>" ></script>
    <script src="<?= base_url("/assets/gui_refresh/refresh.js")?>"  ></script>
    <script src="<?= base_url("/firebase-app.js")?>"  ></script>
	<script src="<?= base_url("/firebase-messaging.js")?>"  ></script>
    <script src="<?= base_url("/assets/fcm/init.js")?>"  ></script>
  
    
<script>
	//inicializacion
    var  monthNames= [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
	var dayNamesMin= [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ];
	$("#fechanac").datepicker( { monthNames: monthNames,dayNamesMin: dayNamesMin } );
    
    

City_data.datosGeo( "#depart","#ciudad"); 


//permiso para recibir notificaciones
function permiso( ev){
 
    if( ev.target.checked ){//casilla marcada
        //acciones- de espera
        let waiting= function(){
            let im= '<img src="/taxi_web/assets/img/loading.gif" alt="Procesando...">';
            $("#mensaje").html(  im);
             
        };
        
        //acciones - obtencion exitosa del token
        let hacer=    function( ag) { 
           //asignar valor de token a campo
            $("input[name=id_token]").val(  ag); 
            //mostrar boton
            $("button[type=submit]").removeClass("invisible"); $("button[type=submit]").addClass("visible");  
            //borrar mensajes
            $("#mensaje").html("");
        }; 
        //acciones - error al obtener token
        let hacer_= function(){
            //borrar mensajes
            $("#mensaje").html("Hubo un error al procesar los datos");
            //desmarcar casilla
            $("#defaultCheck1").prop("checked", false); 
            //ocultar boton de envio
            $("button[type=submit]").removeClass("visible");  $("button[type=submit]").addClass("invisible");
        };

        //verifica/solicita permiso al usuario para enviarle notificaciones
        //luego se instala el service worker
 
        waiting();
        Fcm.requestPermissionToGetToken().
        then( function( ar){ //todo resulto bien, podemos obtener el token
            if( ar)    Fcm.obtenerToken().then(  hacer );
            else hacer_();
         } ).
        catch(  hacer_);
       
       
    }else{//casilla desmarcada
        alert("Para continuar con el registro, habilite las notificaciones por favor");
        //ocultar boton de envio
        $("button[type=submit]").removeClass("visible");   $("button[type=submit]").addClass("invisible");     
    }
   
}
   

  

 

			
	</script>

</body>
</html>