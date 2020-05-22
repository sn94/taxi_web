
 
      <?php if( $this->session->has_userdata("usuario")): 
            if( $this->session->userdata("tipo") =="c")  :   
              $this->load->view("plantillas/header/cliente");
            else:   
              $this->load->view("plantillas/header/proveedor");
            endif;   
      
          else:
            $this->load->view("plantillas/header/visitante");
          endif;
        ?>
       
 