<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        
        <link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" /> 
        <link rel="stylesheet" href="<?= base_url("/assets/datatables/datatables.min.css") ?>" /> 
      
       
        <style >
       .table{
           font-size: 12px;
          
       }
       .table tbody tr td{
        padding-top: 0px;
        padding-bottom: 0px;
       }
       </style>

    </head>
    <body class="bg-dark">
     
    <?php   $this->load->view("plantillas/enlaces"); ?>
    
        <div class="container col-md-6 col-sm mt-3 bg-dark">

            <div class="row">
                        <div class="col col-md-4 pt-0 pr-0">
                        <a class="w-100 btn btn-info  btn-sm" href="/crediweb/usuario/create">Agregar</a>
                        </div> 
                        <div class="col col-md-4 pt-0 pr-0 pl-1">
                        <a class="w-100 btn btn-info btn-sm" href="/crediweb/usuario/informes">Informes</a>
                        </div> 
                        <div  class="col col-md-4 pt-0 pr-0 pl-1">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a class="btn btn-success" href="/crediweb/usuario/generarPdf">PDF</a>
                                <button class="btn btn-success" type="button"    onclick="getDataForXls()">Excel</button>
                            </div>
                        </div>
            </div>  
        </div>

        <div class="container col-sm col-md-6 pt-1"> 

            <h3 class=" text-center text-light">Usuarios</h3>
            <div class="table-wrapper-scroll-y my-custom-scrollbar pt-1 pr-1 text-light bg-light">
                    <table id="example" class="table table-responsive-sm table-responsive-md table-responsive-lg table-bordered  table-hover table-sm">
                        <thead class="thead-dark ">
                            <tr><th>Ci</th><th>Nombres</th><th>Usuario</th><th>Celular</th><th>Tipo</th><th></th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($list as $item){?>
                            <tr class="table-secondary">
                                <td id="nom-<?= $item->cedula ?>"><a href="/crediweb/usuario/view/<?= $item->cedula ?>"><?= $item->cedula ?></a> </td>
                                <td id="nom-<?= $item->cedula ?>"><?= $item->nombres ?></td>
                                <td><?= $item->usuario ?></td>
                                    <td><?= $item->telefono."<br>".$item->celular?></td>
                                    <td><?= $item->tipousuario =="V"?"vendedor":  ($item->tipousuario =="A" ? "administrativo": "supervisor")?></td>
                                    <td>
                                    <a   class="w-100 btn btn-light"    href="/crediweb/index.php/usuario/edit/<?= $item->cedula ?>">
                                    <img src="<?= base_url("assets/img/edit.png")?>" />
                                    </a>
                                    </td> 
                                    <td> 
                                        <button   class="w-100 btn btn-light"  onclick="preguntarParaBorrar('<?= $item->cedula ?> ');"  >
                                        <img src="<?= base_url("assets/img/del.png")?>" />
                                        </button>
                                    </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            </div>
        </div>
        


        
    <script type="text/javascript" src= "<?= base_url("/assets/jquery/jquery-3.4.1.min.js") ?>" ></script>
    <script src="<?= base_url("/assets/jquery/popper.min.js")?>"  ></script>
    <script src="<?= base_url("/assets/bootstrap/bootstrap.min.js")?>"  ></script>
     <!-- DATATABLES -->
     <script src="<?= base_url("/assets/datatables/datatables.min.js")?>"  ></script>
         <!--excel-->
         <script type="text/javascript" src="<?= base_url("/assets/xls_gen/xlsx.full.min.js") ?>"></script>
        <script type="text/javascript" src="<?= base_url("/assets/xls_gen/FileSaver.min.js") ?>"></script>
        <script type="text/javascript" src="<?= base_url("/assets/my_js.js")."?v=".rand() ?>"></script>
        
    <script>
        $('.dropdown-toggle').dropdown(); 
         
        function preguntarParaBorrar(cedula){
                if(confirm("Borrar datos de "+$("#nom-"+cedula).text() + "?" ) ){
                    $.get("/crediweb/index.php/usuario/delete/"+cedula, function(res){
                         //eliminar fila de la tabla
                         $("#nom-"+cedula).parent().remove();
                        if( parseInt(res) ){ alert("Usuario eliminado"); }
                    });
                }
            }
            

    


        
        function getDataForXls(){
        let showMsg= function(){
            $("#mensajes").html("Creando archivo xls/xlsx...");
        }; 
       //Obtencion de datos de la base de datos para cargarlo a un archivo xls
        let dta= { 
            url:  "/crediweb/usuario/list" ,
            method:"get", 
            success: (res)=>{createWorkBook(res,"Usuario")}, 
            beforeSend: showMsg }
        $.ajax( dta); 
    }



       $(document).ready( function(){
        $('#example').DataTable(); 
        $('.dropdown-toggle').dropdown(); 
       });

      

    </script>

    </body>
</html>