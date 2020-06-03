<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');   
 
class Firebase_req{     
  public function __construct(){         
        
  } 


  public function send_msg_multicast( $registrations, $data){
      // tokens: registrationTokens,
      //registration_ids 
      $cliente = curl_init();//instancia de peticion
      curl_setopt($cliente, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");// CURLOPT_URL ES una constante
      curl_setopt( $cliente, CURLOPT_POST, true );//peticion post
      //setting header
      curl_setopt($cliente, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          "Authorization: key=AAAADjAS2OY:APxaA91bFxMXQO10j7kRsamMpOi0Vl6U0le39HzfnKeFoEnc1qS0jCGVHqiK7q8jlFA0e65giaSUpQ1tUkaWUQd-kzQlO_sb0vrXt4VOqBgmzaYJxOHZP_8nQyPUqGThFkg6thPxEiwdJN",
          'Connection: Keep-Alive'
          )); 
      //DATOS
      $token= $registrations; 
      $datos= array(
          "to" => $token[0],
          "data"=>  $data,
          "webpush"=> array(  "fcm_options"=>  array(  "link"=> "https://google.com") ),
          'priority'=>'high'
      );
      
      curl_setopt($cliente, CURLOPT_POSTFIELDS, json_encode( $datos));
      curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true); //retorno
      $contenido = curl_exec($cliente);//ejecucion
      curl_close($cliente);//cierre de peticion
      

  }


 public  function send_message_one_device( $token_reg, $data){
    $cliente = curl_init();//instancia de peticion
    curl_setopt($cliente, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");// CURLOPT_URL ES una constante
    curl_setopt( $cliente, CURLOPT_POST, true );//peticion post
    //setting header
    curl_setopt($cliente, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        "Authorization: key=AAAADjAS2OY:APA91bFxMXQO10j7kRsamMpOi0Vl6U0le39HzfnKeFoEnc1qS0jCGVHqiK7q8jlFA0e65giaSUpQ1tUkaWUQd-kzQlO_sb0vrXt4VOqBgmzaYJxOHZP_8nQyPUqGThFkg6thPxEiwdJN",
        'Connection: Keep-Alive'
        )); 
    //DATOS
    $token="enAEMGcHCT_bqRUoHwibf2:APA91bGN0sOxlz4gt7DAYRw075zIJfLCsA4kIE1o2N44dItM5kFOEw-_-spj7ZiKOh8yxsmJ0N8suXxfsPKYNxczPl7ZlryZRyEW6jYaNV-xhBioBIrDc6BbiMKD9erKpmkRujRp-nEc";
$datos= array(
        "to" => $token,
        "data"=>  $data,
        "webpush"=> array(  "fcm_options"=>  array(  "link"=> "https://google.com") ),
        'priority'=>'high'
    );
    
    curl_setopt($cliente, CURLOPT_POSTFIELDS, json_encode( $datos));
    curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true); //retorno
    $contenido = curl_exec($cliente);//ejecucion
    curl_close($cliente);//cierre de peticion
    var_dump(  $contenido );
    }
    



   public  function send_message_topic_suscr( $topic, $data){
     
        $cliente = curl_init();//instancia de peticion
        $url_google= "https://fcm.googleapis.com/fcm/send";
        curl_setopt($cliente, CURLOPT_URL, $url_google);// CURLOPT_URL ES una constante
        curl_setopt( $cliente, CURLOPT_POST, true );//peticion post
        //setting header
        curl_setopt($cliente, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "Authorization: key=AAAADjAS2OY:APA91bFxMXQO10j7kRsamMpOi0Vl6U0le39HzfnKeFoEnc1qS0jCGVHqiK7q8jlFA0e65giaSUpQ1tUkaWUQd-kzQlO_sb0vrXt4VOqBgmzaYJxOHZP_8nQyPUqGThFkg6thPxEiwdJN",
            'Connection: Keep-Alive'
            )); 
        //DATOS 
        $datos= array(
            "to"=> "/topics/$topic",
            "data"=>  $data,
            "webpush"=> array(  "fcm_options"=>  array(  "link"=> "https://google.com") ),
            'priority'=>'high'
        );
        curl_setopt($cliente, CURLOPT_POSTFIELDS, json_encode( $datos));
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true); //retorno
        $contenido = curl_exec($cliente);//ejecucion
        curl_close($cliente);//cierre de peticion
        var_dump(  $contenido );
        }





} 
?>