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
        <script>
            var passwordChange_cleaned_field= false;
           function vaciar(ev){
               if( !passwordChange_cleaned_field ){
                ev.target.value= "";
                passwordChange_cleaned_field= true;
               }
            }; 
            
            
        </script>
    </head>
    <body class="bg-dark">
     

           
    <?php  $this->load->view("plantillas/enlaces");  ?> 
        <div class="container col-sm col-md-6 bg-dark text-light" id="mensajes"></div>
        <div class="container col-sm col-md-6 bg-dark">
        <h3 class="text-light">Actualizar clave de acceso</h3>
        </div>

        <div id="edit-user" class="container col-md-6 col-sm bg-dark"> 
                <div class="container col-sm col-md-6 bg-dark text-warning" id="mensajes"></div> 
                <?php  echo form_open('usuario/passChange', array("id"=> "changepass", "onsubmit" => "verificar(event)") ); ?>
                <input type="hidden" name="cedula" value="<?= $this->session->userdata("id") ?>"/>
                <label class="text-light"  for="clave-a">Clave actual</label>
                <input onchange="vaciar(event)"  class="form-control" type="password"  name="clave-a"   maxlength="20"  />
                <label class="text-light"  for="clave-n">Clave nueva</label>
                <input class="form-control" type="password" name="clave-n"  maxlength="20"  />
                <br>
                <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
        </div>
        
         
        <script type="text/javascript" src= "<?= base_url("/assets/jquery-3.4.1.min.js") ?>" ></script>
        <script  type="text/javascript" src="<?= base_url("/assets/popper.min.js")?>"  ></script>
        <script src="<?= base_url("/assets/bootstrap.min.js")?>"  ></script>

        <script> 
            
            function camposLlenos(){
                if($("input[name=clave-a]").val() =="") alert("Proporcione su clave actual");
                if($("input[name=clave-n]").val() =="") alert("Proporcione su clave nueva");
                return  ($("input[name=clave-n]").val() !="")  && ($("input[name=clave-a]").val() !="") 
            }


            function cambiarPass(){
                $.ajax({
                    url:"/crediweb/usuario/passChange",
                    method: "post",
                    data: $("#changepass").serialize(),
                    success: function(res){
                        try{
                            $("#mensajes").html( "");
                            let ob= JSON.parse( res );
                            if("error" in ob) alert("Error: "+ob.error);
                            if("OK" in ob) alert( ob.OK);
                            $("#changepass")[0].reset();

                        }catch( ee){
                            $("#edit-user").html( res);
                            $("#mensajes").html( "");
                        }
                       
                    },
                    beforeSend: function(){
                        $("#mensajes").html( "Espere un momento...");
                    }

                });
            }



            function verificar( evt){
                evt.preventDefault();
                $("button[type=submit]").attr("disabled", true);
                if( camposLlenos() ){    
                     cambiarPass(); 
                }else{      console.log("falta llenar campos");    }
            }


        </script>

    </body>
</html>