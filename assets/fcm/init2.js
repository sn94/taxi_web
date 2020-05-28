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


 // Retrieve an instance of Firebase Messaging so that it can handle background
 // messages.
 //const messaging = firebase.messaging();
 
  // [START get_messaging_object]
  // Retrieve Firebase Messaging object.
  const messaging = firebase.messaging();


  messaging
        .requestPermission()
        .then(function () {
          console.log("Have permission");
          if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('./firebase-messaging-sw.js')
            .then(function(registration) {
              registration.update();
              messaging.useServiceWorker(registration);
              resetUI();//obtener tokens y otras cosas

                console.log('Registration successful, scope is:', registration.scope);
            }).catch(function(err) {
                console.log('Service worker registration failed, error:', err);
            });
        }
      }  );


  // [END get_messaging_object]
  // [START set_public_vapid_key]
  // Add the public key generated from the console here.
  messaging.usePublicVapidKey('BK2EVduWVgQ36FtvJXrqzFNSZElVZ6iFRkZtyN26zDvHj6d7qtUtYS7jqmU5M1YoUXY-QUt9RDV_XChuA6JkXt4');
  // [END set_public_vapid_key]
 

  // [START refresh_token]
  // Callback fired if Instance ID token is updated.
  messaging.onTokenRefresh(() => {
    messaging.getToken().then((refreshedToken) => {
      console.log('Token refreshed.');
      // Indicate that the new Instance ID token has not yet been sent to the
      // app server.
      setTokenSentToServer(false);
      // Send Instance ID token to app server.
      sendTokenToServer(refreshedToken);
      // [START_EXCLUDE]
      // Display new Instance ID token and clear UI of all previous messages.
      resetUI();
      // [END_EXCLUDE]
    }).catch((err) => {
      console.log('Unable to retrieve refreshed token ', err);
      showToken('Unable to retrieve refreshed token ', err);
    });
  });
  // [END refresh_token]

  // [START receive_message]
  // Handle incoming messages. Called when:
  // - a message is received while the app has focus
  // - the user clicks on an app notification created by a service worker
  //   `messaging.setBackgroundMessageHandler` handler.
  messaging.onMessage((payload) => {
    console.log('Message received. ', payload);
    // [START_EXCLUDE]
    // Update the UI to include the received message.
    console.log( payload);
    appendMessage(payload);

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


 






  




  function resetUI() {
    clearMessages();
    showToken('loading...');
    // [START get_token]
    // Get Instance ID token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken().then((currentToken) => {
      if (currentToken) {
        sendTokenToServer(currentToken);
        updateUIForPushEnabled(currentToken);
      } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
        // Show permission UI.
        updateUIForPushPermissionRequired();
        setTokenSentToServer(false);
      }
    }).catch((err) => {
      console.log('An error occurred while retrieving token. ', err);
      showToken('Error retrieving Instance ID token. ', err);
      setTokenSentToServer(false);
    });
    // [END get_token]
  }


  function showToken(currentToken) {
    // Show token in console and UI.
    const tokenElement = document.querySelector('#token');
    tokenElement.textContent = currentToken;
  }

  // Send the Instance ID token your application server, so that it can:
  // - send messages back to this app
  // - subscribe/unsubscribe the token from topics
  function sendTokenToServer(currentToken) {
    if (!isTokenSentToServer()) {
      console.log('Sending token to server...');
      // TODO(developer): Send the current token to your server.
      setTokenSentToServer(true);
    } else {
      console.log('Token already sent to server so won\'t send it again ' +
          'unless it changes');
    }

  }

  function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1';
  }

  function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
  }

  function showHideDiv(divId, show) {
    const div = document.querySelector('#' + divId);
    if (show) {
      div.style = 'display: visible';
    } else {
      div.style = 'display: none';
    }
  }

  function requestPermission() {
    console.log('Requesting permission...');
    // [START request_permission]
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        console.log('Notification permission granted.');
        // TODO(developer): Retrieve an Instance ID token for use with FCM.
        // [START_EXCLUDE]
        // In many cases once an app has been granted notification permission,
        // it should update its UI reflecting this.
        resetUI();
        // [END_EXCLUDE]
      } else {
        console.log('Unable to get permission to notify.');
      }
    });
    // [END request_permission]
  }

  function deleteToken() {
    // Delete Instance ID token.
    // [START delete_token]
    messaging.getToken().then((currentToken) => {
      messaging.deleteToken(currentToken).then(() => {
        console.log('Token deleted.');
        setTokenSentToServer(false);
        // [START_EXCLUDE]
        // Once token is deleted update UI.
        resetUI();
        // [END_EXCLUDE]
      }).catch((err) => {
        console.log('Unable to delete token. ', err);
      });
      // [END delete_token]
    }).catch((err) => {
      console.log('Error retrieving Instance ID token. ', err);
      showToken('Error retrieving Instance ID token. ', err);
    });

  }

  // Add a message to the messages element.
  function appendMessage(payload) {
    const messagesElement = document.querySelector('#messages');
    const dataHeaderELement = document.createElement('h5');
    const dataElement = document.createElement('pre');
    dataElement.style = 'overflow-x:hidden;';
    dataHeaderELement.textContent = 'Received message:';
    dataElement.textContent = JSON.stringify(payload, null, 2);
    messagesElement.appendChild(dataHeaderELement);
    messagesElement.appendChild(dataElement);
  }

  // Clear the messages element of all children.
  function clearMessages() {
    const messagesElement = document.querySelector('#messages');
    while (messagesElement.hasChildNodes()) {
      messagesElement.removeChild(messagesElement.lastChild);
    }
  }

  function updateUIForPushEnabled(currentToken) {
    showHideDiv(tokenDivId, true);
    showHideDiv(permissionDivId, false);
    showToken(currentToken);
  }

  function updateUIForPushPermissionRequired() {
    showHideDiv(tokenDivId, false);
    showHideDiv(permissionDivId, true);
  }

  //resetUI();



function obtenerToken(){
    // Delete Instance ID token.
    // [START delete_token]
    messaging.getToken().then((currentToken) => { 
         console.log( currentToken);
         
    }).catch((err) => {
      console.log('Error retrieving Instance ID token. ', err);
      showToken('Error retrieving Instance ID token. ', err);
    }); 
}

  function enviar_mensajes(){
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
  }// *** END ENVIAR MENSAJE *** 



/*
 FirebaseError: "Messaging: A problem occured while unsubscribing the user from FCM: FirebaseError: Messaging: A problem occured while unsubscribing the user from FCM: Requested entity was not found. (messaging/token-unsubscribe-failed). (messaging/token-unsubscribe-failed)."
 */
 

 
    function subscribeTokenToTopic( ) {
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
}

  


function unSubscribeTokenToTopic( ) {
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
  })
}

