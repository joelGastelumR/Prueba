<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mazatlan');
class DpCard_controller extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->ci_minifier->init(1);
        $this->ci_minifier->enable_obfuscator();
        $this->hash = $this->security->get_csrf_hash();
        $this->load->model("DpCard_model");
        $this->config->load_db_items();
        $this->load->library('user_agent');

        if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){
            if(isset( $_GET['itoken'] ) ){
                $this->hash = $this->input->get('itoken');
            }
        }
    }

    public function index()
    {
        $key = $this->security->xss_clean($this->input->get('key'));
        $tiposPago = "DPVALE";

        if($key != '')
        {
            $params = base64_decode( strtr( $key, ' ', '+') );
            $arreglo = explode("|", $params);

            $token = base64_decode( strtr( $arreglo[1], ' ', '+') );

            /*busco datos del api*/
            $row = $this->DpCard_model->getInfo($token);

            if(!empty($row[0]->s2_tienda))
            {
                $tiposPago = $this->DpCard_model->obtenerTiposDePagoPorTienda($row[0]->s2_tienda);

                $tiposPago = empty($tiposPago) ? "DPVALE|DPCARD" : $tiposPago;
            }

            $this->load->view('seleccion_metodo_view', ["key" => $key, "tiposPago" => $tiposPago]);
        }
        else
        {
            $data['mensaje'] = 'Existe en un error en abrir el checkout.';
            $this->load->view('dpcard_error', $data);
        }
    }

    public function dpcard_index()
    {
        /* Recolectar parametros de entrada: monto, token */
        $key = $this->security->xss_clean($this->input->get('key'));
        if($key != ''){
            $raw = strtr( $key, ' ', '+');
            $params = base64_decode( $raw );
            $arreglo = explode("|", $params);

            $clean1 = strtr( $arreglo[0], ' ', '+');
            $clean2 = strtr( $arreglo[1], ' ', '+');
            $clean3 = strtr( $arreglo[2], ' ', '+');

            $monto = base64_decode( $clean1 );
            $token = base64_decode( $clean2 );
            $orden = base64_decode( $clean3 );

            $monto = str_replace(",", "", $monto);
            /*validacion de monto*/
            if(!is_numeric($monto)) {
                $this->session->set_flashdata('mensaje','El monto no es correcto Favor de verificarlo.<br> Error: A001');
                redirect("https://cajapagos.grupodp.com.mx/dpcard/DpCard_controller/error");
                echo 'El monto no es correcto Favor de verificarlo.<br> Error: A001';
            }

            /*busco datos del api*/
            $row = $this->DpCard_model->getInfo($token);

            if($row != 'error'){
                $hostvalido = $row[0]->hostvalido;

            /*valido host*/
            $server = $_SERVER['SERVER_NAME'];
            if(!$server == $hostvalido){
                $this->session->set_flashdata('mensaje','Servidor No valido, favor de revisar su autorización o Id de Cliente.<br> Error: A002');
                redirect("https://cajapagos.grupodp.com.mx/dpcard/DpCard_controller/error");
                echo "Servidor $server No valido, favor de revisar su autorización o Id de Cliente.<br> Error: A002 ";
            }

            $data['monto'] = $monto;
            $data['tienda'] = $row[0]->s2_tienda;
            $data['validacion'] = $arreglo[0];
            $data['hash'] = $this->hash;
            $data['ordenid'] = ($orden == 0 || $orden == '')?'N/A':$orden;
            $data['key'] = $key;
            $this->setSession('amount', $monto);
            $this->setSession('idbranch', $row[0]->s2_tienda);
            $this->setSession('orderId', $orden);

            }else{
                $this->session->set_flashdata('mensaje','Informacion no Valida, Favor de revisar su autorización o Id de Cliente.<br> Error: A003 ');
                redirect("https://cajapagos.grupodp.com.mx/dpcard/DpCard_controller/error");
                echo "Informacion no Valida, Favor de revisar su autorización o Id de Cliente.<br> Error: A003";
            }

        	$this->load->view('dpcard_index_view', $data);
        }else{
            $data['mensaje'] = 'Existe en un error en abrir Dpvale Checkout';
            $this->load->view('dpcard_error', $data);
        }
    }

    public function validar_codesms()
    {
        $result = array( "status"=>false, "message"=>"El código ingresado es incorrecto, intentelo de nuevo", "result"=>[] );

        $codeSms = md5($this->input->get("codeSms"));
        $codeSmsSaved = $this->getSession('codeSms');
        $amount = $this->getSession('amount');

        if($codeSms == $codeSmsSaved)
        {
            $result["status"] = true;
            $result["message"] = "Correcto.";
            $result["result"]["cliente"] = $this->getSession('cliente');
            $result["result"]["promociones"] = $this->DpCard_model->getPromociones($amount);
        }

        echo json_encode($result);
    }

    public function validate_dpcard()
    {
        $result = array( "status"=>false, "message"=>"", "result"=>[] );

        try
        {
            $dpcard = $this->input->get("dpcard");
            $amount = $this->getSession('amount');
            $tienda = $this->getSession('idbranch');

            if( !is_numeric($dpcard) || strlen($dpcard) != 16 )
            {
                throw new Exception("Atención, los datos enviados no son correctos, favor de revisarlos.", 1);
            }

            $validateDpCardResult = $this->DpCard_model->validate_dpcard(["cardNumber" => $dpcard], $amount);

            if($validateDpCardResult["status"])
            {
                /*GENERAR SOLICITUD DE COMPRA Y ENVIAR SMS*/
                $solicitudCompraResult = $this->DpCard_model->generarSolicitudCompra([
                    "idCredit" => "",
                    "cardNumber" => $dpcard,
                    "amount" => $amount,
                    "codeStore" => $tienda,
                    "codeBox" => null,
                    "codePromotion" => "00",
                    "sendSms" => true,
                    "codeSms" => "",
                ]);

                if($solicitudCompraResult["status"])
                {
                    $this->setSession('codeSms', $solicitudCompraResult["result"]["codeSms"]);
                    $this->setSession('cliente', $validateDpCardResult["result"]["cliente"]);

                    $result["status"] = true;
                    $result["message"] = "Correcto.";
                }
                else
                {
                    $result = $solicitudCompraResult;
                }
            }
            else
            {
                $result = $validateDpCardResult;
            }
        }
        catch (\Throwable $th)
        {
            $result["status"] = false;
            $result["message"] = $th->getMessage();
        }

        echo json_encode($result);
    }

    public function confirmar_compra()
    {
        $result = array( "status"=>false, "message"=>"", "result"=>[] );

        try
        {
            $dpcard = $this->input->get("dpcard");
            $promocion = $this->input->get("promocion");
            $amount = $this->getSession('amount');
            $codeSms = $this->getSession('codeSms');
            $tienda = $this->getSession('idbranch');

            if( !is_numeric($dpcard) || strlen($dpcard) != 16 || empty($promocion) || empty($codeSms) )
            {
                throw new Exception("Atención, los datos enviados no son correctos, favor de revisarlos.", 1);
            }

            /*CONFIRMAR SOLICITUD DE COMPRA*/
            $result = $this->DpCard_model->confirmarSolicitudCompra([
                "idCredit" => "",
                "cardNumber" => $dpcard,
                "amount" => $amount,
                "codeStore" => $tienda,
                "codeBox" => null,
                "codePromotion" => $promocion,
                "sendSms" => false,
                "codeSms" => $codeSms,
            ]);
        }
        catch (\Throwable $th)
        {
            $result["status"] = false;
            $result["message"] = $th->getMessage();
        }

        echo json_encode($result);
    }

    private function setSession($name, $value){
        if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){
            $this->DpCard_model->saveDBSession($this->hash, $name, $value);
        }else{
            $this->session->set_userdata($name.'_'.$this->hash, $value);
        }
    }

    private function getSession($name){
        if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){
          $row = $this->DpCard_model->getDBSession($this->hash, $name);
          $valor = !empty($row) ? $row[0]->valor : '';
        } else {
          $valor = $this->session->userdata($name.'_'.$this->hash);
        }
        return $valor;
    }
}
?>