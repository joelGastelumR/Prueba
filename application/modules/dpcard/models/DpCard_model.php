<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DpCard_model extends CI_Model {

    private $url = [
        "consultaSaldo" => "http://10.200.3.102:7082/dpcredito_api/consultaSaldo",
        "compra" => "http://10.200.3.102:7082/dpcredito_api/compra",
    ];

    public function __construct()
    {
        parent::__construct();
        $this->config->load_db_items();
        $this->load->library('webservices');
    }

    public function validate_dpcard($request, $amount)
    {
        $result = array( "status"=>false, "message"=>"", "result"=>[] );

        try
        {
            $response = $this->webservices->REST($request, $this->url["consultaSaldo"], 'POST');
        
            if($response["response"]->status == 0 && empty($response["response"]->errors))
            {
                throw new Exception("Crédito no encontrado, favor de ingresarlo nuevamente.", 1);
            }
            else if($response["response"]->status == 0 && !empty($response["response"]->errors))
            {
                throw new Exception($response["response"]->msn, 1);
            }
            else if($response["response"]->result->credit->status == "Inactivo")
            {
                throw new Exception("Su crédito se encuentra como inactivo, favor de validarlo.", 1);
            }
            else if((float)$response["response"]->result->credit->limit < (float)$amount)
            {
                throw new Exception("Lo sentimos, no cuenta con el crédito suficiente para realizar la compra.", 1);
            }

            $result["status"] = true;
            $result["result"]["cliente"] = $response["response"]->result->customer->name;
            $result["result"]["cliente"] .= empty($response["response"]->result->customer->middleName) ? "" : " " . $response["response"]->result->customer->middleName;
            $result["result"]["cliente"] .= " " . $response["response"]->result->customer->lastName;
            $result["result"]["cliente"] .= " " . $response["response"]->result->customer->secondLastName;
        }
        catch (\Throwable $th) {
            $result["message"] = $th->getMessage();
        }

        return $result;
    }

    public function generarSolicitudCompra($request)
    {
        $result = array( "status"=>false, "message"=>"", "result"=>[] );

        try
        {
            $response = $this->webservices->REST($request, $this->url["compra"], 'POST');
        
            if($response["response"]->status == 1)
            {
                $result["status"] = true;
                $result["message"] = $response["response"]->msn;
                $result["result"] = ["codeSms" => md5($response["response"]->result->codeSms)];
            }
            else if($response["response"]->status == 0 && empty($response["response"]->errors))
            {
                throw new Exception($response["response"]->msn, 1);
            }
            else if($response["response"]->status == 0 && !empty($response["response"]->errors))
            {
                throw new Exception("No es posible establecer conexión, inténtelo más tarde.", 1);
            }
            else
            {
                throw new Exception("Atención ha ocurrido un error inesperado, inténtelo más tarde.", 1);
            }
        }
        catch (\Throwable $th) {
            $result["message"] = $th->getMessage();
        }

        return $result;
    }

    public function confirmar_compra($request)
    {
        $result = array( "status"=>false, "message"=>"", "result"=>[] );

        try
        {
            $response = $this->webservices->REST($request, $this->url["compra"], 'POST');

            if($response["response"]->status == 1)
            {
                $result["status"] = true;
                $result["message"] = $response["response"]->msn;
                $result["result"] = ["codigo_autorizacion" => $response["response"]->result];
            }
            else if($response["response"]->status == 0 && empty($response["response"]->errors))
            {
                throw new Exception($response["response"]->msn, 1);
            }
            else if($response["response"]->status == 0 && !empty($response["response"]->errors))
            {
                throw new Exception("No es posible establecer conexión, inténtelo más tarde.", 1);
            }
            else
            {
                throw new Exception("Atención ha ocurrido un error inesperado, inténtelo más tarde.", 1);
            }
        }
        catch (\Throwable $th) {
            $result["message"] = $th->getMessage();
        }

        return $result;
    }

    public function getPromociones($storeCode, $amount)
    {
        $result = $this->db->query("SELECT valor, descripcion FROM dpcard_promociones WHERE estado = '1' AND deleted_at IS NULL AND tienda_dpcredito = '$storeCode' AND montomin < '$amount'")->result_array();
        
        return $result;
    }

    public function obtenerTiposDePagoPorTienda($tienda)
    {
        $query = "SELECT id, s2_tienda, dpvale, dpcard FROM dpcard_asignacion_pagos WHERE deleted_at IS NULL AND s2_tienda = '$tienda'";

        $data = $this->db->query($query)->row_array();

        $result = "";

        if(isset($data["dpcard"]) && $data["dpcard"] == 1)
        {
            $result .= "DPCARD|";
        }
        
        if((isset($data["dpvale"]) && $data["dpvale"] == 1))
        {
            $result .= "DPVALE|";
        }

        return $result;
    }

    public function getInfo($token)
    {
        $row = $this->db->query("SELECT cliente,hostvalido,token,s2_tienda,tienda_dpcredito FROM apikeys
                                WHERE estado = '1' and token = '$token' ")->result();
        if($row){
            return $row;
        }else{
            return "error";
        }
    }

    public function saveDBSession($token,$name,$value){
        $row = $this->db->query("SELECT id FROM ci_sessions_ios WHERE token = '$token' AND variable = '$name'")->result();
        if($row){
            $this->db->where('token', $token);
            $this->db->where('variable', $name);
            $this->db->update('ci_sessions_ios', ["valor"=>$value]);
        }else{
            $this->db->insert('ci_sessions_ios', ["token" =>$token, "variable"=>$name, "valor"=>$value]);
        }
    }

    public function getDBSession($token,$name){
        $row = $this->db->query("SELECT valor FROM ci_sessions_ios WHERE token = '$token' AND variable = '$name'")->result();
        return $row;
    }

    private function setTracking($datos){
        $this->db->insert('log_tracking', $datos);
    }
}
?>