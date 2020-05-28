
  

  var Fcm= {

    inicializado: false,
    messaging: undefined,
    init: function(){
        if( this.inicializado)  return;
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
                this.inicializado= true;
                this.messaging=  firebase.messaging();
                this.registrarServiceWorker();
                this.eventos();
                
        
      
    },
    
    requestPermission: function( to_do, to_do_instead) {

        if (!('Notification' in window)) {
            // el navegador no soporta la API de notificaciones
                            alert('Su navegador no soporta la API de Notificaciones :(');
                            return;
                        }
        console.log('Requesting permission...');
        // [START request_permission]
        Notification.requestPermission().then((permission) => {
          if (permission === 'granted') {
            console.log('Notification permission granted.');
            this.init();
            to_do();
    
          } else {
            Notification.requestPermission();
            console.log('Unable to get permission to notify.');
          }
        });
        // [END request_permission]
      },
    registrarServiceWorker: function(){
                let messag= this.messaging;
                this.messaging
                .requestPermission()
                .then(function () {
                    console.log( "messaging", messag);
                console.log("Have permission");
                if ('serviceWorker' in navigator) {
                   
                    navigator.serviceWorker.register('/taxi_web/firebase-messaging-sw.js')
                    .then(function(registration) {
                        console.log( "messaging", "antes de actualizar sw");
                    registration.update();
                    messag.useServiceWorker(registration); 

                        console.log('Registration successful, scope is:', registration.scope);
                    }).catch(function(err) {
                        console.log('Service worker registration failed, error:', err);
                    });
                }
            }  );
            
            // [END get_messaging_object]
            // [START set_public_vapid_key]
            // Add the public key generated from the console here.
            this.messaging.usePublicVapidKey('BK2EVduWVgQ36FtvJXrqzFNSZElVZ6iFRkZtyN26zDvHj6d7qtUtYS7jqmU5M1YoUXY-QUt9RDV_XChuA6JkXt4');
            // [END set_public_vapid_key]


    },
    
isTokenSentToServer:   function () {
    return window.localStorage.getItem('sentToServer') === '1';
  },
    setTokenSentToServer: function(sent) {
        window.localStorage.setItem('sentToServer', sent ? '1' : '0');
      },
      
    sendTokenToServer: function(currentToken) {
        if (!isTokenSentToServer()) {
          console.log('Sending token to server...');
          // TODO(developer): Send the current token to your server.
          setTokenSentToServer(true);
        } else {
          console.log('Token already sent to server so won\'t send it again ' +
              'unless it changes');
        }
    
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
                messaging.getToken().then((refreshedToken) => {
                console.log('Token refreshed.');
                // Indicate that the new Instance ID token has not yet been sent to the
                // app server.
                setTokenSentToServer(false);
                // Send Instance ID token to app server.
                sendTokenToServer(refreshedToken);
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
                // [START_EXCLUDE]
                // Update the UI to include the received message.
                console.log( payload); 
            const notificationTitle = payload.data.title;
            const notificationOptions = {
                body: payload.data.body,
                icon: 'icono.jpg',
                vibrate: true
            };
                new Notification(  notificationTitle, notificationOptions);
                
                // [END_EXCLUDE]
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
      } },
      "notification":{
      "title": titulo,
      "body": msg,
      "icon":"icono.jpg"
    }

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
 
      
  
 
 
 

 




 

 






  




  function resetUI() { 
    // [START get_token]
    // Get Instance ID token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken().then((currentToken) => {
      if (currentToken) {
        sendTokenToServer(currentToken); 
      } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
        
        setTokenSentToServer(false);
      }
    }).catch((err) => {
      console.log('An error occurred while retrieving token. ', err); 
      setTokenSentToServer(false);
    });
    // [END get_token]
  }


  
 


   

  





   
 

  




/*
 FirebaseError: "Messaging: A problem occured while unsubscribing the user from FCM: FirebaseError: Messaging: A problem occured while unsubscribing the user from FCM: Requested entity was not found. (messaging/token-unsubscribe-failed). (messaging/token-unsubscribe-failed)."
 */
 

 

  





