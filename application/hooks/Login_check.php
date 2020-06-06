<?php



class Login_check  {



    

     function verificar(){ 

        // Get current CodeIgniter instance
        $CI =& get_instance();
        
                        /***Condiciones */
        // NO Si existe un valor de sesion para la variable usuario
        $cond1=  ! $CI->session->has_userdata("usuario") ;
        
        //No es el controlador usuario y el metodo getByName
        $cond2=!( $CI->uri->segment(1)=="usuario" &&  $CI->uri->segment(2)=="getByName");
        
        //Nombre de controlador no proporcionado o
        //  el controlador es usuario  y el metodo es sign_in (segm. 1 y segm. 2)
        $cond3=  (is_null($CI->uri->segment(1) ) ||
        !( $CI->uri->segment(1) == "usuario"  && $CI->uri->segment(2)== "sign_in") );

        //Restringuir acceso a proveedor/servicio
        if(  $CI->session->userdata("tipo")!="p" && ($CI->uri->segment(1)=="proveedor" && $CI->uri->segment(2)=="servicio") ){
            //redirigirlo al login
            redirect(    base_url("proveedor/index")   ); 
        }
         
       /* if(  $cond1 &&  $cond2    &&  $cond3 ){
            //Si no esta logueado
            //y el usuario pretende acceder a una pagina que no sea la del login
            //redirigirlo al login
            redirect(    base_url("usuario/sign_in")   ); 
        }*/
  
        
    }



}


?>