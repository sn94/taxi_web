<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Informes</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="<?= base_url("/assets/bootstrap/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("/assets/xls_gen/tableexport.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("/assets/datatables/datatables.min.css") ?>" /> 
      
    <style>
        .table {
            font-size: 12px;

        }

        .table tbody tr td {
            padding-top: 0px;
            padding-bottom: 0px;
        }
    </style>

</head>

<body class="bg-dark">

    <?php $this->load->view("plantillas/enlaces"); ?>

    <div class="container col-sm col-md-6 bg-dark text-warning" id="mensajes"></div>
    <div class="container col-md-6 col-sm mt-3 bg-dark">
        <h3 class="text-light">Informes</h3>

        <div class="row">

            <div class="col-sm">
                <label class="text-light">Tipo de usuario:</label>

                <div class="form-check">
                    <input onchange="settear(event)" class="form-check-input" type="radio"  checked value="0" name="opc">
                    <label class="form-check-label text-light"  >
                        TODOS
                    </label>
                </div>
                <div class="form-check ">
                    <input onchange="settear(event)" class="form-check-input" type="radio"   value="V" name="opc">
                    <label class="form-check-label text-light"  >
                        Vendedor
                    </label>
                </div>
                <div class="form-check ">
                    <input onchange="settear(event)"  class="form-check-input" type="radio" value="A" name="opc">
                    <label class="form-check-label text-light" >
                        Administrativo
                    </label>
                </div>
                <div class="form-check ">
                    <input onchange="settear(event)"  class="form-check-input" type="radio" value="S" name="opc">
                    <label class="form-check-label text-light" >
                        Supervisor
                    </label>
                </div>
 
            </div>

        </div>
    </div>

    <div class="container col-sm col-md-6 bg-dark">

        <div class="mt-2 btn-group btn-group-sm" role="group" aria-label="Basic example">
            <a  id="pdf" class="btn btn-success" href="/crediweb/usuario/generarPdf/0">PDF</a>
            <button  id="excel" class="btn btn-success" onclick="getDataForXls()">Excel</button>
        </div>

        <h3 class="text-center text-light">Usuarios</h3>
        <div class="table-wrapper-scroll-y my-custom-scrollbar pt-1 pr-1 text-light bg-light">
            <table id="tabla" class="table table-responsive-sm table-responsive-md table-responsive-lg table-bordered  table-hover table-sm">
                <thead class="thead-dark ">
                    <tr>
                        <th>Ci</th>
                        <th>Nombres</th>
                        <th>Usuario</th>
                        <th>Celular</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $item) { ?>
                        <tr class="table-secondary">
                            <td><?= $item->cedula ?></td>
                            <td><?= $item->nombres ?></td>
                            <td><?= $item->usuario ?></td>
                            <td><?= $item->telefono . "<br>" . $item->celular ?></td>
                            <td><?= $item->tipousuario == "V" ? "vendedor" : ($item->tipousuario == "A" ? "administrativo" : "supervisor") ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>




    <script type="text/javascript" src="../assets/jquery/jquery-3.4.1.min.js"></script>
    <script  type="text/javascript" src="../assets/jquery/popper.min.js"  ></script>
    <script type="text/javascript" src="../assets/xls_gen/FileSaver.min.js"></script>
    <script type="text/javascript" src="../assets/xls_gen/xlsx.full.min.js"></script>  
    <script src="../assets/bootstrap/bootstrap.min.js"></script>
     <!-- DATATABLES -->
     <script src="<?= base_url("/assets/datatables/datatables.min.js")?>"  ></script>
    <script src="../assets/my_js.js<?= "?v=".rand() ?>"></script>
    <script type="text/javascript" >

        
        
        $('#tabla').DataTable(  ); 
 



        var rutapdf="/crediweb/usuario/generarPdf";
        var rutaxls="/crediweb/usuario/list";
        var opc= "0";
        function settear( ev){
            opc= ev.target.value; 

            $("#pdf").attr("href", rutapdf+ "/"+ opc);
            $("#excel").attr("href", rutaxls + "/"+ opc);
            refillTable();
        }

 

        function getDataForXls(){
            let showMsg= function(){  $("#mensajes").html("Creando archivo xls/xlsx..."); }
           
           //Obtencion de datos de la base de datos para cargarlo a un archivo xls
            let dta= { 
                url:  rutaxls+"/"+opc , 
                method:"get", 
                success: (res)=>{createWorkBook(res,"Usuario")}, 
                beforeSend: showMsg }
            $.ajax( dta); 
        }

        
       

        function cleanTable(){
            $("table tbody").empty();
        }

        function refillTable( ){
            cleanTable();
            let filling= function( datos){
                
                let lst= JSON.parse( datos);
                lst.forEach( (lst)=>{
                    let s_row= ` <tr  class="table-secondary"> <td>${lst.cedula}</td>  <td>${lst.nombres}</td>  <td>${lst.usuario}</td>  <td>${lst.celular}</td> <td>${ lst.tipousuario == "V" ? "vendedor" : (lst.tipousuario == "A" ? "administrativo" : "supervisor")  }</td>  </tr>`;
                    $("table tbody").append( s_row);
                });
               
                $("#mensajes").html("");
                                            };
            
            let showMsg= function(){   $("#mensajes").html("Espere un momento...");   };
        
            let dta= { url:  rutaxls+"/"+opc , method:"get", success: filling, beforeSend: showMsg };
            $.ajax( dta); 
        }

       
       
    </script>



</body>
                

</html>