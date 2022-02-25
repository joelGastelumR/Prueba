<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blue_model extends CI_Model {
  public function __construct()
	{
		parent::__construct();
    $this->config->load_db_items();
    $this->load->library('webservices');
    $this->url_blue= $this->config->item('url_blue');
    $this->db2 = $this->load->database('default',true);
    $this->db3 = $this->load->database("karum", true);
    $this->url_ws_aptos = $this->config->item('WS_aptos');
  }

  public function balance($ccajero, $csupervisor, $cvendedor, $cajero, $vendedor, $supervisor, $fecha, $card, $ticket, $tienda){

$xml = '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://WS_BLUE">
 <soapenv:Header/>
 <soapenv:Body>
    <ws:GetBalance>
       <cardId>' .$card. '</cardId>
       <transactionDate>' .$fecha. '</transactionDate>
       <ticketid>' .$ticket. '</ticketid>
       <storeid>' .$tienda. '</storeid>
       <referenceId3>?</referenceId3>
       <referenceId4>?</referenceId4>
       <cashierCode>' .$ccajero. '</cashierCode>
       <cashierName>' .$cajero. '</cashierName>
       <supervisorCode>' .$csupervisor. '</supervisorCode>
       <supervisorName>' .$supervisor. '</supervisorName>
       <sellerCode>' .$cvendedor. '</sellerCode>
       <sellerName>' .$vendedor. '</sellerName>
    </ws:GetBalance>
 </soapenv:Body>
</soapenv:Envelope>
 ';
 $data2 = $this->webservices->WSDL($this->url_blue,trim($xml),'POST');

 return $data2;


  }
  public function canje($ccajero, $csupervisor, $cvendedor, $cajero, $vendedor, $supervisor, $fecha, $card, $ticket, $tienda, $productos, $monto, $Cliente){
$random = rand(00000,99999).rand(00000,99999);
$productos = str_pad($random, 10, "0", STR_PAD_LEFT);
$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://WS_BLUE">
<soapenv:Header/>
<soapenv:Body>
  <ws:Redeem>
     <cardId>' .$card. '</cardId>
     <transactionDate>' .$fecha. '</transactionDate>
     <amount>' .$monto. '</amount>
     <totalAmount>' .$monto. '</totalAmount>
     <ticketid>' .$ticket. '</ticketid>
     <storeid>' .$tienda. '</storeid>
     <referenceId3>?</referenceId3>
     <referenceId4>?</referenceId4>
     <cashierCode>' .$ccajero. '</cashierCode>
     <cashierName>' .$cajero. '</cashierName>
     <supervisorCode>' .$csupervisor. '</supervisorCode>
     <supervisorName>' .$supervisor. '</supervisorName>
     <sellerCode>'.$cvendedor.'</sellerCode>
     <sellerName>'.$vendedor.'</sellerName>
     <localHour>' .$fecha. '</localHour>
     <products>' .$productos. '</products>
  </ws:Redeem>
</soapenv:Body>
</soapenv:Envelope>
 ';

 $data2 = $this->webservices->WSDL($this->url_blue,trim($xml),'POST');

 return $data2;


  }

  public function setLogSap($datos){
        $this->db->insert('ca_transacciones', $datos);
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

  public function setLog($datos){
        $datos['HTML_T'] = implode( $datos['HTML_T'] );
        $this->db->insert('log_ventas', $datos);
  }
}
