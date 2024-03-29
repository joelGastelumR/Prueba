<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DpCard_controller extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->ci_minifier->init(1);
        $this->ci_minifier->enable_obfuscator();
        $this->hash = $this->security->get_csrf_hash();
        $this->load->model("DpCard_model");
        $this->load->library('user_agent');
        $this->load->library('session');

        date_default_timezone_set('America/Mazatlan');

        if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){
            if(isset( $_GET['itoken'] ) ){
                $this->hash = $this->input->get('itoken');
            }
        }

        $this->config->load_db_items();
        $this->consultaSaldo = $this->config->item('WS_consultaSaldo');
        $this->compra = $this->config->item('WS_compra');
    }

    public function index()
    {
        $key = $this->security->xss_clean($this->input->get('key'));
        $tiposPago = "";

        if($key != '')
        {
            $params = base64_decode( strtr( $key, ' ', '+') );
            $arreglo = explode("|", $params);

            $token = base64_decode( strtr( $arreglo[1], ' ', '+') );

            /*busco datos del api*/
            $row = $this->DpCard_model->getInfo($token);

            $tiposPago .= (empty($row->s2_tienda)) ? "" : "DPVALE|";
            $tiposPago .= (empty($row->tienda_dpcredito)) ? "" : "DPCARD|";

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

            $monto = base64_decode( strtr( $arreglo[0], ' ', '+') );
            $token = base64_decode( strtr( $arreglo[1], ' ', '+') );
            $orden = base64_decode( strtr( $arreglo[2], ' ', '+') );

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
                $hostvalido = $row->hostvalido;

                /*valido host*/
                $server = $_SERVER['SERVER_NAME'];
                if(!$server == $hostvalido){
                    $this->session->set_flashdata('mensaje','Servidor No valido, favor de revisar su autorización o Id de Cliente.<br> Error: A002');
                    redirect("https://cajapagos.grupodp.com.mx/dpcard/DpCard_controller/error");
                    echo "Servidor $server No valido, favor de revisar su autorización o Id de Cliente.<br> Error: A002 ";
                }

                $data['validacion'] = $arreglo[0];
                $data['hash'] = $this->hash;
                $data['ordenid'] = ($orden == 0 || $orden == '')?'N/A':$orden;
                $data['key'] = $key;
                $data['monto'] = $monto;
                $this->setSession('amount', $monto);
                $this->setSession('idbranch', $row->tienda_dpcredito);
                $this->setSession('orderId', $orden);
                $this->setSession('idcustomer', $row->idcliente);
            }else{
                $this->session->set_flashdata('mensaje','Informacion no Valida, Favor de revisar su autorización o Id de Cliente.<br> Error: A003 ');
                redirect("https://cajapagos.grupodp.com.mx/dpcard/DpCard_controller/error");
                echo "Informacion no Valida, Favor de revisar su autorización o Id de Cliente.<br> Error: A003";
            }
            
            $data['consultaSaldo']=$this->consultaSaldo;
            $data['compra']=$this->compra;

        	$this->load->view('dpcard_index_view', $data);
        }else{
            $data['mensaje'] = 'Existe en un error en abrir Dpvale Checkout';
            $this->load->view('dpcard_error', $data);
        }
    }

    public function validate_dpcard()
    {
        if($this->validaToken()){}

        $result = array( "status"=>false, "message"=>"", "result"=>[] );

        try
        {
            $dpcard = $this->decrypt(json_decode(base64_decode($this->input->get("dpcard"))), $this->hash);
            $amount = $this->getSession('amount');
            $storeCode = $this->getSession('idbranch');

            if( !is_numeric($dpcard) || strlen($dpcard) != 16 )
            {
                throw new Exception("Atención, los datos enviados no son correctos, favor de revisarlos.", 1);
            }

            $validateDpCardResult = $this->DpCard_model->validate_dpcard($this->hash, ["cardNumber" => $dpcard], $amount);

            if($validateDpCardResult["status"])
            {
                /*GENERAR SOLICITUD DE COMPRA Y ENVIAR SMS*/
                $solicitudCompraResult = $this->DpCard_model->generarSolicitudCompra($this->hash, [
                    "idCredit" => "",
                    "cardNumber" => $dpcard,
                    "amount" => "0",
                    "codeStore" => $storeCode,
                    "codeBox" => null,
                    "codePromotion" => "00",
                    "sendSms" => true,
                    "codeSms" => "",
                ]);

                //$solicitudCompraResult = ["status" => true, "message" => "Correcto.", "result" => ["codeSms" => "1234", "cliente" => "FRANCISCO ROMERO PEREZ"] ];

                if($solicitudCompraResult["status"])
                {
                    $this->setSession('codeSms', $solicitudCompraResult["result"]["codeSms"]);
                    $this->setSession('customer', $validateDpCardResult["result"]["cliente"]);

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

    public function validar_codesms()
    {
        if($this->validaToken()){}

        $result = array( "status"=>false, "message"=>"El código ingresado es incorrecto, intentelo de nuevo", "result"=>[] );

        $code = $this->input->get("userCode");
        
        $codeSmsSaved = $this->getSession('codeSms');
        $amount = $this->getSession('amount');
        $storeCode = $this->getSession('idbranch');
        $customer = $this->getSession('customer');

        if($code == $codeSmsSaved)
        {
            $result["status"] = true;
            $result["message"] = "Correcto.";
            $result["result"]["customer"] = $customer;
            $result["result"]["promotions"] = $this->DpCard_model->getPromociones($storeCode, $amount);
        }

        echo json_encode($result);
    }

    public function confirmar_compra()
    {
        if($this->validaToken()){}

        $result = array( "status"=>false, "message"=>"", "result"=>[] );

        try
        {
            $dpcard = $this->decrypt(json_decode(base64_decode($this->input->get("dpcard"))), $this->hash);
            $promocion = $this->input->get("promocion");
            $promocionDesc = $this->input->get("promocionDesc");
            
            $amount = $this->getSession('amount');
            $codeSms = $this->getSession('codeSms');
            $storeCode = $this->getSession('idbranch');
            $orderId = $this->getSession('orderId');
            $customer = $this->getSession('customer');

            if( !is_numeric($dpcard) || strlen($dpcard) != 16 || empty($promocion) || empty($codeSms) || empty($amount) )
            {
                throw new Exception("Atención, los datos enviados no son correctos, favor de revisarlos.", 1);
            }

            /*CONFIRMAR SOLICITUD DE COMPRA*/
            $result = $this->DpCard_model->confirmar_compra($this->hash, $orderId, [
                "idCredit" => "",
                "cardNumber" => $dpcard,
                "amount" => $amount,
                "codeStore" => $storeCode,
                "codeBox" => null,
                "codePromotion" => $promocion,
                "sendSms" => false,
                "codeSms" => $codeSms
            ]);

            if($result["status"] === true)
            {
                $result = array(
                    "status" => true,
                    "mensaje" => "Venta almacenada",
                    "ca" => $result["result"]["codigo_autorizacion"],
                    "no_tarjeta" => $dpcard,
                    "ventaTicket" => array(
                        "cliente" => $customer,
                        "valorPromocion" => $promocion,
                        "descripcion" => $promocionDesc,
                        "monto" => $amount
                    )
                );

                $this->DpCard_model->guardar_info_compra($result, $storeCode, $orderId);

                $result["no_tarjeta"] = "";
            }
        }
        catch (\Throwable $th)
        {
            $result["status"] = false;
            $result["message"] = $th->getMessage();
        }

        echo json_encode($result);
    }

    public function guardar_motivo_cancelacion()
    {
        if($this->validaToken()){}

        $result = array( "status"=>false, "message"=>"", "result"=>[] );

        try
        {
            $motivo = $this->input->get("motivo");
            
            $orderId = $this->getSession('orderId');
            $idcustomer = $this->getSession('idcustomer');

            

            if( empty($idcustomer) || empty($motivo) )
            {
                throw new Exception("Atención, los datos enviados no son correctos, favor de revisarlos.", 1);
            }

            $result = $this->DpCard_model->guardar_motivo_cancelacion([
                "idCliente" => $idcustomer,
                "numeroOrden" => (empty($orderId) ? 0 : $orderId),
                "motivo" => $motivo
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
            $this->session->set_userdata($name, $value);
        }
    }
  
    private function getSession($name){
        if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){
            $row = $this->DpCard_model->getDBSession($this->hash, $name);
            $valor = !empty($row) ? $row[0]->valor : '';
        } else {
            $valor = $this->session->userdata($name);
        }
        return $valor;
    }

    private function validaToken()
    {
        $hash = $this->hash;
        $token = $this->input->get('token');
        if(strlen($token) > 0  && $token == $hash){
            return true;
        }else{
            $datos = array("key" => 'ERROR EN TOKEN');
            die(json_encode($datos));
        }
        return false;
    }

    public function decrypt($jsonStr, $passphrase)
    {
        $json = json_decode($jsonStr, true);
        $salt = hex2bin($json["s"]);
        $iv = hex2bin($json["iv"]);
        $ct = base64_decode($json["ct"]);
        $concatedPassphrase = $passphrase . $salt;
        $md5 = [];
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1] . $concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
        return json_decode($data, true);
    }
}
?>