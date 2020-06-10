function messageCode1(){
    let html='<button type="button" class="btn btn-secondary" data-dismiss="modal">VER M&Aacute;S TARDE</button> ';
	html= html+'<a   href="/taxi_web/cliente/ofertas_r" class="btn btn-success">IR A OFERTAS RECIBIDAS</a> ';
    console.log( html);
    $("#modal-botones").html( html);				
        //$("#irDetalle").attr("href",  $("#irDetalle").attr("href")+ payload.id_flete);
}

function messageCode2(){
    let html='<button type="button" class="btn btn-secondary" data-dismiss="modal">VER M&Aacute;S TARDE</button> ';
	html= html+'<a   href="/taxi_web/proveedor/ofertas_e" class="btn btn-success">IR A OFERTAS ENVIADAS</a> ';
 
    $("#modal-botones").html( html);				
        //$("#irDetalle").attr("href",  $("#irDetalle").attr("href")+ payload.id_flete);
}

function messageCode3( idflete){
    let html='<button type="button" class="btn btn-secondary" data-dismiss="modal">DECIDIR M&Aacute;S TARDE</button> ';
	html= html+'<a   href="/taxi_web/cliente/aceptar_transac/'+idflete+'" class="btn btn-success">ACEPTAR</a> ';
    $("#modal-botones").html( html);				
}


function messageCode4( idcliente){
    let html='<button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button> ';
	html= html+'<a   href="/taxi_web/cliente/view/'+idcliente+'" class="btn btn-success">VER DATOS DE CLIENTE</a> ';
    $("#modal-botones").html( html);				
}



function showNotification( payload ){
    console.log( payload); 
    switch( parseInt(payload.code) ){
        case 1:  messageCode1();break;//proveedor ha propuesto un precio
        case 2: messageCode2();break;//cliente ha aceptado precio de proveedor
        case 3: messageCode3( payload.id_flete );break;//proveedor solicitar concretar
        case 4: messageCode4( payload.cliente);break;//cliente ha concretado
    }
    $("#modal-titulo").text( payload.title);
    $("#modal-cuerpo").text( payload.body);
    $('#modal-comun').modal('show');
}


function mostrarUsuariosActivos( data ){
    console.log("mostrarUsuariosActivos");
    if( data.on=="1" &&  data.user != "-")
    {
        let rw=  `<tr id='${data.user}'><td>${data.user}</td></tr>`;
        $("#online-users tbody").append(  rw);
    }else{//borrar
        $("#"+data.user).remove(); 
    }
}




function activarUsuario() {//online
    console.log(" ACTIVANDO USUARIO ");
    if( localStorage.getItem("taxicargas_useronline") != "on"){
      //token
    Fcm.obtenerToken().then(function (ar) {
        console.log("TOKEN: ", ar);
        let dta=  {token: ar };
        $.ajax({
             url: "/taxi_web/usuario/user_status/1",
              method:"post", 
              data: dta  ,
              success: function(ar){ 
                  console.log( "Usuario: ON" ) ;
                  localStorage.setItem("taxicargas_useronline", "on");
                },
            error: function(xhr, texterr){
                alert( texterr);
            }
            }  
         );
    });
    }//end if
    else{
        console.log("USUARIO YA ESTA ON");
    }
}/*** */

function desactivarUsuario() {//online
    //token
    Fcm.obtenerToken().then(function (ar) {
        fetch("/taxi_web/usuario/user_status/0",
        {
            method: 'post',
            body: JSON.stringify(  {token: ar })
          }).then(
            function (response) {  
                console.log( "Usuario: OFF" ) ;
                localStorage.setItem("taxicargas_useronline", "off");
            }
        );
    });
}