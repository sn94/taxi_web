
 
      <?php if( $this->session->has_userdata("usuario")): 
              
            $this->load->view("plantillas/user_data_panel/user_data_panel");
            
      else:
            $this->load->view("plantillas/user_data_panel/user_data_panel_v");
          endif;
        ?>
       
 