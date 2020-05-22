<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Borrar usuario</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
        

    </head>
    <body class="bg-dark">


           
    <?php  $this->load->view("plantillas/enlaces");  ?> 
 
        <div class="container col-md-6 col-sm bg-dark">
                <h3 class="text-light">Borrar usuario</h3>
                <?php
                $attributes = array('method' => 'get', 'class' => "form-inline", 'onsubmit' => "buscarUsuario(event)");
                echo form_open('usuario/getForReadByNick', $attributes); ?>
                        <h4 class="text-light mr-2">Buscar Nick: </h4>
                        <input  class="form-control" type="text"  id="nick-busq"   />
                        <button  class="btn btn-success" type="submit" > Ok</button>
                </form>
        </div>

        <div  id="btndel"    class="container col-md-6 col-sm invisible bg-dark" > 
                <button class="btn btn-info" type="button"  onclick="confirmarBorrar()">Borrar</button>
        </div>
        <div id="del-user" class="container col-md-6 col-sm bg-dark" > 
         
        </div>

     
      
        <script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
        <script  type="text/javascript" src="<?= base_url("/assets/jquery/popper.min.js")?>"  ></script>
        <script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>



        <script type="text/javascript" src=<?= base_url("/assets/my_js.js") ?> ></script>
      

        <script>

                function mostrarBotonBorrar(){
                    $("#btndel").removeClass("invisible").addClass("visible");
                }
                function ocultarBotonBorrar(){
                    $("#btndel").removeClass("visible").addClass("invisible");
                }
              function checkErrorBeforeDelete(res){
                try{ //El mensaje de error 
                    let res_json= JSON.parse( res); console.log( res_json);
                    if( "error" in res_json){  
                          alert(  res_json.error);  
                          $("#nick-busq").val("")  ;
                        }
                }
                catch(er){
                    $( "#del-user").html( res ); 
                    mostrarBotonBorrar(); 
                }
            }


            function buscarUsuario(ev){
                ev.preventDefault();
                let ruta=  ev.target.action;
                let nick= $("#nick-busq").val();
                $.get( ruta+"/"+nick,  function(res){  checkErrorBeforeDelete(res ); }  ) ;
                
            }

            function showResult( res){
                $( "#del-user").html( res );
            }
        
            function confirmarBorrar(){
              let resp=   confirm("Seguro que desea borrar este registro?");
              if( resp){
                  let ci= $("input[type=text][name=cedula]").val();
                  let url=  "<?= base_url("/usuario/delete/") ?>"+ ci; 
                  $.get( url, showResult); 
                  ocultarBotonBorrar();
                   $("#nick-busq").val("");
              }else{
                $( "#del-user").html( "" ); $("#nick-busq").val("");
              }
            }

        </script>

    </body>
</html>