<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib extends MY_Controller {


  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(1);
    $this->ci_minifier->enable_obfuscator();
    $this->hash = $this->security->get_csrf_hash();
    $this->load->library('parser');
    $this->load->model("Lib_model");
    $this->config->load_db_items();
	}

	public function index()
   {
    echo "Acción no Valida";
    exit;
   }

   public function js(){
     $id = $this->security->xss_clean($this->input->get('idcliente'));
     if($id==''){echo "Id Cliente no Establecido";exit;}
     //$ip = file_get_contents('https://api.ipify.org');

     $cliente = $this->Lib_model->getDatos($id);
     if($cliente != 'error'){

       $server = $_SERVER['SERVER_NAME'];
       //$server2 = $_SERVER['HTTP_REFERER'];

       if($server != $cliente[0]->hostvalido){
         echo "Servidor $server No valido, favor de revisar su autorización o Id de Cliente.
         esta accesando con host ".$cliente[0]->hostvalido."ip $ip";
         exit;
       }
       //INICIO METODO CORRECTO
       $variables = array(
         'token' => $cliente[0]->token,
         'urlbase' => $cliente[0]->urlbase,
         'hostvalido' => $cliente[0]->hostvalido,
       );
       $contenido = $cliente[0]->obfuscate;
       //$contenido = $cliente[0]->source;
       echo $this->parser->parse_string($contenido, $variables, TRUE);
        exit;
       // FIN metodo correcto

       //METODO DEBUGEO
       // $data['token'] ='1234567890987654321';
       // $data['urlbase'] =  'https://cajapagosqa.grupodp.com.mx/dpvalecom';
       // $data['hostvalido'] =  '10.200.5.18';
       // $data['hostvalido'] =  'cajapagosqa.grupodp.com.mx';

       //  $data['token'] = $cliente[0]->token;
       //  $data['urlbase'] =  $cliente[0]->urlbase;
       // $data['hostvalido'] =  $cliente[0]->hostvalido;
       //
       // $this->load->view('output', $data);
     }else{
       echo "Id Cliente no coincide, favor de verificarlo";
       exit;
     }

   }

  }
