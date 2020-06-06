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