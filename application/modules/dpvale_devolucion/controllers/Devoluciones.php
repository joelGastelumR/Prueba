<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Devoluciones extends MY_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model("Devoluciones_model");
      $this->ci_minifier->init(1);
      $this->ci_minifier->enable_obfuscator();
      $this->hash = $this->security->get_csrf_hash();
      $this->load->library('parser');
      $this->load->library('NumerosEnLetras');
      $this->load->helper('barcode');
  }

  public function index(){
    if(!isset($_GET['folio'])){
      $folio = "";
    }else{
      $folio = $_GET['folio'];
    }

    if(!isset($_GET['monto'])){
      $monto = "";
    }else{
      $monto = str_replace(',','', $_GET['monto']);
      $monto = str_replace(' ','', $monto);
      $monto = trim($monto);
    }

    if(!isset($_GET['tienda'])){
      $numtienda = "";
    }else{
      $numtienda = $_GET['tienda'];
      $info_tienda = $this->tienda_conversion($_GET['tienda']);
    }

    if(!isset($_GET['calle'])){
      $callenumtienda = "";
    }else{
      $callenumtienda = $_GET['calle'];
    }

    if(!isset($_GET['colonia'])){
      $coloniatienda = "";
    }else{
      $coloniatienda = $_GET['colonia'];
    }

    if(!isset($_GET['nombre'])){
      $nombretienda = "";
    }else{
      $nombretienda = $_GET['nombre'];
    }

    if(!isset($_GET['cp'])){
      $cptienda = "";
    }else{
      $cptienda = $_GET['cp'];
    }

    if(!isset($_GET['telefono'])){
      $telefonotienda = "";
    }else{
      $telefonotienda = $_GET['telefono'];
    }

    if(!isset($_GET['ciudad'])){
      $ciudadtienda = "";
    }else{
      $ciudadtienda = $_GET['ciudad'];
    }

    if(!isset($_GET['estado'])){
      $estadotienda = "";
    }else{
      $estadotienda = $_GET['estado'];
    }

    if(!isset($_GET['vendedor'])){
      $vendedortienda = "";
    }else{
      $vendedortienda = $_GET['vendedor'];
    }

    if(!isset($_GET['plataforma'])){
      $plataforma = "";
    }else{
      $plataforma = $_GET['plataforma'];
    }
    $plazatienda = "";
    if($folio == "" || $monto == "" || $numtienda == "" || $nombretienda == "" || $callenumtienda == "" || $coloniatienda == "" || $cptienda == "" || $telefonotienda == "" || $ciudadtienda == "" || $estadotienda == "" || $vendedortienda == "" || $plataforma == ""){
      $error['error'] = array('msg' => 'No se encontrarón datos');
      $this->load->view("devoluciones_error_views", $error);
    }else{
      $codigo = $this->tienda_conversion($numtienda);
      if($codigo){
        $plaza = $this->tienda_equivalencia($codigo['tienda']);
        foreach ($plaza as $value) {
          $plazatienda = $value->plaza;
        }
        if($plazatienda != "" || $plazatienda != null){
          $devoluciones['devolucion'] = array("folio" => $folio,"monto"=>$monto,"tienda"=>$codigo['tienda'],"caja"=>$codigo['caja'], "callenumtienda" => $callenumtienda, "coltienda" => $coloniatienda, "cptienda" => $cptienda, "telefonotienda" => $telefonotienda, "ciudadtienda" => $ciudadtienda, "estadotienda" => $estadotienda, "vendedortienda" => $vendedortienda, "nombretienda" => $nombretienda, "plaza" => $plazatienda, "plataforma" => $plataforma);
          $devoluciones['hash'] = $this->hash;
          $this->load->view("devoluciones_views", $devoluciones);
        }else {
          $error['error'] = array('msg' => 'No se encontró plaza');
          $this->load->view("devoluciones_error_views", $error);
        }
      }else{
        $error['error'] = array('msg' => 'No se encontró tienda');
        $this->load->view("devoluciones_error_views", $error);
      }
    }
  }

  public function tienda_equivalencia($tienda)
  {
      $data = $this->Devoluciones_model->getTiendaEquivalencia($tienda);
      return $data;
  }

  public function tienda_conversion($tienda){
    if(isset($tienda)){
      if(preg_match('/SW([0-9]{5})([0-9]{5})/i',$tienda)){
         $tiendacaja = explode('sw',strtolower($tienda));
         $codigo['tienda'] = substr($tiendacaja[1],0,5) * 1;
         $codigo['caja'] = substr($tiendacaja[1],5,5) * 1;

         return $codigo;
      }else{
        return false;;
      }
    }else{
      return false;
    }
  }

  public function getvale(){
    $folio = $this->input->get('folio');
    $datos = $this->Devoluciones_model->getVale($folio);
    echo json_encode($datos);
  }

  public function devolucion(){
    $idCoupon   = $this->input->get('folio');
    $idCustomer = $this->input->get('idcliente');
    $amount     = $this->input->get('monto');

    if(($idCoupon != "") || ($idCustomer != "") || ($amount != "")){
      $datos = array(
        "devolution" => array(
              "distributor_number" => $idCustomer,
              "id_coupon" => $idCoupon,
              "amount" => $amount,
          )
      );
      $data = $this->Devoluciones_model->devolucion($datos);
      echo json_encode($data);
    }else{
      echo "0";
    }
  }

  public function setRevale(){
     $idCoupon   = $this->input->get('folio');
     $idCustomer = $this->input->get('idcliente');
     $amount     = $this->input->get('monto');

     if(($idCoupon != "") || ($idCustomer != "") || ($amount != "")){
       $datos = array(
         "new-coupon" => array(
               "idCoupon"     => $idCoupon,
               "idCustomer"   => $idCustomer,
               "amount"       => $amount,
               "type"         => "2",

           )
       );
       $data = $this->Devoluciones_model->setRevale($datos);
       echo json_encode($data);
     }else{
       echo "0";
     }
 }

 public function imprimirdevolucion(){
   $data = json_decode($_GET['array']);
   $idcoupon= $data[0]->idcoupon;
   $folio_canjeante = $data[0]->folio_canjeante;
   $pagos_quincenales = $data[0]->pagos_quincenales;
   $distribuidor_nombre = $data[0]->distribuidor_nombre;
   $distribuidor_segundo_nombre = $data[0]->distribuidor_segundo_nombre;
   $distribuidor_apellido = $data[0]->distribuidor_apellido;
   $distribuidor_segundo_apellido = $data[0]->distribuidor_segundo_apellido;
   $quincenas = $data[0]->quincenas;
   $nombre_tienda = $data[0]->nombre_tienda;
   $calle_num_tienda = $data[0]->calle_num_tienda;
   $colonia_tienda = $data[0]->colonia_tienda;
   $nombretienda = $data[0]->nombretienda;
   $cptienda = $data[0]->cptienda;
   $telefonotienda = $data[0]->telefonotienda;
   $ciudadtienda = $data[0]->ciudadtienda;
   $estadotienda = $data[0]->estadotienda;
   $vendedortienda = $data[0]->vendedortienda;
   $valeOrigen = $data[0]->valeOrigen;
   $id_customer = $data[0]->idCustomer;
   $datos = $this->Devoluciones_model->getDatosCliente($id_customer);
   $nombre_cliente = $datos["response"]->results[0]->name;
   $segundo_nombre_cliente = $datos["response"]->results[0]->middleName;
   $apellido_cliente = $datos["response"]->results[0]->lastName;
   $segundo_apellido_cliente = $datos["response"]->results[0]->secondLastName;
   $folio_distribuidor = $data[0]->folio_distribuidor;
   $monto = $data[0]->monto;
   $impoteOrig = $data[0]->importeOrig;
   $ca = $data[0]->CA;
   $tienda = $data[0]->numerotienda;
   $caja = $data[0]->numerocaja;

   $fecha  = date('d/m/Y');
   $hora  = date('h:i A', time());

   $ticket_content = array(
     'folio_vale' => $idcoupon,
     'tienda_colonia' => $colonia_tienda,
     'city' => $ciudadtienda,
     'canjeante' => $nombre_cliente . " " . $segundo_nombre_cliente . " " . $apellido_cliente . " " . $segundo_apellido_cliente,
     'folio_canjeante' => $id_customer,
     'pagos_quincenales' => $pagos_quincenales,
     "distribuidor" => $distribuidor_nombre . " " . $distribuidor_segundo_nombre . " " . $distribuidor_apellido . " " . $distribuidor_segundo_apellido,
     "quincenas" => $quincenas,
     "tienda_nombre" => $nombretienda,
     "tienda_calle_numero" => $calle_num_tienda,
     "tienda_colonia" => $colonia_tienda,
     "fechadevolucion" => $fecha,
     "horadevolucion" => $hora,
     'numdistribuidor' => $folio_distribuidor,
     "montodevolucion" => number_format($monto, 2, '.', ' '),
     'valeOrigen' => $valeOrigen
   );
   $html_devolucion = file_get_contents(base_url('/assets/templetes/').'dpvale_devolucion.html',true);

   /*CREACION DE CODIGO DE AUTORIZACION*/
     $random = rand(10, 99);
     $folio = str_pad($valeOrigen, 10, "0", STR_PAD_LEFT);
     $mascara = $this->enmascara($folio,$random);
     $Autorizacion = '4'.$mascara.$random;
     $barras_CA = barcode64('',$Autorizacion,'30','horizontal','code128',false,1);
     $array_ca = array('codeAutorizacion' => $Autorizacion, 'cb_autorizacion' => $barras_CA);
     $ticket_content = array_merge($ticket_content, $array_ca);
   /*FIN CREACION DE CODIGO DE AUTORIZACION*/

   /*ENVIO DE DATOS A SAP*/
   $sap['REFCP'] = $Autorizacion;
   $sap['NODOC'] = $valeOrigen;
   $sap['WRBTR'] = number_format(str_replace("$", "", $monto),2,'.','');
   $sap['WAERS'] = "";
   $sap['VKBUR'] = trim($tienda*1);
   $sap['NCAJA'] = trim($caja*1);
   $sap['FECHA'] = date('Ymd');
   $sap['HORAE'] = date('His');
   $sap['PERNR'] = trim($vendedortienda);
   $sap['CODAU'] = trim($ca);
   $respuesta_sap = $this->Devoluciones_model->setSAP($sap);

   if(isset($respuesta_sap['response']->ErrorMessage)){
     $sap['STATUS'] = 2;
     $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
     $this->Devoluciones_model->setLogSap($sap);
   }else if(! isset($respuesta_sap['response']->SapTaTReturn[0]->TYPE)){
       $sap['STATUS'] = 2;
       $sap['DESCRIP'] = 'Error en conexión, problema con WS';
       $this->Devoluciones_model->setLogSap($sap);
   }else{
     if($respuesta_sap['response']->SapTaTReturn[0]->TYPE == 'E'){
       $sap['STATUS'] = 2;
       $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
       $this->Devoluciones_model->setLogSap($sap);
     }else{
       $sap['STATUS'] = 1;
       $this->Devoluciones_model->setLogSap($sap);
     }
   }
   /*FIN ENVIO DE DATOS A SAP*/

    //$contenido[] = htmlentities($this->parser->parse_string($html_devolucion, $ticket_content, TRUE));
    $contenido[] =   htmlentities(stripslashes(utf8_encode($this->parser->parse_string($html_devolucion, $ticket_content,TRUE))), ENT_QUOTES);
    $order   = array("\r\n", "\n", "\r","'");
    $replace = '';
    $contenido = str_replace($order, $replace, $contenido);
     $datos = array(
       "Status" => 1,
       "Msg" => 'Devolucion Exitosa',
       "CA" => $ca,
       "No_tarjeta" => $valeOrigen,
       "Fecha_venc" => '',
       "Informativo" => '',
       "HTML_R" => '',
       "HTML_T" => $contenido,
       "FormaDePago" => 'DPVL'
     );
     $this->Devoluciones_model->setLog($datos);

     /*** GUARDAR PARA EL REPORTE DPVALE DE TIENDA**/
       $rvale['tienda']      = trim($tienda*1);
       $rvale['caja']        = trim($caja*1);
       $rvale['cliente']     = "$nombre_cliente $segundo_nombre_cliente $apellido_cliente $segundo_apellido_cliente";
       $rvale['importe']     = number_format($monto,2,'.',',');
       $rvale['no_dpvl']     = $valeOrigen;
       $rvale['asociado']    = $folio_distribuidor;
       $rvale['emitido_importe'] = number_format($impoteOrig,2,'.',',');
       $rvale['folio_revale']    = '';
       $rvale['revale_importe']  = '';
       $rvale['fecha'] = date('Y-m-d');
       $rvale['hora'] = date('H:i:s');
       $res_rvale = $this->Devoluciones_model->setReporteDPVL($rvale);
       if(!$res_rvale>0){
        // echo "error en almacenar información del dpvale para reporte de día";
       }

       //echo json_encode($datos);
       echo json_encode($datos, JSON_HEX_QUOT | JSON_HEX_TAG);
 }

 public function imprimir(){
   $data = json_decode($_GET['array']);
   $idcoupon= $data[0]->idcoupon;
   $folio_distribuidor = $data[0]->folio_distribuidor;
   $folio_canjeante = $data[0]->folio_canjeante;
   $distribuidor_nombre = $data[0]->distribuidor_nombre;
   $distribuidor_segundo_nombre = $data[0]->distribuidor_segundo_nombre;
   $distribuidor_apellido = $data[0]->distribuidor_apellido;
   $distribuidor_segundo_apellido = $data[0]->distribuidor_segundo_apellido;
   $name= $data[1]->name_customer;
   $middleName= $data[1]->middleName_customer;
   $lastName= $data[1]->lastName_customer;
   $secondLastName= $data[1]->secondLastName_customer;
   $folio = $data[1]->folio;
   $telefonotienda = $data[1]->telefonotienda;
   $plazatienda = $data[1]->plazatienda;
   $valeOrigen = $data[0]->valeOrigen;
   $nombre_tienda = $data[0]->nombre_tienda;
   $calle_num_tienda = $data[0]->calle_num_tienda;
   $colonia_tienda = $data[0]->colonia_tienda;
   $cptienda = $data[0]->cptienda;
   $ciudadtienda = $data[0]->ciudadtienda;
   $estadotienda = $data[0]->estadotienda;
   $vendedortienda = $data[0]->vendedortienda;
   $quincenas = $data[0]->quincenas;
   $nombretienda = $data[0]->nombretienda;
   $firma = $data[0]->firma;
   $fecha_actual_revale = date('d-m-Y h:i a');
   $impoteOrig = $data[0]->importeOrig;
   $monto = $data[0]->monto;
   $importeDisp = $impoteOrig - $monto;
   $fecha_emision= $data[1]->fecha_emision;
   $fecha_exp= $data[1]->fecha_exp;
   $id_customer= $data[1]->id_customer;
   $datos = $this->Devoluciones_model->getDatosCliente($id_customer);
   $nombre_cliente = $datos["response"]->results[0]->name;
   $segundo_nombre_cliente = $datos["response"]->results[0]->middleName;
   $apellido_cliente = $datos["response"]->results[0]->lastName;
   $segundo_apellido_cliente = $datos["response"]->results[0]->secondLastName;
   $numbertel = $datos["response"]->results[0]->phones[0]->number;
   $fecha_actual = date("d/m/Y",strtotime($fecha_actual_revale));
   $fecha_emision = date("d/m/Y",strtotime($fecha_emision));
   $nuevafecha = strtotime ( '+30 day' , strtotime ( $fecha_actual_revale ) ) ;
   $fechahoy = date("d/m/Y",strtotime ( $fecha_actual_revale));
   $fechahasta = date("d/m/Y",$nuevafecha);
   $ca = $data[0]->CA;
   $tienda = $data[0]->numerotienda;
   $caja = $data[0]->numerocaja;

   $fecha  = date('d/m/Y');
   $hora  = date('h:i A', time());

   $ticket_content = array(
     'valeOrigen' => $valeOrigen,
     'folio_distribuidor' => $folio_distribuidor,
     'folio_vale' => $idcoupon,
     "distribuidor" => $distribuidor_nombre . " " . $distribuidor_segundo_nombre . " " . $distribuidor_apellido . " " . $distribuidor_segundo_apellido,
     'canjeante' => $nombre_cliente . " " . $segundo_nombre_cliente . " " . $apellido_cliente . " " . $segundo_apellido_cliente,
     'folio_canjeante' => $folio_canjeante,
     'idcoupon' => $idcoupon,
     'name' => $name,
     'middleName' => $middleName,
     'lastName' => $lastName,
     'secondLastName' => $secondLastName,
     'nombretienda' => $nombre_tienda,
     "tienda_nombre" => $nombretienda,
     'tienda_calle_numero' => $calle_num_tienda,
     'tienda_colonia' => $colonia_tienda,
     'city' => $ciudadtienda,
     'fecha_emision' => $fecha_emision,
     'fechahoy' => $fechahoy,
     'id_customer' => $id_customer,
     'fecha_actual' => $fecha_actual_revale,
     'folio' => str_pad($folio, 10, "0", STR_PAD_LEFT),
     'telefonotienda' => $telefonotienda,
     'plazatienda' => $plazatienda,
     'cptienda' => $cptienda,
     "quincenas" => $quincenas,
     "firma" => $firma,
     "fechahasta" => $fechahasta,
     "impoteOrig" => $impoteOrig,
     "importeDisp" => $importeDisp,
     "monto" => number_format($monto, 2, '.', ' '),
     "importeDispLetra" => $this->numerosenletras->convertir($monto,'Pesos',false,'Centavos'),
     "codigodebarras" => barcode64('',str_pad($folio, 10, "0", STR_PAD_LEFT),'30','horizontal','code128',false,1),
     "fechadevolucion" => $fecha,
     "horadevolucion" => $hora,
     "montodevolucion" => number_format($monto, 2, '.', ' '),
     'numdistribuidor' => $folio_distribuidor,
     "cliente_telefono" => $numbertel,
     "tipo_vale" => 'Reembolso'
     //"importeDispLetra" => $this->numerosenletras->convertir($importeDisp,'Pesos',false,'Centavos')
   );

   $html_devolucion = file_get_contents(base_url('/assets/templetes/').'dpvale_devolucion.html',true);

   /*CREACION DE CODIGO DE AUTORIZACION*/
     $random = rand(10, 99);
     $folio = str_pad($valeOrigen, 10, "0", STR_PAD_LEFT);
     $mascara = $this->enmascara($folio,$random);
     $Autorizacion = '4'.$mascara.$random;
     $barras_CA = barcode64('',$Autorizacion,'30','horizontal','code128',false,1);
     $array_ca = array('codeAutorizacion' => $Autorizacion, 'cb_autorizacion' => $barras_CA);
     $ticket_content = array_merge($ticket_content, $array_ca);
   /*FIN CREACION DE CODIGO DE AUTORIZACION*/

   /*ENVIO DE DATOS A SAP*/
   $sap['REFCP'] = $Autorizacion;
   $sap['NODOC'] = $valeOrigen;
   $sap['WRBTR'] = number_format(str_replace("$", "", $monto),2,'.','');
   $sap['WAERS'] = "";
   $sap['VKBUR'] = trim($tienda*1);
   $sap['NCAJA'] = trim($caja*1);
   $sap['FECHA'] = date('Ymd');
   $sap['HORAE'] = date('His');
   $sap['PERNR'] = trim($vendedortienda);
   $sap['CODAU'] = trim($ca);
   $respuesta_sap = $this->Devoluciones_model->setSAP($sap);

   if(isset($respuesta_sap['response']->ErrorMessage)){
     $sap['STATUS'] = 2;
     $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
     $this->Devoluciones_model->setLogSap($sap);
   }else if(! isset($respuesta_sap['response']->SapTaTReturn[0]->TYPE)){
       $sap['STATUS'] = 2;
       $sap['DESCRIP'] = 'Error en conexión, problema con WS';
       $this->Devoluciones_model->setLogSap($sap);
   }else{
     if($respuesta_sap['response']->SapTaTReturn[0]->TYPE == 'E'){
       $sap['STATUS'] = 2;
       $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
       $this->Devoluciones_model->setLogSap($sap);
     }else{
       $sap['STATUS'] = 1;
       $this->Devoluciones_model->setLogSap($sap);
     }
   }
   /*FIN ENVIO DE DATOS A SAP*/
   //$contenido[] = htmlentities($this->parser->parse_string($html_devolucion, $ticket_content,TRUE));
   $contenido[] = htmlentities(stripslashes(utf8_encode($this->parser->parse_string($html_devolucion, $ticket_content,TRUE))), ENT_QUOTES);
   $html_revale = file_get_contents(base_url('/assets/templetes/').'dpvale_revale.html',TRUE);
  // $contenido[] = htmlentities($this->parser->parse_string($html_revale, $ticket_content,TRUE));
   $contenido[] = htmlentities(stripslashes(utf8_encode($this->parser->parse_string($html_revale, $ticket_content,TRUE))), ENT_QUOTES);

   $order   = array("\r\n", "\n", "\r","'");
   $replace = '';
   $contenido = str_replace($order, $replace, $contenido);

   $datos = array(
     "Status" => 1,
     "Msg" => 'Devolucion Exitosa',
     "CA" => $ca,
     "No_tarjeta" => $valeOrigen,
     "Fecha_venc" => '',
     "Informativo" => '',
     "HTML_R" => '',
     "HTML_T" => $contenido,
     "FormaDePago" => 'DPVL'
   );
   $this->Devoluciones_model->setLog($datos);

   /*** GUARDAR PARA EL REPORTE DPVALE DE TIENDA**/
     $rvale['tienda']      = trim($tienda*1);
     $rvale['caja']        = trim($caja*1);
     $rvale['cliente']     = "$nombre_cliente $segundo_nombre_cliente $apellido_cliente $segundo_apellido_cliente";
     $rvale['importe']     = number_format($monto,2,'.',',');
     $rvale['no_dpvl']     = $valeOrigen;
     $rvale['asociado']    = $folio_distribuidor;
     $rvale['emitido_importe'] = number_format($impoteOrig,2,'.',',');
     $rvale['folio_revale']    = str_pad($folio, 10, "0", STR_PAD_LEFT);
     $rvale['revale_importe']  = number_format($monto,2,'.',',');
     $rvale['fecha'] = date('Y-m-d');
     $rvale['hora'] = date('H:i:s');
     $res_rvale = $this->Devoluciones_model->setReporteDPVL($rvale);
     if(!$res_rvale>0){
      // echo "error en almacenar información del dpvale para reporte de día";
     }

     //echo json_encode($datos);
     echo json_encode($datos, JSON_HEX_QUOT | JSON_HEX_TAG);
 }

 private function enmascara($folio,$random){
   $cadena = str_split($folio);
   $code = '';
   $sumatorio = str_split($random);
   foreach ($cadena as $value) {
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
   return $code;
 }
}
