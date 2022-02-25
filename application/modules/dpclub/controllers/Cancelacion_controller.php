<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cancelacion_controller extends MY_Controller {


  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(0);
    //  $this->ci_minifier->enable_obfuscator();
    $this->load->model("Cancelacion_model");
    //$this->hash = $this->security->get_csrf_hash();
    $this->load->library('parser');
    $this->load->library('NumerosEnLetras');
	}

  public function index()
	{
        $this->monto = $this->getMonto();
        $this->detalle  = $this->getSku();
        $this->detalle2  = $this->getSku2();
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
        $data['detalle2'] = $this->detalle;
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


		$this->load->view('cancelacion_view', $data);
        //$this->parser->parse('/assets/templetes/ticket_clubdp.html');
        //$this->parser->parse('dpclub_view', $data);
    }
    public function getTarjeta()
    {
      $tarjeta= $this->input->get('Tarjeta');
      $fecha= $this->input->get('Fecha');
      $tipo= $this->input->get('Tipo');
      $tienda= $this->input->get('Tienda');
      $caja= $this->input->get('Caja');
      $datos = $this->Cancelacion_model->consulta($tarjeta, $fecha, $tipo, $tienda, $caja);
      echo json_encode($datos);
    }
    private function getplataforma()
    {
        $g_plataforma = $this->input->get('plataforma');

        return $g_plataforma;
      }
    public function ticket(){
        $tarjeta= $this->input->get('Tarjeta');
        $hora= $this->input->get('Hora');
        $fecha= $this->input->get('Fecha');
        $tienda= $this->input->get('Tienda');
        $caja= $this->input->get('Caja');
        $cm= $this->input->get('Consecutivopos');
        $monto= $this->input->get('Monto');
        $auto= $this->input->get('Promo');
        $tipo= $this->input->get('Tipo');
        $vendedor= $this->input->get('Vendedor');
        $calle= $this->input->get('Calle');
        $colonia= $this->input->get('Colonia');
        $cp= $this->input->get('Cp');
        $telefono= $this->input->get('Telefono');
        $ciudad= $this->input->get('Ciudad');
        $estado= $this->input->get('Estado');
        $plataforma = $this->input->get('Plataforma');

        if ($plataforma == 'Pruebas')
        {
        $ver = FALSE;
        }
        else{
          $ver = TRUE;
        }
      $ticket_content = array(
        'Fecha' => $fecha,
        'NoTarjeta' => $tarjeta,
        'Hora' => $hora,
        'Monto' => $monto,
        'pp' => $auto,
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

    $ticket_cancelacion = "ticket_clubdpcancelacion.html";

    $template = file_get_contents(base_url('/assets/templetes/').$ticket_cancelacion);
    $ticket = str_replace('↵',"",$template);

    $contenido[] = $this->parser->parse_string($ticket, $ticket_content, $ver);

    if($plataforma != 'Pruebas'){
     $datos = array(
       "Status" => 1,
       "Msg" => 'Cancelacion Exitosa',
       "CA" =>$cm,
       "No_tarjeta" => $tarjeta,
       "Fecha_venc" => '',
       "PaymentPlan" =>$auto,
       "HTML_R" => '',
       "HTML_T" => $contenido,
       "FormaDePago" => 'Dpclub'
     );
     echo json_encode($datos);
   }


    }
    public function ticket2(){
        $tarjeta= $this->input->get('Tarjeta');
        $hora= $this->input->get('Hora');
        $fecha= $this->input->get('Fecha');
        $tienda= $this->input->get('Tienda');
        $caja= $this->input->get('Caja');
        $cm= $this->input->get('Consecutivopos');
        $monto= $this->input->get('Monto');
        $auto= $this->input->get('Promo');
        $tipo= $this->input->get('Tipo');
        $vendedor= $this->input->get('Vendedor');
        $calle= $this->input->get('Calle');
        $colonia= $this->input->get('Colonia');
        $cp= $this->input->get('Cp');
        $telefono= $this->input->get('Telefono');
        $ciudad= $this->input->get('Ciudad');
        $estado= $this->input->get('Estado');

      #  $this->numerosenletras->convertir($importeDisp,'Pesos',false,'Centavos')

      $ticket_content = array(
        'Fecha' => $fecha,
        'NoTarjeta' => $tarjeta,
        'Hora' => $hora,
        'Monto' => $monto,
        'pp' => $auto,
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

    $ticket_cancelacion = "ticket_clubdpcancelacion.html";

    $ticket = file_get_contents(base_url('/assets/templetes/').$ticket_cancelacion);

    $homepage = $this->parser->parse_string($ticket, $ticket_content);


    }
    public function cancelacion(){
      $tarjeta= $this->input->get('Tarjeta');
      $fecha= $this->input->get('Fecha');
      $monto= $this->input->get('Monto');
      $promo= $this->input->get('Promo');
      $caja= $this->input->get('Caja');
      $tienda= $this->input->get('Tienda');
      $tipo= $this->input->get('Tipo');
      $detalle= $this->input->get('Detalle');
      $datos = $this->Cancelacion_model->webser($tarjeta, $fecha, $monto, $promo, $caja, $tipo, $tienda, $detalle);
      echo json_encode($datos);
    }

    private function getVendedor()
    {
        $g_vendedor = $this->input->get('vendedor');

        return $g_vendedor;
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
      $datos = $this->Cancelacion_model->validabin($tarjeta);
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
                $products = $sku.'&'.$cantidad.'&'.$unitario.','.$mtotal;
                $i++;
            }


          return $xml;



            #echo "<pre>";
            #print_r($newArray);
            #echo ' numero de grupos: '.count($newArray) ."<br>";
            #echo ' existe el grupo 5: '.array_key_exists('5', $newArray) ."<br>";

}
    }
    private function getSku2()
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


                $products = $sku.'&'.$cantidad.'&'.$unitario.','.$mtotal;
                $i++;
            }


          return $products;



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

	}
