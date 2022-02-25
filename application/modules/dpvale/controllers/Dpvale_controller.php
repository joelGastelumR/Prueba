<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpvale_controller extends MY_Controller {
private $tienda;
private $monto;
private $tope;

  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(1);
    $this->ci_minifier->enable_obfuscator();
    $this->load->model("Dpvale_model");
    $this->hash = $this->security->get_csrf_hash();
    $this->load->library('parser');
    $this->load->helper('barcode');
    $this->load->library('NumerosEnLetras');
    date_default_timezone_set('America/Mazatlan');
	}

	public function index()
	{

    $this->monto = $this->getMonto();
    $this->tienda = $this->tienda_conversion('tienda');
    $this->caja = $this->tienda_conversion('caja');
    $this->tope  = $this->getTopeVenta();

    $data['monto'] = $this->monto;
    $data['tope'] = $this->tope;
    $data['hash'] = $this->hash;
    $data['tienda'] = $this->tienda;
    $data['caja'] = $this->caja;
    $data['tienda_nombre'] = $this->input->get('nombre');
    $data['tienda_calle_numero'] =$this->input->get('calle_numero');
    $data['tienda_colonia'] = $this->input->get('colonia');
    $data['tienda_cp'] = $this->input->get('cp');
    $data['tienda_telefono'] = $this->input->get('telefono');
    $data['tienda_ciudad'] =$this->input->get('ciudad');
    $data['tienda_estado'] = $this->input->get('estado');
    $data['tienda_vendedor'] = $this->input->get('vendedor');
    $tplataforma = $this->input->get('plataforma');
    if($this->tienda == '157' || $this->tienda == 157){
      $data['plataforma'] = 'aptos';
    }else{
      $data['plataforma'] = 'pruebas';
    }
    $data['pedido'] = $this->input->get('pedido');

    if(!$this->tienda > 0){
        $data['error'] = "No existe tienda";
        $this->load->view('dpvale-error_view',$data);
    }else if(!$this->monto > 0){
        $data['error'] = "No Existe monto a cobrar";
        $this->load->view('dpvale-error_view',$data);
    }else if(!$this->tope > 0){
        $data['error'] = "No existen Productos y/o no existe tope de venta procesar.";
        $this->load->view('dpvale-error_view',$data);
    }else if($this->monto > $this->tope){
        $data['error'] = "El monto de la compra (<b>$".number_format($this->monto,2,'.',',').")</b> es mayor al tope de venta (<b>$".number_format($this->tope,2,'.',',')."</b>)";
        $this->load->view('dpvale-error_view',$data);
    }else{
      //  $data['promo'] = $this->getpromociones();
      //  $this->pruebaCA();
      //  $data['parentescos'] = $this->Dpvale_model->getParentescos();
		    $this->load->view('dpvale_view',$data);
    }
	}

  public function getvale()
  {
    if($this->validaToken())
          $folio = $this->input->get('folio');
          $datos = $this->Dpvale_model->getVale($folio);
    echo json_encode($datos);
  }

  public function getCanjeante()
  {
    if($this->validaToken())
            $folio = $this->input->get('folio');
            $datos = $this->Dpvale_model->getCanjeante($folio);
    echo json_encode($datos);
  }

  public function getColonias()
  {
    if($this->validaToken())
        $cp = $this->input->get('zipcode');
        $datos = $this->Dpvale_model->getColonias($cp);
    echo json_encode($datos);
  }
  
  public function getParentescos()
  {
    $data = $this->Dpvale_model->getParentescos();
    echo json_encode($data);
  }

  public function saveCustomer()
  {
    $datos['idcustomer'] = ($this->input->get('idcustomer') > 0)?$this->input->get('idcustomer'):0;
    $datos['direccion'] = $this->input->get('direccion');
    $datos['numint'] = $this->input->get('numint');
    $datos['numext'] = $this->input->get('numext');
    $datos['cp'] = $this->input->get('cp');
    $datos['colonia'] = $this->input->get('colonia');
    $datos['ciudad'] = $this->input->get('ciudad');
    $datos['estado'] = $this->input->get('estado');
    $datos['sexo'] = $this->input->get('sexo');
    $datos['telefono'] = $this->input->get('telefono');
    $datos['fnacimiento'] = $this->input->get('fnacimiento');
    $datos['nombre1'] = $this->input->get('nombre1');
    $datos['nombre2'] = $this->input->get('nombre2');
    $datos['apaterno'] = $this->input->get('apaterno');
    $datos['amaterno'] = $this->input->get('amaterno');
    $datos['rfc'] = $this->input->get('rfc');
    $datos['curp'] = $this->input->get('curp');
    $datos['marital'] = 1;
    $datos['email'] = '';
    $datos['id_identification'] = 1;
    $datos['identification_value'] = 'X';
    $datos['settlement'] = $this->input->get('settlement');
    $datos['type'] = 1;

    $respuesta = $this->Dpvale_model->saveCustomer($datos);
    echo json_encode($respuesta);
  }

  public function getpromociones()
  {
    if($this->validaToken())
      $tienda = $this->input->get('tienda');
      $monto = $this->input->get('monto');
      $tienepromo = $this->input->get('tipo');

      $plaza = $this->tienda_equivalencia($tienda);
      $promo = array();
      $data = $this->Dpvale_model->getPromociones($plaza[0]->id_plaza,$monto,$tienda);
      if($data['response']->status == 1){
            $n=0;
            foreach($data['response']->data as $current)
              {
                if( $monto >= $current->min_amount  and  $monto <= $current->max_amount)
                  {
                    $promoDebug[] = $data['response']->data[$n];
                    $hoy = date('Y-m-d');
                    $date = strtotime($current->promo_date);
                    $fecha = date('Ymd',$date);

                    if($fecha > date('Ymd')){
                      if($tienepromo == 1 || $tienepromo == 3 || $tienepromo == "1" || $tienepromo == "3" ){ //si el vale tiene 1-promocion o es 3-opcional
                             $proximafecha = $this->calculo_rango_fecha(date('Y-m-d',strtotime($current->promo_date)));
                              $promo[] = array(
                                'id_offer' => $current->id_offer ,
                                'term' => $current->term,
                                'promo_date' => $proximafecha,
								'promo_date1' => $current->promo_date,
                                'promo' => 1
                              );
                      }
                    }else{
                        $proximafecha = $this->calculo_rango_fecha(date('Y-m-d',strtotime($hoy)));
                        $promo[] = array(
                          'id_offer' => $current->id_offer ,
                          'term' => $current->term,
                          'promo_date' => $proximafecha,
						  'promo_date1' => $current->promo_date,
                          'promo' => 0
                        );
                    }
                  }
                  $n++;
              }

      }else{
        $promo = 0;
      }
      echo json_encode($promo);
  }


  public function setventa()
  {
    if($this->validaToken())
      $periodo = $this->input->get('period');
      $ntienda = $this->input->get('tienda');
      $pedido = $this->input->get('pedido');
      $plataforma = $this->input->get('plataforma');
      $plaza   = $this->tienda_equivalencia($ntienda);
        $id_plaza     = $plaza[0]->id_plaza;
        $id_tienda    = $plaza[0]->idStore;
        $id_insurance = $plaza[0]->idInsurance*$periodo;
        $insurance    = $plaza[0]->insurance;

        $getpromo = $this->input->get('promo');
          if($getpromo == 'SI'){
            //$proximafecha = $this->input->get('firstDueDate');
			$proximafecha = $this->input->get('promo_s2');
            $idOffer = $this->input->get('idOffer');
          }else{
            $proximafecha = date('Y-m-d');
            $idOffer = '';
          }


      $customer       = $this->input->get('customer');
      $distributor    = $this->input->get('distributor');
      $idCoupon       = $this->input->get('idCoupon');
      $couponAmount   = $this->input->get('couponAmount');
      $purchaseAmount = $this->input->get('purchaseAmount');
      $idBranch       = $id_plaza;
      $idStore        = $id_tienda;
      $idInsurance    = number_format($id_insurance,2,'.','');
      $period         = ($periodo > 0)?$periodo:"12";
      $insurance      = $insurance;
      $firstDueDate   = $proximafecha;
      $idOffer        = $idOffer;

      if($insurance == 0)
      {
        $datos = array(
          "purchase2" => array(
                "customer"       => intval($customer),
                "distributor"    => intval($distributor),
                "idCoupon"       => $idCoupon,
                "date"           => date('Y-m-d'),
                "couponAmount"   => $couponAmount,
                "purchaseAmount" => $purchaseAmount,
                "idBranch"       => $idBranch,
                "idStore"        => $idStore,
                "idInsurance"    => 0,
                    "purchases" => [array(
                        "chargeType"    => "1",
                        "period"        => $period,
                        "amount"        => $purchaseAmount,
                        "interest"      => "",
                        "insurance"     => 0,
                        "firstDueDate"  => $firstDueDate,
                        "idOffer"       => $idOffer
                   )]
            )
        );
      }
      else{
      $datos = array(
        "purchase2" => array(
              "customer"       => intval($customer),
              "distributor"    => intval($distributor),
              "idCoupon"       => $idCoupon,
              "date"           => date('Y-m-d'),
              "couponAmount"   => $couponAmount,
              "purchaseAmount" => $purchaseAmount,
              "idBranch"       => $idBranch,
              "idStore"        => $idStore,
              "idInsurance"    => intval($insurance),
                  "purchases" => [array(
                      "chargeType"    => "1",
                      "period"        => $period,
                      "amount"        => $purchaseAmount,
                      "interest"      => "",
                      "insurance"     => $idInsurance,
                      "firstDueDate"  => $firstDueDate,
                      "idOffer"       => $idOffer
                 )]
          )
      );
    }

      $data = $this->Dpvale_model->setVenta($datos,$ntienda,$pedido,$idCoupon,$plataforma);
      if(isset($data['response']->status))
      if($data['response']->status == 1 and $getpromo == 'REVALE'){
          $info = $this->Dpvale_model->getVale($idCoupon);
          $numero = count( $info['response']->amortizationsPurchase );
          $proximafecha =  $info['response']->amortizationsPurchase[0]->date;

          $data['response']->valePadre = array('quincenas'=> $numero,'fechapago' => $this->calculo_rango_fecha($proximafecha),'fechaoriginal' => $proximafecha);

      }

      echo json_encode($data);


  }

  public function setRevale()
  {
    if($this->validaToken())
        $idCoupon   = $this->input->get('idCoupon');
        $idCustomer = $this->input->get('idCustomer');
        $amount     = $this->input->get('amount');

        $datos = array(
          "new-coupon" => array(
                "idCoupon"     => $this->db->escape_str($idCoupon),
                "idCustomer"   => $this->db->escape_str($idCustomer),
                "amount"       => $this->db->escape_str($amount),
                "type"         => "1",

            )
        );
        //echo json_encode($datos);
        $data = $this->Dpvale_model->setRevale($datos);
        echo json_encode($data);
  }

  public function getTickets()
  {
    if($this->validaToken())
        $tienda   = $this->input->get('tienda');
        $caja   = $this->input->get('caja');
        $periodo  = $this->input->get('quincenas');
        $tienda_nombre = $this->input->get('tienda_nombre');
        $tienda_calle_numero = $this->input->get('tienda_calle_numero');
        $tienda_colonia = $this->input->get('tienda_colonia');
        $folio_vale = $this->db->escape_str($this->input->get('folio_vale'));
        $folio_canjeante = $this->input->get('folio_canjeante');
        $folio_distribuidor = $this->input->get('folio_distribuidor');
        $tienda_vendedor = $this->input->get('tienda_vendedor');
        $quincenas = $this->input->get('quincenas');
        $fecha_pago = $this->input->get('fecha_pago');
        $importe_pago = $this->input->get('importepago');
        $canjeante = $this->input->get('canjeante');
        $distribuidor = $this->input->get('distribuidor');
        $ticket = $this->input->get('tickets');
        $telefono_tienda = $this->input->get('tienda_telefono');
        $seguro = $this->input->get('seguro');
        //$direccion_canjeante = $this->input->get('direccion');
        $revale = $this->input->get('revale');
        $folio_revale = $this->input->get('folio_revale');
        $valeorigen = $folio_vale;
        $fecha_exp= substr($this->input->get('fecha_exp'),0,10);
        $nombre_canjeante= $this->input->get('name');
        $nombre2_canjeante= $this->input->get('middleName');
        $paterno_canjeante= $this->input->get('lastName');
        $materno_canjeante= $this->input->get('secondLastName');
        $telefono_canjeante= $this->input->get('telefono_canjeante');
        $importeoriginal= $this->input->get('impoteOrig');
        $monto_revale= $this->input->get('monto');
        $monto_revale_letra= $this->numerosenletras->convertir($monto_revale,'Pesos',false,'Centavos');
        $firma_canjeante = $this->input->get('firma_canjeante');
        $codigodebarras = barcode64('',str_pad($folio_revale, 10, "0", STR_PAD_LEFT),'30','horizontal','code128',false,1);
        $rfc_canjeante = $this->input->get('rfc');
        $sexo_canjeante = $this->input->get('sexo');
        $beneficiario_nombre = $this->input->get('b_nombre');
        $beneficiario_parentesco = $this->input->get('b_parentesco');
        $beneficiario_porcentaje =  $this->input->get('b_porcentaje');
        $seguro_quincenas =  $this->input->get('seguro_quincenas');
        $seguro_total =  $this->input->get('seguro_total');
        $seguro_desde =  $this->input->get('seguro_desde');
        $seguro_hasta =  $this->input->get('seguro_hasta');
        $codigo_autorizacion  = $this->input->get('ca');
        $seguro_costo =  $this->input->get('seguro_costo');

        $direccion_canjeante = $this->direccion_canjeante($folio_canjeante);

        #if(preg_match('/[^a-z\s-][A-Z\s-]+/i', $folio_vale)){
        if(preg_match('/[a-z][A-Z]+/i', $folio_vale)){
              $electronico = true;
        }else{
              $electronico = false;
        }
        #$electronico = true;

        $plaza   = $this->tienda_equivalencia($tienda);
          $tieneseguro  = $plaza[0]->insurance;
          $monto_poliza = $plaza[0]->montopoliza;
          $folio_poliza = $plaza[0]->numeropoliza;
          $certificado  = $plaza[0]->certificado;
          $id_plaza     = $plaza[0]->id_plaza;
          $id_tienda    = $plaza[0]->idStore;
          $id_insurance = (floatval($plaza[0]->idInsurance) * floatval($quincenas));
          $pago_quincenal = @round((floatval($importeoriginal) / floatval($quincenas)) + floatval($seguro_quincenas));
          $plaza         = $plaza[0]->plaza;


    if($seguro == true){
      $fecha_actual = date("d-m-Y");
      $fechahasta = date("d-m-Y",strtotime($fecha_actual."+ 30 days"));
    }

    $ticket_content = array(
      'tienda' => $tienda,
      'caja' => $caja,
      'tienda_nombre' => $tienda_nombre,
      'tienda_calle_numero' => $tienda_calle_numero,
      'tienda_colonia' => $tienda_colonia,
      'folio_vale' => $folio_vale,
      'quincenas' => $quincenas,
      'folio_distribuidor' => $folio_distribuidor,
      'distribuidor' => $distribuidor,
      'canjeante' => $canjeante,
      'folio_canjeante' => $folio_canjeante,
      'pagos_quincenales' => number_format($pago_quincenal,2,'.',','),
      'fecha_pago' => date("d/m/Y",strtotime($fecha_pago)),
      'plaza' => $plaza,
      'fechahoy' => date('d/m/Y'),
      'horahoy' => date('H:i:s'),
      'telefono' => $telefono_canjeante,
      'direccion' => $direccion_canjeante,
      'montopoliza' => $monto_poliza,
      'foliopoliza' => $folio_poliza,
      'folio' => str_pad($folio_revale, 10, "0", STR_PAD_LEFT),
      'fecha_actual' => date('d/m/Y H:i:s'),
      'valeOrigen' => $valeorigen,
      'fecha_exp' => $fecha_exp,
      'fechahasta' => $fechahasta,
      'id_customer'  => $folio_canjeante,
      'name'  => $nombre_canjeante,
      'middleName'  => $nombre2_canjeante,
      'lastName'  => $paterno_canjeante,
      'secondLastName' => $materno_canjeante,
      'cliente_telefono' => $telefono_canjeante,
      'impoteOrig' => number_format($importeoriginal,2,'.',','),
      'monto' => number_format($monto_revale,2,'.',','),
      'importeDispLetra' => $monto_revale_letra,
      'firma' => $firma_canjeante,
      'codigodebarras' => $codigodebarras,
      'rfc' => $rfc_canjeante,
      'sexo' => $sexo_canjeante,
      'beneficiario_nombre' => $beneficiario_nombre,
      'beneficiario_parentesco' => $beneficiario_parentesco,
      'beneficiario_porcentaje' => $beneficiario_porcentaje,
      'certificado'=> str_pad($folio_vale, 10, "0", STR_PAD_LEFT),
      'seguro_quincenas'=> $seguro_quincenas,
      'seguro_total'=> $seguro_total,
      'seguro_desde'=> $seguro_desde,
      'seguro_hasta'=> $this->calculo_rango_fecha($seguro_hasta),
      'seguro_monto'=> $monto_poliza,
      'tipo_vale' => 'Re-vale'
    );

    $ticket_dpvale_venta = "dpvale_venta.html";
    $ticket_dpvale_revale = "dpvale_revale.html";
    $ticket_dpvale_seguro = "dpvale_seguro.html";
    $ticket_dpvale_electronico = "dpvale_electronico.html";
    $html_seguro = '';
    $html_revale = '';
    $html_electronico = '';
    $contenido_electronico = [];
    $contenido = [];

    /*CREACION DE CODIGO DE AUTORIZACION*/
      $random = rand(10, 99);
      $mascara = $this->enmascara($folio_vale,$random);
      $Autorizacion = '1'.$mascara.$random;
      $barras_CA = barcode64('',$Autorizacion,'30','horizontal','code128',false,1);
      $array_ca = array('codeAutorizacion' => $Autorizacion, 'cb_autorizacion' => $barras_CA);

      $ticket_content = array_merge($ticket_content, $array_ca);

    /*FIN CREACION DE CODIGO DE AUTORIZACION*/

    $html_ticket = file_get_contents(base_url('/assets/templetes/').$ticket_dpvale_venta);
      $contenido[] = htmlentities($this->parser->parse_string($html_ticket, $ticket_content, TRUE));
      $contenido[] = htmlentities($this->parser->parse_string($html_ticket, $ticket_content, TRUE));

    if($revale == 'true'){
      $html_revale .= file_get_contents(base_url('/assets/templetes/').$ticket_dpvale_revale);
      $contenido[] = htmlentities($this->parser->parse_string($html_revale, $ticket_content, TRUE));
    }

    if($seguro == 'true'){
      $html_seguro .= file_get_contents(base_url('/assets/templetes/').$ticket_dpvale_seguro);
      $contenido[] = htmlentities($this->parser->parse_string($html_seguro, $ticket_content, TRUE));
      $contenido[] = htmlentities($this->parser->parse_string($html_seguro, $ticket_content, TRUE));
    }

    if($electronico == 'true'){
      $html_electronico .= file_get_contents(base_url('/assets/templetes/').$ticket_dpvale_electronico);
      $contenido_electronico[] = htmlentities($this->parser->parse_string($html_electronico, $ticket_content, TRUE));
    }

      $datos = array(
        "Status" => 1,
        "Msg" => 'Venta Almacenada',
        "CA" => $codigo_autorizacion,
        "No_tarjeta" => $folio_vale,
        "Fecha_venc" => $fecha_exp,
        "Informativo" => '',
        "HTML_R" => $contenido_electronico,
        "HTML_T" => $contenido,
        "FormaDePago" => 'DPVL'
      );

      /*ENVIO DE DATOS A SAP*/
        $sap['REFCP'] = $Autorizacion;
        $sap['NODOC'] = $folio_vale;
        $sap['WRBTR'] = number_format($importeoriginal,2,'.','');
        $sap['WAERS'] = "";
        $sap['VKBUR'] = $tienda;
        $sap['NCAJA'] = $caja;
        $sap['FECHA'] = date('Ymd');
        $sap['HORAE'] = date('His');
        $sap['PERNR'] = $tienda_vendedor*1;
        $sap['CODAU'] = $codigo_autorizacion;
        $respuesta_sap = $this->Dpvale_model->setSAP($sap);

        if(isset($respuesta_sap['response']->ErrorMessage)){
          $sap['STATUS'] = 2;
          $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
          $this->Dpvale_model->setLogSap($sap);
        }else if(! isset($respuesta_sap['response']->SapTaTReturn[0]->TYPE)){
            $sap['STATUS'] = 2;
            $sap['DESCRIP'] = 'Error en conexión, problema con WS';
            $this->Dpvale_model->setLogSap($sap);
        }else{
          if($respuesta_sap['response']->SapTaTReturn[0]->TYPE == 'E'){
            $sap['STATUS'] = 2;
            $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
            $this->Dpvale_model->setLogSap($sap);
          }else{
            $sap['STATUS'] = 1;
            $this->Dpvale_model->setLogSap($sap);
          }
        }
      /*FIN ENVIO DE DATOS A SAP*/

      /*** GUARDAR PARA EL REPORTE DPVALE DE TIENDA**/
        $rvale['tienda']      = $tienda;
        $rvale['caja']        = $caja;
        $rvale['cliente']     = "$nombre_canjeante $nombre2_canjeante $paterno_canjeante $materno_canjeante";
        $rvale['importe']     = number_format($importeoriginal,2,'.',',');
        $rvale['no_dpvl']     = $folio_vale;
        $rvale['asociado']    = $folio_distribuidor;
        $rvale['emitido_importe'] = number_format($importe_pago,2,'.',',');
        $rvale['folio_revale']    = str_pad($folio_revale, 10, "0", STR_PAD_LEFT);
        $rvale['revale_importe']  = number_format($monto_revale,2,'.',',');
        $rvale['fecha'] = date('Y-m-d');
        $rvale['hora'] = date('H:i:s');
        $res_rvale = $this->Dpvale_model->setReporteDPVL($rvale);
        if(!$res_rvale>0){
          echo "error en almacenar información del dpvale para reporte de día";
        }

      $this->Dpvale_model->setLog($datos);
      echo json_encode($datos);


  }

  public function enmascara($folio,$random){
    $cadena = str_split($folio);
    $code = '';
    $sumatorio = str_split($random);
    foreach ($cadena as $value) {
        if(!is_numeric($value)){
          $mayuscula = strtoupper($value);
          $x = ord($mayuscula);
          for ($i=0; $i < $sumatorio[0] ; $i++) {
              if($x >= 90){
                $x = 65;
              }else{
                $x++;
             }
          }
          $code .= chr($x);
        }else{
          $x = $value;
          for ($i=0; $i < $sumatorio[0] ; $i++) {
              if($x >= 9){
                $x = 0;
              }else{
                $x++;
             }
          }
          $code .= $x;
        }
    }
    return $code;
  }

  public function setBeneficiario()
  {
    if($this->validaToken())
        $bf['idrelation']     = $this->input->get('id_relationship');
        $bf['idpurchase']     = $this->input->get('id_purchase');
        $bf['name']           = $this->input->get('name');
        $bf['lastname']       = $this->input->get('last_name');
        $bf['secondlastname'] = $this->input->get('second_last_name');
        $datos = $this->Dpvale_model->setBeneficiario($bf);
    echo json_encode($datos);
  }

  private function getTopeVenta()
  {

    $g_productos = $this->input->get('productos');
    if($g_productos == 'NIP' || $g_productos == 'nip' ){
      $monto_tope_default = $this->input->get('tope');
      $monto_tope = ($monto_tope_default > 0)?$monto_tope_default:0;
    }else{
      $g_tienda = $this->tienda_conversion('tienda');

      if($g_tienda > 0 && $g_productos != '' ){
          $array_productos =  explode("|",$g_productos);
          $newArray = array();
            foreach($array_productos as $value) {
                if (empty($newArray[$value[0]])){
                    $newArray[$value[0]][]=$value[0];
                }
                $newArray[$value[0]][] = $value;
            }

            #echo "<pre>";
            #print_r($newArray);
            #echo "</pre>";
            #echo ' numero de grupos: '.count($newArray) ."<br>";
            #echo ' existe el grupo 5: '.array_key_exists('5', $newArray) ."<br>";

            if( array_key_exists('5', $newArray) == 1 && count($newArray) == 1 )
            {
                $tipo = "=5";
            }elseif( array_key_exists('5', $newArray) == 1 && count($newArray) > 1 ){
                $tipo = "<=5";
            }else{
                $tipo = "<5";
            }

            #echo " resultado a buscar: ".$tipo ."<br>";
            $monto = $this->Dpvale_model->getTopeVenta($tipo,$g_tienda);
            if(count($monto) > 0)
            {
              $monto_tope = $monto[0]->monto;
            }else{
              $monto_tope = 0;
            }
            #print_r($monto_tope);
            #echo "</pre>";
        }else{
          $monto_tope = 0;
        }
      }
      return $monto_tope;
  }

  private function getMonto()
  {
      $g_monto = $this->input->get('monto');
      if(isset($g_monto) && $g_monto>0)
        {
           $monto = $g_monto;
        }else{
            $monto = 0;
        }
      return $monto;
  }

  private function tienda_conversion($regreso = '')
  {
      $tienda = $this->input->get('tienda');
      if(isset($tienda))
        {
          if(preg_match("/SW([0-9]{5})([0-9]{5})/i", $tienda))
          {
           $tiendacaja = explode('sw',strtolower($tienda));
           $codigo['tienda'] = substr($tiendacaja[1],0,5) * 1 ;
           $codigo['caja'] = substr($tiendacaja[1],5,5) * 1;
          }else{
            $codigo['tienda']=0;
            $codigo['caja'] = 0;
         }
        }else{
          $codigo['tienda']=0;
          $codigo['caja'] = 0;
        }
        if($regreso != ''){
          if(isset($codigo[$regreso])){
              return $codigo[$regreso];
          }else{
             return $codigo;
          }
        }else{
          return $codigo;
        }

  }

  private function tienda_equivalencia($tienda)
  {
      $data = $this->Dpvale_model->getTiendaEquivalencia($tienda);
      return $data;
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

  private function calculo_rango_fecha($fecha){
    $fecha_hoy     = strtotime($fecha);
    $fecha_inicio1 = date("Y-m", strtotime($fecha)).'-07';
    $fecha_fin1    = date("Y-m", strtotime($fecha)).'-20';
    $fecha_inicio2 = date("Y-m", strtotime($fecha)).'-21';
    $fecha_fin2    = date("Y-m-t", strtotime($fecha));
    $fecha_inicio3 = date("Y-m", strtotime($fecha)).'-01';
    $fecha_fin3    = date("Y-m", strtotime($fecha)).'-06';

    if(($fecha_hoy >= strtotime($fecha_inicio1)) && ($fecha_hoy <= strtotime($fecha_fin1))) {
        $proximafecha = date("Y-m-t", strtotime($fecha));
    }else if(($fecha_hoy >= strtotime($fecha_inicio2)) && ($fecha_hoy <= strtotime($fecha_fin2))){
        $proximafecha = date("Y-m", strtotime("+1 month", strtotime($fecha))).'-15';
    }else{
        $proximafecha = date('Y-m',strtotime($fecha)).'-15';
    }
      return $proximafecha;
    }

    private function direccion_canjeante($folio){
      $datos = $this->Dpvale_model->getDireccionCanjeante($folio);
      return $datos;
    }


    public function pruebaCA(){
      /*CREACION DE CODIGO DE AUTORIZACION*/
      $folio_vale = '0021575076';
      $random = rand(10, 99);
      $mascara = $this->enmascara($folio_vale,$random);
      //$barras = $this->codigo();

      $Autorizacion = '1'.$mascara.$random;
      $importeoriginal = '500.00';
      $tienda = '0063';
      $caja = '0001';
      $tienda_vendedor  = '9483';
      $codigo_autorizacion  = '123456789';

      $nombre_canjeante= "Francisco";
      $nombre2_canjeante= "";
      $paterno_canjeante= "Rojo";
      $materno_canjeante= "Castillo";
      $folio_vale = "0021575093";
      $folio_distribuidor = '70023642';
      $folio_revale = '';
      $monto_revale = '';

      $sap['REFCP'] = $Autorizacion;
      $sap['NODOC'] = $folio_vale;
      $sap['WRBTR'] = $importeoriginal;
      $sap['WAERS'] = "";
      $sap['VKBUR'] = $tienda;
      $sap['NCAJA'] = $caja;
      $sap['FECHA'] = date('Ymd');
      $sap['HORAE'] = date('His');
      $sap['PERNR'] = $tienda_vendedor;
      $sap['CODAU'] = $codigo_autorizacion;
      $respuesta_sap = $this->Dpvale_model->setSAP($sap);
       //  print_r($respuesta_sap);

      if(isset($respuesta_sap['response']->ErrorMessage)){
        $sap['STATUS'] = 2;
        $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
        $this->Dpvale_model->setLogSap($sap);
      }else if(! isset($respuesta_sap['response']->SapTaTReturn[0]->TYPE)){
          $sap['STATUS'] = 2;
          $sap['DESCRIP'] = 'Error en conexión, problema con WS';
          $this->Dpvale_model->setLogSap($sap);
      }else{
        if($respuesta_sap['response']->SapTaTReturn[0]->TYPE == 'E'){
          $sap['STATUS'] = 2;
          $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
          $this->Dpvale_model->setLogSap($sap);
        }else{
          $sap['STATUS'] = 1;
          $this->Dpvale_model->setLogSap($sap);
        }
      }

      /*** GUARDAR PARA EL REPORTE DPVALE DE TIENDA**/
        $rvale['tienda']      = $tienda;
        $rvale['caja']        = $caja;
        $rvale['cliente']     = "$nombre_canjeante $nombre2_canjeante $paterno_canjeante $materno_canjeante";
        $rvale['importe']     = $importeoriginal;
        $rvale['no_dpvl']     = $folio_vale;
        $rvale['asociado']    = $folio_distribuidor;
        $rvale['emitido_importe'] = '';
        $rvale['folio_revale']    = $folio_revale;
        $rvale['revale_importe']  = $monto_revale;
        $rvale['fecha'] = date('Y-m-d');
        $rvale['hora'] = date('H:i:s');
        $res_rvale = $this->Dpvale_model->setReporteDPVL($rvale);
        if(!$res_rvale>0){
          echo "error en almacenar información del dpvale para reporte de día";
        }
    //  echo $Autorizacion;
    }

    public function exito(){
      $this->load->view('dpvale-exito');
    }
  }
