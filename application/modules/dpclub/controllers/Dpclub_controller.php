<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpclub_controller extends MY_Controller {


  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(0);
    //  $this->ci_minifier->enable_obfuscator();
    $this->load->model("Dpclub_model");
    //$this->hash = $this->security->get_csrf_hash();
    $this->load->library('parser');
    $this->load->helper('barcode');
	}

	public function index()
	{
        $this->monto = $this->getMonto();
        $this->detalle  = $this->getSku();
        $this->tienda = $this->tienda_conversion('tienda');
        $this->caja = $this->tienda_conversion('caja');
        $this->vendedor = $this->getVendedor();
        $this->calle = $this->getCalle();
        $this->colonia = $this->getColonia();
        $this->telefono = $this->getTelefono();
        $this->cp = $this->getCp();
        $this->ciudad = $this->getCiudad();
        $this->estado = $this->getEstado();
        $this->plataforma = $this->getplataforma();

        $data['monto'] = $this->monto;
        $data['detalle'] = $this->detalle;
        $data['tienda'] = $this->tienda;
        $data['caja'] = $this->caja;
        $data['vendedor'] = $this->vendedor;
        $data['calle'] = $this->calle;
        $data['colonia'] = $this->colonia;
        $data['telefono'] = $this->telefono;
        $data['cp'] = $this->cp;
        $data['ciudad'] = $this->ciudad;
        $data['estado'] = $this->estado;
        $data["ambiente"] = $this->plataforma;


    		$this->load->view('dpclub_view', $data);
  }

    public function getTarjeta()
    {
      $tarjeta= $this->input->get('Tarjeta');
      $fecha= $this->input->get('Fecha');
      $tipo= $this->input->get('Tipo');
      $tienda= $this->input->get('Tienda');
      $caja= $this->input->get('Caja');
      $datos = $this->Dpclub_model->consulta($tarjeta, $fecha, $tipo, $tienda, $caja);
      echo json_encode($datos);
    }

    public function ticket()
    {
        $tarjeta= $this->input->get('Tarjeta');
        $hora= $this->input->get('Hora');
        $fecha= $this->input->get('Fecha');
        $tienda= $this->input->get('Tienda');
        $th= $this->input->get('Tarjetah');
        $caja= $this->input->get('Caja');
        $cm= $this->input->get('Consecutivopos');
        $monto= $this->input->get('Monto');
        $promo= $this->input->get('Promo');
        $tipo= $this->input->get('Tipo');
        $vendedor= $this->input->get('Vendedor');
        $calle= $this->input->get('Calle');
        $colonia= $this->input->get('Colonia');
        $cp= $this->input->get('Cp');
        $telefono= $this->input->get('Telefono');
        $ciudad= $this->input->get('Ciudad');
        $estado= $this->input->get('Estado');
        $plataforma = $this->input->get('Plataforma');

        $ticket_clubdp = "ticket_clubdp.html";
        if ($plataforma == 'Pruebas')
        {
          $ver = FALSE;
        }else{
          $ver = TRUE;
        }

        $ticket_content = array(
        'Fecha' => $fecha,
        'NoTarjeta' => $tarjeta,
        'Lectora' => $th,
        'Hora' => $hora,
        'Monto' => $monto,
        'IDTienda' => $tienda,
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

        /*CREACION DE CODIGO DE AUTORIZACION*/
          $random = rand(10, 99);
          $folio = str_pad($cm, 6, "0", STR_PAD_LEFT);
          $lastnumbers = substr($tarjeta, -4);
          $nodoc = $folio.$lastnumbers;
          $mascara = $this->enmascara($nodoc,$random);
          $Autorizacion = '2'.$mascara.$random;
          $barras_CA = barcode64('',$Autorizacion,'30','horizontal','code128',false,1);
          $array_ca = array('codeAutorizacion' => $Autorizacion, 'cb_autorizacion' => $barras_CA);

          $ticket_content = array_merge($ticket_content, $array_ca);

        /*FIN CREACION DE CODIGO DE AUTORIZACION*/

        $template = file_get_contents(base_url('/assets/templetes/').$ticket_clubdp);
        $ticket = str_replace('↵',"",$template);

        // $contenido = $this->parser->parse_string($template, $ticket_content, $ver);
         $contenido[] = $this->parser->parse_string($ticket, $ticket_content, $ver);

         $datos = array(
          "Status" => 1,
          "Msg" => 'Canje Exitoso',
          "CA" => $cm,
          "No_tarjeta" => $tarjeta,
          "Fecha_venc" => '',
          "Informativo" => '',
          "HTML_R" => '',
          "HTML_T" => $contenido,
          "FormaDePago" => 'Dpclub'
         );

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
         $respuesta_sap = $this->Dpclub_model->setSAP($sap);

         if(isset($respuesta_sap['response']->ErrorMessage)){
           $sap['STATUS'] = 2;
           $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
           $this->Dpclub_model->setLogSap($sap);
         }else if(! isset($respuesta_sap['response']->SapTaTReturn[0]->TYPE)){
             $sap['STATUS'] = 2;
             $sap['DESCRIP'] = 'Error en conexión, problema con WS';
             $this->Dpclub_model->setLogSap($sap);
         }else{
           if($respuesta_sap['response']->SapTaTReturn[0]->TYPE == 'E'){
             $sap['STATUS'] = 2;
             $sap['DESCRIP'] = $respuesta_sap['response']->ErrorMessage->Mensaje;
             $this->Dpclub_model->setLogSap($sap);
           }else{
             $sap['STATUS'] = 1;
             $this->Dpclub_model->setLogSap($sap);
           }
         }
         /*FIN ENVIO DE DATOS A SAP*/
       $this->Dpclub_model->setLog($datos);
       echo json_encode($datos);
    }

    public function consulta()
    {
      $tarjeta= $this->input->get('Tarjeta');
      $fecha= $this->input->get('Fecha');
      $monto= $this->input->get('Monto');
      $promo= $this->input->get('Promo');
      $caja= $this->input->get('Caja');
      $tienda= $this->input->get('Tienda');
      $tipo= $this->input->get('Tipo');
      $detalle= $this->input->get('Detalle');
      $datos = $this->Dpclub_model->webser($tarjeta, $fecha, $monto, $promo, $caja, $tipo, $tienda, $detalle);
      echo json_encode($datos);
    }

    public function getPlaza()
    {
      $tienda= $this->input->get('Tienda');
      $datos = $this->Dpclub_model->getplaza($tienda);
      echo json_encode($datos);
    }

    public function getpromociones()
    {
      $bin= $this->input->get('Bin');
      $monto= $this->input->get('Monto');
      $plaza= $this->input->get('Plaza');
      $datos = $this->Dpclub_model->getpromo($bin, $monto, $plaza);
      echo json_encode($datos);
    }

    private function getVendedor()
    {
        $g_vendedor = $this->input->get('vendedor');

        return $g_vendedor;
    }

    private function getplataforma()
    {
        $g_plataforma = $this->input->get('plataforma');

        return $g_plataforma;
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

    public function validabin()
    {
      $tarjeta= $this->input->get('Bin');
      $datos = $this->Dpclub_model->validabin($tarjeta);
      echo json_encode($datos);
    }

    public function datos()
    {
      $url= $this->input->get('Url');
      $this->load->view('dpclub_view');
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
                $cantidad = $array_productos2[1];
                $unitario = $array_productos2[2];
                $mtotal = $array_productos2[3];

                $xml.= '
                <Detalles>
                   <SkuUpcCode>'.$sku.'</SkuUpcCode>
                   <Quantity>'.$cantidad.'</Quantity>
                   <UnitPrice>'.$unitario.'</UnitPrice>
                   <Amount>'.$mtotal.'</Amount>
                </Detalles>';
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
	}
