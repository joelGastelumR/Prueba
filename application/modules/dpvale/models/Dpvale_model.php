<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpvale_model extends CI_Model {
  public function __construct()
	{
		parent::__construct();
    $this->config->load_db_items();
    $this->load->library('webservices');
    $this->url_ws_s2credit = $this->config->item('WS_s2credit');
    $this->url_ws_aptos = $this->config->item('WS_aptos');
    #$this->db2 = $this->load->database('local',true);
  }

  public function getVale($folio){
        $json = array("coupon-search"=>array("coupon"=>$folio));
        $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
    return $data;
  }

  public function getCanjeante($folio){
        $json = array("search-customer"=>array("data"=>$folio));
        $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
    return $data;
  }

  public function getColonias($cp){
        $json = array("sepomex"=>array("zipcode"=>$cp));
        $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
    return $data;
  }

  public function saveCustomer($datos)
  {

      $json = array("save-customer" => array(
        "id_customer" => intval($datos['idcustomer']),
        "name"        =>$datos['nombre1'],
        "middle_name" =>$datos['nombre2'],
        "last_name"   =>$datos['apaterno'],
        "second_last_name"=>$datos['amaterno'],
        "birthdate"   =>$datos['fnacimiento'],
        "marital_status"=>$datos['marital'],
        "gender"    =>intval($datos['sexo']),
        "email"     =>$datos['email'],
        "rfc"       =>$datos['rfc'],
        "curp"      =>$datos['curp'],
        "id_identification"=>$datos['id_identification'],
        "identification_value"=>$datos['identification_value'],
        "addressCollection" => [array(
            "street" =>$datos['direccion'],
            "houseNumber"=>$datos['numext'],
            "apartmentNumber"=>$datos['numint'],
            "zipcode" => $datos['cp'],
            "state"   => $datos['estado'],
            "city"    => $datos['ciudad'],
            "settlement"=> $datos['settlement'],
            "neighborhood"=>$datos['colonia']
          )],
        "phoneNumberCollection" => [array(
            "number" => $datos['telefono'],
            "type"   => $datos['type']
        )]
      ));

      $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST',false,false);
      return $data;
  }

  public function getTopeVenta($tipo,$tienda){
      $this->db->where('tipo', $tipo);
      $this->db->where('tienda', $tienda);
      $data = $this->db->get('dpvale_tope_venta')->result();
      return $data;
  }

  public function getTiendaEquivalencia($tienda){
      $this->db->where('tienda', $tienda);
      $data = $this->db->get('tiendas_equivalencia')->result();
      return $data;
  }

  public function getPromociones($plaza,$monto,$tienda)
  {
      $json = array("offers"=>array("id_branch"=>$plaza,"amount"=>$monto,"date"=>date('Y-m-d')));
      $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');

      #debug tracking
      $datos = array(
        'tienda' => $tienda,
        'metodo' => 'Promociones',
        'request' => json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        'response' => json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        'fechahora' => date('Y-m-d H:i:s')
      );
    //  $this->setTracking($datos);

      return $data;
  }

  public function setVenta($datos,$tienda,$pedido=0,$folio,$plataforma)
  {
    #debug tracking preventa
    $track = array(
      'tienda' => $tienda,
      'metodo' => 'preventa',
      'pedido' => $pedido,
      'folio' =>$folio,
      'tipo' =>'DPVL',
      'plataforma' => $plataforma,
      'request' => json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
      'fechahora' => date('Y-m-d H:i:s')
    );
    $this->setTracking($track);

    $data = $this->webservices->REST($datos, $this->url_ws_s2credit, 'POST');

    #debug tracking postventa
    $datos = array(
      'tienda' => $tienda,
      'metodo' => 'postventa',
      'pedido' => $pedido,
      'folio' =>$folio,
      'tipo' =>'DPVL',
      'plataforma' => $plataforma,
      'response' => json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
      'fechahora' => date('Y-m-d H:i:s')
    );
    $this->setTracking($datos);


    return $data;
  }

  public function setRevale($datos)
  {
    $data = $this->webservices->REST($datos, $this->url_ws_s2credit, 'POST');
    return $data;
  }
  public function getParentescos(){
    $json = array("relationship"=>array());
    $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
    return $data['response']->data;
  }

  public function setBeneficiario($datos){
        $json = array("beneficiary-change"=>array(
          "id_relationship"=> $this->db->escape_str($datos['idrelation']),
          "id_purchase" => $this->db->escape_str($datos['idpurchase']),
          "name" => $this->db->escape_str($datos['name']),
          "last_name" => $this->db->escape_str($datos['lastname']),
          "second_last_name" => $this->db->escape_str($datos['secondlastname'])
        ));
        $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
    return $data;
  }

  public function getDireccionCanjeante($folio){
        $json = array("search-customer"=>array("data"=>$folio));
        $resultado = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
        $direccion = $resultado['response']->results[0]->address;
        $data = $direccion->street.' #'.$direccion->house_number." ".$direccion->apartment_number.' Colonia '.$direccion->neighborhood.', CP. '.$direccion->zipcode.", ".$direccion->city.", ".$direccion->state;
        return $data;
  }

  public function setLog($datos){

        $datos['HTML_T'] = implode( $datos['HTML_T'] );
        if($datos['HTML_R'] != ''){
          $datos['HTML_R'] = implode( $datos['HTML_R'] );
        }else{
          $datos['HTML_R'] = '';
        }
        $this->db->insert('log_ventas', $datos);
      //  $this->db->last_query();
  }

  public function setTracking($datos){
        $this->db->insert('log_tracking', $datos);
      //  $this->db->last_query();
  }

  public function setLogSap($datos){
        $this->db->insert('ca_transacciones', $datos);
      //  $this->db->last_query();
  }

  public function setSAP($datos){
        $json = array("SapImTPayboxIn"=>[array(
          "REFCP"=> $this->db->escape_str($datos['REFCP']),
    	    "NODOC"=> $this->db->escape_str($datos['NODOC']),
    	    "WRBTR"=> $this->db->escape_str($datos['WRBTR']),
    	    "WAERS"=> $this->db->escape_str($datos['WAERS']),
    	    "VKBUR"=> $this->db->escape_str($datos['VKBUR']),
    	    "NCAJA"=> $this->db->escape_str($datos['NCAJA']),
    	    "FECHA"=> $this->db->escape_str($datos['FECHA']),
    	    "HORAE"=> $this->db->escape_str($datos['HORAE']),
    	    "PERNR"=> $this->db->escape_str($datos['PERNR']),
    	    "CODAU"=> $this->db->escape_str($datos['CODAU'])
        )]);
       $data = $this->webservices->REST($json, $this->url_ws_aptos.'SapZFmCommx002PayboxRelSave', 'POST');
    return $data;
  }

  public function setReporteDPVL($datos){
    $respuesta = $this->db->insert('reporte_dpvale', $datos);
    return $respuesta;
  }
}
