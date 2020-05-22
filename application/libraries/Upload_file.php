<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_file {

    protected $CI;



    public function __construct($rules = array()){
        $this->CI =& get_instance();
    }



    public function do_upload(  $fieldname,   $upload_path, $desiredFileName)
    {
            $config['upload_path']          = $upload_path;
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['max_size']             = 5000;
            $config['max_width']            = 3072;//1024 * 3
            $config['max_height']           = 3072; 
            $config['file_name']            = $desiredFileName;
            //$photo_data['upload_data']['file_name']
            $this->CI->load->library('upload', $config);
            $this->CI->upload->initialize($config);//evita que mas de una imagen se guarde con el
                                                    //mismo nombre
        
            if ( ! $this->CI->upload->do_upload(  $fieldname ))
            { 
                    $error = array('error' => $this->CI->upload->display_errors());
                    //var_dump($error);
                    //return $error;
                    //return "";
            }
            else
            {
                    $data = array('upload_data' => $this->CI->upload->data());
                    return $upload_path.$data['upload_data']['file_name'];// Ruta al archivo
                    //return true;
            }
    }

}


?>