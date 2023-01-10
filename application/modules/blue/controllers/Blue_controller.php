<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blue_controller extends MY_Controller {


  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(1);
    $this->ci_minifier->enable_obfuscator();
    $this->load->model("Blue_model");
    //$this->hash = $this->security->get_csrf_hash();
    $this->load->library('parser');
    $this->load->helper('barcode');
	}

	public function index()
{
  $this->monto = $this->getMonto();
  $this->tienda = $this->tienda_conversion('tienda');
  $this->caja = $this->tienda_conversion('caja');
  $this->vendedor = $this->getVendedor();
  $this->cajero = $this->getCajero();
  $this->supervisor = $this->getSupervisor();
  $this->csupervisor = $this->getCsupervisor();
  $this->cvendedor = $this->getCven();
  $this->ccajero = $this->getCcaj();
  $this->ticket = $this->getTicket();
  $this->detalle  = $this->getSku();
  $this->calle = $this->getCalle();
  $this->colonia = $this->getColonia();
  $this->telefono = $this->getTelefono();
  $this->cp = $this->getCp();
  $this->ciudad = $this->getCiudad();
  $this->estado = $this->getEstado();
  $this->plataforma = $this->getplataforma();



  $data['monto'] = $this->monto;
  $data['vendedor'] = $this->vendedor;
  $data['ccajero'] = $this->ccajero;
  $data['csupervisor'] = $this->csupervisor;
  $data['cvendedor'] = $this->cvendedor;
  $data['cajero'] = $this->cajero;
  $data['supervisor'] = $this->supervisor;
  $data['Csupervisor'] = $this->supervisor;
  $data['ticket'] = $this->ticket;
  $data['tienda'] = $this->tienda;
  $data['detalle'] = $this->detalle;
  $data['caja'] = $this->caja;
  $data['calle'] = $this->calle;
  $data['colonia'] = $this->colonia;
  $data['telefono'] = $this->telefono;
  $data['cp'] = $this->cp;
  $data['ciudad'] = $this->ciudad;
  $data['estado'] = $this->estado;
  $data["ambiente"] = $this->plataforma;

		$this->load->view('blue_view', $data);
        //$this->parser->parse('/assets/templetes/ticket_clubdp.html');
        //$this->parser->parse('dpclub_view', $data);
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
    private function getplataforma()
    {
        $g_plataforma = $this->input->get('plataforma');

        return $g_plataforma;
 }
    private function getSku()
    {

      $g_productos = $this->input->get('productos');
      $g_tienda = $this->tienda_conversion('tienda');

      if($g_tienda > 0 && $g_productos != ''){
          $array_productos =  explode("|",$g_productos);

          $i = 0;
          $xml = "";
            foreach($array_productos as $value) {

                    $array_productos2 =  explode(",",$array_productos[$i]);


                $sku = $array_productos2[0];


                $xml.= $sku  .'|';

                $i++;
            }

          return $xml;



            #echo "<pre>";
            #print_r($newArray);
            #echo ' numero de grupos: '.count($newArray) ."<br>";
            #echo ' existe el grupo 5: '.array_key_exists('5', $newArray) ."<br>";

}
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
    private function getCajero()
    {
        $g_cajero = $this->input->get('cajero');

        return $g_cajero;
    }
    private function getCsupervisor()
    {
        $g_csupervisor = $this->input->get('csupervisor');

        return $g_csupervisor;
    }
    private function getCcaj()
    {
        $g_ccajero = $this->input->get('ccajero');

        return $g_ccajero;
    }
    private function getCven()
    {
        $g_cvendedor = $this->input->get('cvendedor');

        return $g_cvendedor;
    }
    private function getSupervisor()
    {
        $g_supervisor = $this->input->get('supervisor');

        return $g_supervisor;
    }
    private function getVendedor()
    {
        $g_vendedor = $this->input->get('vendedor');

        return $g_vendedor;

    }
    private function getTicket()
    {
        $g_ticket = $this->input->get('ticket');

        return $g_ticket;

    }

    public function balance(){
      $ccajero= $this->input->get('Ccajero');
      $csupervisor= $this->input->get('Csupervisor');
      $cvendedor= $this->input->get('Cvendedor');
      $cajero= $this->input->get('Cajero');
      $vendedor= $this->input->get('Vendedor');
      $supervisor= $this->input->get('Supervisor');
      $fecha= $this->input->get('Fecha');
      $card= $this->input->get('Card');
      $ticket= $this->input->get('Ticket');
      $tienda= $this->input->get('Tienda');
      $datos = $this->Blue_model->balance($ccajero, $csupervisor, $cvendedor, $cajero, $vendedor, $supervisor, $fecha, $card, $ticket, $tienda);
      echo json_encode($datos);
    }

    public function ticket(){
        $tarjeta= $this->input->get('Tarjeta');
        $hora= $this->input->get('Hora');
        $fecha= $this->input->get('Fecha');
        $tienda= $this->input->get('Tienda');
        $th= $this->input->get('Tarjetah');
        $caja= $this->input->get('Caja');
        $cm= $this->input->get('Consecutivopos');
        $monto= $this->input->get('Monto');
        $tipo= $this->input->get('Tipo');
        $vendedor= $this->input->get('Vendedor');
        $calle= $this->input->get('Calle');
        $colonia= $this->input->get('Colonia');
        $cp= $this->input->get('Cp');
        $telefono= $this->input->get('Telefono');
        $ciudad= $this->input->get('Ciudad');
        $estado= $this->input->get('Estado');
        $plataforma = $this->input->get('Plataforma');
        $card= $this->input->get('Card');

        if ($plataforma == 'Pruebas' || $plataforma == 'pruebas')
        {
          $ver = FALSE;
        }
        else{
          $ver = TRUE;
        }

      $ticket_content = array(
        'Fecha' => $fecha,
        'NoTarjeta' => $tarjeta,
        'Lectora' => $th,
        'Hora' => $hora,
        'Monto' => $monto,
        'IDTienda' => $tienda,
        'Domicilio' => 'ejemplo',
        'Caja' => $caja,
        'Cm' => $cm,
        'Tipo' => $tipo,
        'Calle' => $calle,
        'Colonia' => $colonia,
        'Telefono' => $telefono,
        'Cp' => $cp,
        'Ciudad' => $ciudad,
        'Estado' => $estado,
        'Vendedor' => $vendedor

    );

      $getticket = file_get_contents(base_url('/assets/templetes/').'ticket_canjeblue.html');
      $ticket = str_replace('↵',"",$getticket);

      /*CREACION DE CODIGO DE AUTORIZACION*/
        $random = rand(10, 99);
        $folio = str_pad($cm, 7, "0", STR_PAD_LEFT);
        $lastnumbers = substr($tarjeta, -3);
        $nodoc = $folio.$lastnumbers;
        $mascara = $this->enmascara($nodoc,$random);
        $Autorizacion = '3'.$mascara.$random;
        $barras_CA = barcode64('',$Autorizacion,'30','horizontal','code128',false,1);
        $array_ca = array('codeAutorizacion' => $Autorizacion, 'cb_autorizacion' => $barras_CA);

        $ticket_content = array_merge($ticket_content, $array_ca);
      /*FIN CREACION DE CODIGO DE AUTORIZACION*/

      $contenido[] = $this->parser->parse_string($ticket, $ticket_content, $ver);


      /*ENVIO DE DATOS A SAP*/
      $sap['REFCP'] = $Autorizacion;
      $sap['NODOC'] = $nodoc;
      $sap['WRBTR'] = number_format(str_replace("$", "", $monto),2,'.','');
      $sap['WAERS'] = "";
      $sap['VKBUR'] = trim($tienda*1);
      $sap['NCAJA'] = trim($caja*1);
      $sap['FECHA'] = date('Ymd');
      $sap['HORAE'] = date('His');
      $sap['PERNR'] = trim($vendedor);
      $sap['CODAU'] = trim($cm);
      $respuesta_sap = $this->Blue_model->setSAP($sap);

      if(isset($respuesta_sap['response']->ErrorMessage)){
        $sap['STATUS'] = 2;
        $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
        $this->Blue_model->setLogSap($sap);
      }else if(! isset($respuesta_sap['response']->SapTaTReturn[0]->TYPE)){
          $sap['STATUS'] = 2;
          $sap['DESCRIP'] = 'Error en conexión, problema con WS';
          $this->Blue_model->setLogSap($sap);
      }else{
        if($respuesta_sap['response']->SapTaTReturn[0]->TYPE == 'E'){
          $sap['STATUS'] = 2;
          $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
          $this->Blue_model->setLogSap($sap);
        }else{
          $sap['STATUS'] = 1;
          $this->Blue_model->setLogSap($sap);
        }
      }
      /*FIN ENVIO DE DATOS A SAP*/

      $datos = array(
       "Status" => 1,
       "Msg" => 'Canje Exitoso',
       "CA" => $cm,
       "No_tarjeta" => $tarjeta,
       "Fecha_venc" => '',
       "Informativo" => '',
       "HTML_R" => '',
       "HTML_T" => $contenido,
       "FormaDePago" => 'Blue'
      );

     $this->Blue_model->setLog($datos);
     echo json_encode($datos);
    }



    public function canje(){
      $ccajero= $this->input->get('Ccajero');
      $csupervisor= $this->input->get('Csupervisor');
      $cvendedor= $this->input->get('Cvendedor');
      $cajero= $this->input->get('Cajero');
      $vendedor= $this->input->get('Vendedor');
      $supervisor= $this->input->get('Supervisor');
      $fecha= $this->input->get('Fecha');
      $card= $this->input->get('Card');
      $ticket= $this->input->get('Ticket');
      $tienda= $this->input->get('Tienda');
      $productos= $this->input->get('Productos');
      $monto= $this->input->get('Monto');
      $cliente= $this->input->get('Cliente');
      $datos = $this->Blue_model->canje($ccajero, $csupervisor, $cvendedor, $cajero, $vendedor, $supervisor, $fecha, $card, $ticket, $tienda, $productos, $monto, $cliente);
      echo json_encode($datos);

    }
    private function getCalle()
    {
        $g_calle = $this->input->get('calle');

        return $g_calle;
    }
    private function getColonia()
    {
        $g_colonia = $this->input->get('colonia');

        return $g_colonia;
    }
    private function getCp()
    {
        $g_cp = $this->input->get('cp');

        return $g_cp;
    }
    private function getTelefono()
    {
        $g_telefono = $this->input->get('telefono');

        return $g_telefono;
    }
    private function getEstado()
    {
        $g_estado = $this->input->get('estado');

        return $g_estado;
    }
    private function getCiudad()
    {
        $g_ciudad = $this->input->get('ciudad');

        return $g_ciudad;
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
