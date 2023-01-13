<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpclubsucces extends MY_Controller {


  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(0);
    //  $this->ci_minifier->enable_obfuscator();
    $this->load->model("Dpclub_model");
    //$this->hash = $this->security->get_csrf_hash();
    $this->load->library('parser');
    $this->load->helper('barcode');
	}

	public function index()
	{



    		$this->load->view('Dpclub_success');
  }



	}
