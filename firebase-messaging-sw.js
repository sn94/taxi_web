// Import and configure the Firebase SDK
// These scripts are made available when the app is served or deployed on Firebase Hosting
// If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
/*importScripts('/__/firebase/7.14.3/firebase-app.js');
importScripts('/__/firebase/7.14.3/firebase-messaging.js');
importScripts('/__/firebase/init.js');

const messaging = firebase.messaging();
*/
/**
 * Here is is the code snippet to initialize Firebase Messaging in the Service
 * Worker when your app is not hosted on Firebase Hosting.
*/
 // [START initialize_firebase_in_sw]
 // Give the service worker access to Firebase Messaging.
 // Note that you can only use Firebase Messaging here, other Firebase libraries
 // are not available in the service worker.
 //importScripts('https://www.gstatic.com/firebasejs/7.14.3/firebase-app.js');
 //importScripts('https://www.gstatic.com/firebasejs/7.14.3/firebase-messaging.js');
 importScripts('./firebase-app.js');
 importScripts('./firebase-messaging.js');


 // Initialize the Firebase app in the service worker by passing in
 // your app's Firebase config object.
 // https://firebase.google.com/docs/web/setup#config-object
 if( !firebase.apps.length ){ 

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
}
 // Retrieve an instance of Firebase Messaging so that it can handle background
 // messages.
 const messaging = firebase.messaging();
 // [END initialize_firebase_in_sw]
 


 




// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
messaging.setBackgroundMessageHandler(function(payload) { 
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
   if(  "gui_user_refresh" in payload.data){

      return;
   }
  else{
      const notificationTitle =   payload.data.title;//+payload.data.title
      const notificationOptions = {
        body: payload.data.body ,
        icon: 'assets/img/icono_noti.jpg'
      };
      return self.registration.showNotification(notificationTitle,
        notificationOptions);
   }
  
    
});
// [END background_handler]
