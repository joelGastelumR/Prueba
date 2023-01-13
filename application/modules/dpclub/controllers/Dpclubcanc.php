<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpclubcanc extends MY_Controller {


  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(0);

	}

	public function index()
	{



    		$this->load->view('Cancelacion_success');
  }



	}
