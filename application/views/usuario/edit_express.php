<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Editar usuario</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
        
        <link rel="stylesheet" href="<?= base_url("/assets/awesomplete/awesomplete.css") ?>" /> 
        <style>
        .input-group-text{
            padding: 0px;
        }
        .button-search{
            height: 100%;
            width:100%;
            margin: 0px;
        }
        </style>
        <script>
        var verificar;

        </script>
    </head>
    <body class="bg-dark">
     

           
    <?php  $this->load->view("plantillas/enlaces");  ?> 
        <div class="container col-sm col-md-6 bg-dark text-light" id="mensajes"></div>
        <div class="container col-sm col-md-6 bg-dark">
        <h3 class="text-light">Editar Usuario</h3>
        </div>

        <div id="edit-user" class="container col-md-6 col-sm bg-dark"> 
         
        <?php    $this->load->view("usuario/edit_data", $datos) ?>

        </div>
        
         
        <script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
        <script  type="text/javascript" src="<?= base_url("/assets/jquery/popper.min.js")?>"  ></script>
        <script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
        <script src="<?= base_url("/assets/my_js.js")."?v=".rand() ?>"  ></script>
        <script>
        
        var nickInicial= "<?= $datos->usuario ?>";
         //evitar registrar  nicks ya existentes
         function usuarioYaExiste(evt){

                let nick= $("#nick").val();
                if( nick == nickInicial){
                    peticionWithMsg(evt, '#edit-user');
                    $("#nick-busq").val("");
                }else{
                    let ruta= "/crediweb/usuario/getByName/"+nick+"/1";
                    let success_func=  function(ar){
                    try{ 
                            let res= JSON.parse( ar ); 
                            if( "error"  in res){ //el nick esta libre para usarse, no esta registrado
                                peticionWithMsg(evt, '#edit-user');
                                $("#nick-busq").val("");
                            }
                            else  alert("El nick '"+ nick+"' ya esta registrado");
                            $("#mensajes").html("");
                        }catch( er ){}   
                    };

                    $.ajax( {url: ruta, success: success_func, beforeSend: function(){
                    $("#mensajes").html("Espere un momento...");
                    }});
                }
                 
            }


            verificar= function( evt){
            evt.preventDefault();
            usuarioYaExiste(evt); 
            }






        function checkErrorBeforeEdit(res){
                try{ //El mensaje de error 
                    let res_json= JSON.parse( res);  
                    if( "error" in res_json){    alert(  res_json.error);   }
                }
                catch(er){
                    $("#mensajes").html("");
                    $( "#edit-user").html( res );
                }
            }



        
            $(document).ready( function(){
                $('select').val('<?= $datos->tipousuario?>');   
                $('select').attr("readonly", "readonly");
                
                });

        </script>

    </body>
</html>