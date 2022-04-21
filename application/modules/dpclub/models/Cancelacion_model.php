<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cancelacion_model extends CI_Model {
  public function __construct()
	{
		parent::__construct();
    $this->config->load_db_items();
    $this->load->library('webservices');
    $this->url_karum = $this->config->item('url_karum');
    #$this->url_karum = "http://10.200.3.103:7081/WS_KARUM?wsdl";
    $this->db2 = $this->load->database('default',true);
    $this->db3 = $this->load->database("karum", true);
  }
  public function consulta($tarjeta, $fecha, $tipo, $tienda){
    $tienda = $this->config->item('karum_tienda');
    $xml = '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://WS_KARUM">
    <soapenv:Header/>
    <soapenv:Body>
    <ws:DPT_AccountStatus>
    <NoTarjeta>' .$tarjeta. '</NoTarjeta>
    <Fecha>'.$fecha.'</Fecha>
    <ConsecutivoPOS>01</ConsecutivoPOS>
    <IDPOS>0001</IDPOS>
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
  $consulta= $this->db2->query("SELECT plaza FROM plazas WHERE id = $tienda;");
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
   <ws:DPT_PurchaseVoid>
      <NoTarjeta>'.$tarjeta.'</NoTarjeta>
      <Monto>'.$monto.'</Monto>
      <Promocion>'.$promo.'</Promocion>
      <Fecha>'.$fecha.'</Fecha>
      <ConsecutivoPOS></ConsecutivoPOS>
      <IDPOS>'.$caja.'</IDPOS>
      <IDTienda>D393251</IDTienda>
      <Tipo>'.$tipo.'</Tipo>
      <!--Zero or more repetitions:-->
      ';
      $xml.= $resultado;
      $xml.='
   </ws:DPT_PurchaseVoid>
</soapenv:Body>
</soapenv:Envelope>';

  //header("Content-type: text/xml");
  //echo $xml;
  //die();
    $data2 = $this->webservices->WSDL($this->url_karum,trim($xml),'POST');

    return $data2;
}


}
