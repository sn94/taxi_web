<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" />
        <link rel="stylesheet" href="<?= base_url("/assets/taxi.css") ?>" /> 
       <style>

           body{
               background-image: url("../assets/img/taxi_login.png");
               background-repeat: no-repeat;
                background-position: left top;
                background-attachment: fixed; 
                background-size: 500px auto;
                background-color: #ffff00;
                
           }
       </style>

        
        
    </head>
    <body class="bg-warning">
     
        <div class="container col-md-3 col-sm" style="background-color:  #ffe084E4;height:100%;"> 

                        <div id="test"></div>
                        <h1 class="text-center">INGRESAR</h1>

                        <?php 
                            if( isset( $errorSesion) ){
                                $this->load->view("plantillas/error", array("mensaje"=> $errorSesion ));

                            }
                        ?>
                        <div id="login" class="container-fluid">

                        <?php echo form_open('usuario/sign_in'); ?>
                                <label   for="usua" class="font-weight-bold">Usuario</label>
                                <input   class="form-control" type="text" id="usu"  name="usuario"   />
                                <br>
                                <label  for="pass" class="font-weight-bold">Password</label>
                                <input    class="form-control" type="password" id="passw" name="passw"    /> 
                                <br>
                                <input type="hidden"  name="tipo" id="tipouser" />
                                <button class="btn btn-success  col-sm col-md-12" type="submit">Ingresar</button>
                            </form>
                        </div> 
                        <div class="container-fluid text-warning" id="mensajes"></div>
                
        </div>


    <script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
    <script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>

    <script type="text/javascript" src="<?= base_url("/assets/my_js.js") ?>" ></script>
   
   
   <script> 

    var tipoDeUsuario="";

    /**EXISTE USUARIO? */
    function userExists(){
        return new Promise((exito, fallo)=>{
            let name= $("#usu").val();
            $.ajax( { async: false, url:"/crediweb/usuario/getByName/"+name, success:function(res){
                let obj= JSON.parse(  res );
                if( "error" in obj){   alert("El usuario "+name+" no existe"); fallo();
                }else{   $("#tipouser").val(  obj.tipousuario );    exito();   }
            }}
            );
        });
        
    }
    /**nick ingresado */
    function nickIngresado(){
        if( $("#usu").val() == "")
       { alert("Ingrese su nick"); $("#usu").focus();
        return false;}  return true; 
    }
    /** PASSWORD INGRESADA */
    function passwordIngresado(){
        if( $("#pass").val() == "")
       { alert("Ingrese su clave");
        return false;}  return true; 
    }

     
 
       

       

 
        


    function ciudades(){
        $.get("/crediweb/assets/ciudades.json", function( res){
            console.log( res);
            document.getElementById("test").innerHTML= res;
        } );
    }


    
      </script>
  
        </body>
</html>