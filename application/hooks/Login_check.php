<?php



class Login_check  {



    

     function verificar(){ 

        // Get current CodeIgniter instance
        $CI =& get_instance();
        
        /**
         * verificar:
         * Si existe un valor de sesion para la variable usuario y 
         * Si el nombre de algun controlador (segmento 1) no ha sido proporcionado o
         * Si en la url, el controlador es usuario y el metodo es sign_in (segm. 1 y segm. 2)
         * */

         
        if( ! $CI->session->has_userdata("usuario") && 
        !( $CI->uri->segment(1)=="usuario" &&  $CI->uri->segment(2)=="getByName")  && 
          (is_null($CI->uri->segment(1) ) ||
        !( $CI->uri->segment(1) == "usuario"  && $CI->uri->segment(2)== "sign_in") ) ){
            //Si no esta logueado
            //y el usuario pretende acceder a una pagina que no sea la del login
            //redirigirlo al login
            redirect(    base_url("usuario/sign_in")   ); 
        }

        

        /*if(  $CI->session->has_userdata("usuario") ){

            if($CI->session->userdata("tipo") == "V") 
            {   //vendedor
                redirect(  base_url("welcome") );}
            else{
                
                if($CI->session->userdata("tipo") == "A") 
                {   //ADMINISTRATIVO
                    redirect(  base_url("welcome") );}
                else{
                    //SUPERVISOR
                    redirect(  base_url("welcome") );
                }
            }
        }*/
        
    }



}


?>