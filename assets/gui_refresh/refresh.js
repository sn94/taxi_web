function mostrarUsuariosActivos( data ){
    if( data.on=="1")
    {let rw=  "<tr><td>"+data.user+"</td></tr>";
    $("#online-users tbody").append(  rw);}
    else{//borrar
        $("#online-users tbody").append(  rw);
    }
}




function activarUsuario() {//online
    //token
    Fcm.obtenerToken().then(function (ar) {
        console.log( ar);
        let dta=  {token: ar };
        $.ajax({
             url: "/taxi_web/usuario/user_status/1",
              method:"post", 
              data: dta  ,
              success: function(ar){ console.log(  ar ) ;}
            }  
         );
    });
}

function desactivarUsuario() {//online
    //token
    Fcm.obtenerToken().then(function (ar) {
        fetch("/taxi_web/usuario/user_status/0",
        {
            method: 'post',
            body: JSON.stringify(  {token: ar })
          }).then(
            function (response) {   console.log(response);  }
        );
    });
}