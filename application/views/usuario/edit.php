<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Editar usuario</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?= base_url("/assets/bootstrap.min.css") ?>" /> 
        
        <link rel="stylesheet" href="<?= base_url("/assets/awesomplete.css") ?>" /> 
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
    </head>
    <body class="bg-dark">
     

           
    <?php  $this->load->view("plantillas/enlaces");  ?> 
        <div class="container col-sm col-md-6 bg-dark text-light" id="mensajes"></div>
        <div class="container col-sm col-md-6 bg-dark">
        <h3 class="text-light">Editar Usuario</h3>
        <?php
        $attributes = array('method' => 'get', 'class'=>'form-inline', 'onsubmit' => "buscarUsuario(event)");
        echo form_open('usuario/getForEditByNick', $attributes); ?>
                <h4 class="text-light mr-2">Buscar Nick: </h4>

                <div class="input-group mb-2 mr-sm-2">
                        <input class="form-control" type="text"  id="nick-busq"  />
                
                        <div class="input-group-prepend">
                            <div class="input-group-text"> <button type="submit" class="btn btn-info button-search" > Ok</button></div>
                        </div>
                    
                </div> 
        </form>
          
        </div>

        <div id="edit-user" class="container col-md-6 col-sm bg-dark"> 
         
        </div>
        
         
        <script type="text/javascript" src= "<?= base_url("/assets/jquery-3.4.1.min.js") ?>" ></script>
        <script src="<?= base_url("/assets/bootstrap.min.js")?>"  ></script>


        <script src="<?= base_url("/assets/awesomplete.js") ?>" async></script>
        <script type="text/javascript" src=<?= base_url("/assets/my_js.js")."?v=".rand()  ?> ></script>



        <script>
        

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


        
            function buscarUsuario(ev){
                ev.preventDefault();
                let ruta=  ev.target.action;
                let ci= $("#nick-busq").val();
                //peticion 
                $.ajax( { url: ruta+"/"+ci, 
                        success: checkErrorBeforeEdit, 
                        beforeSend: function(){
                            $("#mensajes").html("Espere un momento...");
                        } 
                        }); 
            }

        


        </script>

    </body>
</html>