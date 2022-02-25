<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Key {

    var $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->config->load_db_items();
        $this->key = $this->CI->config->item('key');
    }

    public function index() {
      $keyApi= $this->CI->input->get('key');
      if($this->CI->uri->segment(1) !== 'welcome'){
            if( $keyApi !== $this->key){
              redirect('welcome');
            }
        }
    }
}


/* End of file compress.php */
/* Location: ./system/application/hooks/compress.php */
