<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blue_error extends MY_Controller {


  public function __construct(){
		parent::__construct();

    $this->load->model("Blue_model");

	}

	public function index()
{


		$this->load->view('Blue-error_view');
    }


  }
