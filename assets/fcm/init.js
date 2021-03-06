
  

  var Fcm= {

    
    messaging: undefined,
    init: function(){

       
        if( !firebase.apps.length ){ 
       console.log("inicializando..");
            // Initialize Firebase
            firebase.initializeApp(  
              {
            apiKey: "AIzaSyB7ib73Cavw4hWCzHKyJcom54RPwkWrLfs",
            authDomain: "taxi-cargas.firebaseapp.com",
            databaseURL: "https://taxi-cargas.firebaseio.com",
            projectId: "taxi-cargas",
            storageBucket: "taxi-cargas.appspot.com",
            messagingSenderId: "60936083686",
            appId: "1:60936083686:web:e8e8240361edaec6c64327"
            }
            );

            this.messaging=  firebase.messaging();
           //esto se invoca solo una vez
            this.messaging.usePublicVapidKey('BK2EVduWVgQ36FtvJXrqzFNSZElVZ6iFRkZtyN26zDvHj6d7qtUtYS7jqmU5M1YoUXY-QUt9RDV_XChuA6JkXt4');
            this.registrarServiceWorker();
            this.eventos(); 
          }else{
            
            this.messaging=  firebase.messaging();  
            this.registrarServiceWorker();
            this.eventos();
          }
          return 0;
           
    },
    hasNotificationSupport: function(){
      
        if (!('Notification' in window)) {
          // el navegador no soporta la API de notificaciones
          alert('Su navegador no soporta la API de Notificaciones :('); 
          return  false;
        }else{   return  true;   }//end else 
    },

    hasNotificationPermission: function( ){
      return new Promise( (good, bad )=>{
        if( this.hasNotificationSupport() ){
         return  Notification.requestPermission().
          then(  function(permission){  if(permission === 'granted') good(); else bad();     } ).
          catch( bad );
        }else  return bad(); 
      });
     
    },

    requestPermissionToGetToken: function( ) {

      let contextoInner=  this;
       return this.hasNotificationPermission().
          then( function(){ 
            contextoInner.init();//inicializar FCM 
            return contextoInner.registrarServiceWorker();
          
          } );

      },


    registrarServiceWorker: function(  to_do){
        let messag= this.messaging;// objeto proxy
        //retorna una promesa
        return this.messaging
          .requestPermission()
          .then(function () {
                     
              if ('serviceWorker' in navigator) {
                   //promesa
                  return navigator.serviceWorker.register('/taxi_web/firebase-messaging-sw.js')
                  .then(function(registration) { 
                      registration.update();  messag.useServiceWorker(registration); 
                      console.log('Registration successful, scope is:', registration.scope);
                      
                    
                     return true;
                    }).catch(function(err) { 
                      console.log('Service worker registration failed, error:', err.code);
                      
                      return ( err.code == "messaging/use-sw-after-get-token"); 
                      });
                }else return false;
            }  );
            
             
         


    },
    
isTokenSentToServer:   function () {
    return window.localStorage.getItem('sentToServer') === '1';
  },
    setTokenSentToServer: function(sent) {
        window.localStorage.setItem('sentToServer', sent ? '1' : '0');
      },
    updateUserToken: function( token){
     // if (!isTokenSentToServer()) {
        console.log('Sending token to server...');
        $.ajax({ url:"/taxi_web/usuario/actualizarToken", 
        method:"post", 
        data: { token: token}, 
        success: function(res){ console.log(res); },
        error: function(){ console.log("Hubo un error al enviar el token al servidor"); }
        } );
      //  setTokenSentToServer(true);
     // } else {
      //  console.log('Token already sent to server so won\'t send it again ' +
      //      'unless it changes');
     // }
     
    },
    deleteToken: function() {
        // Delete Instance ID token.
        // [START delete_token]
        messaging.getToken().then((currentToken) => {
          messaging.deleteToken(currentToken).then(() => {
            console.log('Token deleted.');
            setTokenSentToServer(false);
            // [START_EXCLUDE] 
            // [END_EXCLUDE]
          }).catch((err) => {
            console.log('Unable to delete token. ', err);
          });
          // [END delete_token]
        }).catch((err) => {
          console.log('Error retrieving Instance ID token. ', err); 
        });
    
      },
    eventos: function(){
        
            // [START refresh_token]
            // Callback fired if Instance ID token is updated.
            this.messaging.onTokenRefresh(() => {
              console.log(this.messaging);
                messaging.getToken().then((refreshedToken) => {
                console.log('Token refreshed.');
                // Indicate that the new Instance ID token has not yet been sent to the
                // app server.
                this.setTokenSentToServer(false);
                // Send Instance ID token to app server.
                this.updateUserToken(refreshedToken);
                // [START_EXCLUDE] 
                // [END_EXCLUDE]
                }).catch((err) => {
                console.log('Unable to retrieve refreshed token ', err); 
                });
            });
            // [END refresh_token]

            // [START receive_message]
            // Handle incoming messages. Called when:
            // - a message is received while the app has focus
            // - the user clicks on an app notification created by a service worker
            //   `messaging.setBackgroundMessageHandler` handler.
            
            this.messaging.onMessage((payload) => {
                console.log('Message received. ', payload);
                
                if( "gui_user_refresh" in payload.data ){
                  //actualizar grilla de usuarios activos 
                  mostrarUsuariosActivos(  payload.data );
                }else{
                  showNotification( payload.data);
                }

                 
            });
            // [END receive_message]
    },
 subscribeTokenToTopic: function( ) {
        let token= $("#token").text();
        //let token="dnQcgewtPu0wXIArfvwNxG:APA91bEPmpdKLq7Y04rYc-gDvtrhJRNsudn1BjK17oyYUg7kOQYRgT_bTZsPcRPVh-q39QfexHdFpqcH_Nk4IRr3mMcJysixLpReKPVgxyCKN4CqGpxeMPigIWXSwSLuOVd8hFWDrMeD";
        let topic= $("#descr-topic").val();
        let fcm_server_key= "AAAADjAS2OY:APA91bFxMXQO10j7kRsamMpOi0Vl6U0le39HzfnKeFoEnc1qS0jCGVHqiK7q8jlFA0e65giaSUpQ1tUkaWUQd-kzQlO_sb0vrXt4VOqBgmzaYJxOHZP_8nQyPUqGThFkg6thPxEiwdJN"; 
    fetch('https://iid.googleapis.com/iid/v1/'+token+'/rel/topics/'+topic, {
      method: 'POST',
      headers: new Headers({
        'Authorization': 'key='+fcm_server_key
      })
    }).then(response => {
      if (response.status < 200 || response.status >= 400) {
        throw 'Error subscribing to topic: '+response.status + ' - ' + response.text();
      }
      console.log('Subscribed to "'+topic+'"');
    }).catch(error => {
      console.error(error);
    })
  },  
unSubscribeTokenToTopic: function( ) {
        let token= $("#token").text();
        //let token="dnQcgewtPu0wXIArfvwNxG:APA91bEPmpdKLq7Y04rYc-gDvtrhJRNsudn1BjK17oyYUg7kOQYRgT_bTZsPcRPVh-q39QfexHdFpqcH_Nk4IRr3mMcJysixLpReKPVgxyCKN4CqGpxeMPigIWXSwSLuOVd8hFWDrMeD";
        let topic= $("#descr-topic").val();
        let fcm_server_key= "AAAADjAS2OY:APA91bFxMXQO10j7kRsamMpOi0Vl6U0le39HzfnKeFoEnc1qS0jCGVHqiK7q8jlFA0e65giaSUpQ1tUkaWUQd-kzQlO_sb0vrXt4VOqBgmzaYJxOHZP_8nQyPUqGThFkg6thPxEiwdJN"; 
        let url_= "https://iid.googleapis.com/v1/web/iid/"+token;
        fetch( url_, {
        method: 'DELETE',
        headers: new Headers({
            'Authorization': 'key='+fcm_server_key
        })
        }).then(response => {
        if (response.status < 200 || response.status >= 400) {
            throw 'Error UNsubscribing to topic: '+response.status + ' - ' + response.text();
        }
        console.log('UNSubscribed to "'+topic+'"');
        }).catch(error => {
        console.error(error);
        });
},

enviar_mensajes: function (){
    let titulo= $("#msg-title").val();
    let msg= $("#my-msg").val();
    let token= $("#token-destino").val();
    let datos= {
      
    "to" : token,
    "data": {
      "title": titulo,
      "body": msg
    },
    "webpush": {
      "fcm_options": {
        "link": "https://google.com"
      } } 

    };// obs debe definirse un objeto de notificacion para visualizar las ventanas
    //de notificaciones
    /*"notification":{
      "title": titulo,
      "body": msg
    }
    */
  
    //http heredado
    //para autorizar, se utiliza la clave de servidor
    //los datos json se convierten a cadena antes de ser enviados
    $.ajax(
      {
        url: "https://fcm.googleapis.com/fcm/send",
       type: "POST",
        headers: {
        'Authorization': "key=AAAADjAS2OY:APA91bFxMXQO10j7kRsamMpOi0Vl6U0le39HzfnKeFoEnc1qS0jCGVHqiK7q8jlFA0e65giaSUpQ1tUkaWUQd-kzQlO_sb0vrXt4VOqBgmzaYJxOHZP_8nQyPUqGThFkg6thPxEiwdJN"
                },
        contentType: "application/json",
        data:  JSON.stringify( datos)
       
         
      }
    );
  },
obtenerToken:   function (){
    // Delete Instance ID token.
    // [START delete_token]
   
  return  this.messaging.getToken();
}



  };
 
      
  
 
 
 

 




 

 






  




  


  
 


   

  





   
 

  




/*
 FirebaseError: "Messaging: A problem occured while unsubscribing the user from FCM: FirebaseError: Messaging: A problem occured while unsubscribing the user from FCM: Requested entity was not found. (messaging/token-unsubscribe-failed). (messaging/token-unsubscribe-failed)."
 */
 

 

  





