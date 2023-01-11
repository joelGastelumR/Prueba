<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpuntossucces extends MY_Controller {


  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(0);

  //  $this->load->model("dpclub_model");

	}

	public function index()
	{



    		$this->load->view('dpuntossucces_success');
  }



	}
