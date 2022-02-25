<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpclub_model extends CI_Model {
  public function __construct()
	{
		parent::__construct();
    $this->config->load_db_items();
    $this->load->library('webservices');
    $this->url_karum = $this->config->item('url_karum');
    $this->url_ws_aptos = $this->config->item('WS_aptos');
    $this->db2 = $this->load->database('default',true);
    $this->db3 = $this->load->database("karum", true);
  }
  public function consulta($tarjeta, $fecha, $tipo, $tienda, $caja){
    $tienda = "D393251";
    $xml = '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://WS_KARUM">
    <soapenv:Header/>
    <soapenv:Body>
    <ws:DPT_AccountStatus>
    <NoTarjeta>' .$tarjeta. '</NoTarjeta>
    <Fecha>'.$fecha.'</Fecha>
    <ConsecutivoPOS>1</ConsecutivoPOS>
    <IDPOS>'.$caja.'</IDPOS>
    <IDTienda>'.$tienda.'</IDTienda>
    <Tipo>'.$tipo.'</Tipo>
    </ws:DPT_AccountStatus>
    </soapenv:Body>
    </soapenv:Envelope>
    ';
    $data2 = $this->webservices->WSDL($this->url_karum,trim($xml),'POST');

    return $data2;
}
public function getplaza($tienda){
  $consulta= $this->db2->query("SELECT plaza FROM plazas WHERE id_tienda = $tienda;");
  return $consulta->result();
}
  public function getpromo($bin, $monto, $plaza){
    $consulta= $this->db2->query("SELECT promociones.Id_Num_Promo, promociones.Desc_Promo FROM promociones
INNER JOIN plazas ON plazas.Id_Num_Promo = Ids_Num_Promo AND plazas.plaza = '$plaza'
WHERE Ids_Num_Promo IN(
SELECT Ids_Num_Promo FROM promocion_bin_d WHERE Id_Num_Bin = $bin AND (Imp_MinProm >= 0 AND Imp_MinProm <= $monto)
) ");

    return $consulta->result();
  }
  public function validabin($tarjeta){
    #$consulta= $this->db3->query("EXEC ValidaBin $tarjeta");
    $consulta= $this->db3->query("SELECT COUNT(*) as num FROM Promocion_Bin_D WHERE Id_Num_Bin= $tarjeta");

    return $consulta->result();
  }
  public function webser($tarjeta, $fecha, $monto, $promo, $caja, $tipo, $tienda, $detalle){
$resultado = urldecode($detalle);
  //var_dump($resultado);
    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://WS_KARUM">
<soapenv:Header/>
<soapenv:Body>
<ws:DPT_Purchase>
      <NoTarjeta>'.$tarjeta.'</NoTarjeta>
      <Monto>'.$monto.'</Monto>
      <Promocion>'.$promo.'</Promocion>
      <Fecha>'.$fecha.'</Fecha>
      <ConsecutivoPOS>?</ConsecutivoPOS>
      <IDPOS>'.$caja.'</IDPOS>
      <IDTienda>D393251</IDTienda>
      <Tipo>'.$tipo.'</Tipo>
      <IDTransaccion>4120</IDTransaccion>
      <!--Zero or more repetitions:-->
      ';
      $xml.= $resultado;
      $xml.='
</ws:DPT_Purchase>
</soapenv:Body>
</soapenv:Envelope>';

    $data2 = $this->webservices->WSDL($this->url_karum,trim($xml),'POST');

      #header("Content-type: text/xml");
      #echo $resultado;
      #echo $xml;
      #die();
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
