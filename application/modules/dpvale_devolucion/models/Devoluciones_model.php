<?php
  class Devoluciones_model extends CI_Model{
    public function __construct(){
      parent::__construct();

      $this->config->load_db_items();
      $this->load->library('webservices');
      $this->url_ws_s2credit = $this->config->item('WS_s2credit');
      $this->url_ws_aptos = $this->config->item('WS_aptos');
    }

    public function getVale($folio){
          $json = array("coupon-search"=>array("coupon"=>$folio));
          $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
      return $data;
    }

    public function getDatosCliente($id_customer){
          $json = array("search-customer"=>array("data"=>$id_customer));
          $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
      return $data;
    }

    /*public function getValores($id){
          $json = array("coupon-search"=>array("coupon"=>'300112266'));
          $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
      return $data;
    }*/

    public function devolucion($datos){
      $data = $this->webservices->REST($datos, $this->url_ws_s2credit, 'POST');
      return $data;
    }

    public function setRevale($datos){
      $data = $this->webservices->REST($datos, $this->url_ws_s2credit, 'POST');
      return $data;
    }

    public function getTiendaEquivalencia($tienda){
        $this->db->where('tienda', $tienda);
        $data = $this->db->get('tiendas_equivalencia')->result();
        return $data;
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

    public function setReporteDPVL($datos){
      $respuesta = $this->db->insert('reporte_dpvale', $datos);
      return $respuesta;
    }
  }
