<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpvalecom_controller extends MY_Controller {



  public function __construct(){
		parent::__construct();
    $this->ci_minifier->init(1);
    $this->ci_minifier->enable_obfuscator();
    $this->hash = $this->security->get_csrf_hash();
    $this->load->model("Dpvalecom_model");
    $this->config->load_db_items();
     // $this->path_firmas = "/var/www/caja/assets/polizas/firma/"; // RUTAS PRD
     // $this->path_pdf= "/var/www/caja/assets/polizas/pdf/"; // RUTAS PRD
     // $this->plantilla_poliza = '/var/www/caja/assets/templetes/dpvale_seguro_ecommerce.html'; // RUTAS PRD
    $this->path_firmas = "/var/www/html/assets/polizas/firma/"; // RUTAS QAs
    $this->path_pdf= "/var/www/html/assets/polizas/pdf/"; // RUTAS QAs
    $this->plantilla_poliza = '/var/www/html/assets/templetes/dpvale_seguro_ecommerce.html'; // RUTAS QAs
    $this->sms_expira = 30;
    $this->load->library('user_agent');
    //date_default_timezone_set('America/Mazatlan');

    if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){
      if(isset( $_GET['itoken'] ) ){
          $this->hash = $this->input->get('itoken');
      }
    }
}


	public function index()
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
             redirect("https://cajapagos.grupodp.com.mx/dpvalecom/dpvalecom_controller/error");
             echo 'El monto no es correcto Favor de verificarlo.<br> Error: A001';
          }

          /*busco datos del api*/
          $row = $this->Dpvalecom_model->getInfo($token);

          if($row != 'error'){
            $hostvalido = $row[0]->hostvalido;

            /*valido host*/
            $server = $_SERVER['SERVER_NAME'];
            if(!$server == $hostvalido){
              $this->session->set_flashdata('mensaje','Servidor No valido, favor de revisar su autorización o Id de Cliente.<br> Error: A002');
              redirect("https://cajapagos.grupodp.com.mx/dpvalecom/dpvalecom_controller/error");
              echo "Servidor $server No valido, favor de revisar su autorización o Id de Cliente.<br> Error: A002 ";
            }

            $data['monto'] = $monto;
            $data['tienda'] = $row[0]->s2_tienda;
            $data['validacion'] = $arreglo[0];
            $data['hash'] = $this->hash;
            $data['ordenid'] = ($orden == 0 || $orden == '')?'N/A':$orden;
            $this->setSession('amount', $monto);
            $this->setSession('idbranch', $row[0]->s2_tienda);
            $this->setSession('orderId', $orden);

          }else{
            $this->session->set_flashdata('mensaje','Informacion no Valida, Favor de revisar su autorización o Id de Cliente.<br> Error: A003 ');
            redirect("https://cajapagos.grupodp.com.mx/dpvalecom/dpvalecom_controller/error");
            echo "Informacion no Valida, Favor de revisar su autorización o Id de Cliente.<br> Error: A003";
          }

        	$this->load->view('dpvalecom_view', $data);
      }else{
          $data['mensaje'] = 'Existe en un error en abrir Dpvale Checkout';
          $this->load->view('dpvalecom_error', $data);
      }
   }

   public function error(){
      $data['mensaje'] = $this->session->flashdata('mensaje');
      $this->load->view('dpvalecom_error', $data);
   }

   public function getvale()
   {
     if($this->validaToken())
           $folio = $this->security->xss_clean($this->input->get('folio'));

          /* se revisa si es apto para baneo*/
           $baneo = $this->Dpvalecom_model->getStatusBaneo($folio);
           if($baneo['status']){
             $response = ["status"=>'error',"message"=>$baneo['message']];
             die(json_encode($response));
           }
           $upFolio = strtoupper($folio);
           $raw = $this->Dpvalecom_model->getVale($upFolio, $this->hash);

           $respuesta = [];
           try{
             $datos = $raw['response'];
           }catch (Exception $e){
             $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo <br><small>code:A58</small>'];
             die(json_encode($response));
           }

           if(isset($datos->ErrorMessage)){
             if(isset($datos->ErrorMessage->status)){
               $msj = $this->interprete($datos->ErrorMessage->msn);
               $response = ["status"=>'error',"message"=>$msj.'<br><small>code:A55</small>'];
             }else if(isset($datos->ErrorMessage->Titulo)){
               $response = ["status"=>'error',"message"=>$datos->ErrorMessage->Titulo.'<br><small>code:A56</small>'];
             }else{
               $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo <br><small>code:A57</small>'];
             }
             die(json_encode($response));
           }

           $status_code   = $datos->coupon->status;
           $id_coupon     = $datos->coupon->id;
           $status_mensaje=$this->statusVale($datos->coupon->status);

           if($status_code != 3){ //SI ES 3 ES VALE ACTIVO
             $response = ["status"=>'error',"message"=>$status_mensaje.' <br><small>code:A59</small>'];
             die(json_encode($response));
           }

           //VALIDACION DE SOLO VALE ELECTRONICO Y SEA VALE CALZADO;
           $tipo_vale = $datos->coupon->id_charge_type;
           if($tipo_vale == '' || $tipo_vale == null || $tipo_vale <= 0){
             $response = ["status"=>'error',"message"=>'El dpvale no es valido, pues no es dpvale Electrónico'];
             die(json_encode($response));
           }
           if($tipo_vale > 1){
             $response = ["status"=>'error',"message"=>'El dpvale no es valido, no es dpvale para Calzado'];
             die(json_encode($response));
           }

           //VALIDACION DE CONGELADO EN OFICINA O SISTEMA
           $congelado1 = $datos->distributor->status;
           $congelado2 = $datos->credit->status;
           $congelado3 = $datos->credit->currentMora;

           /*congelado en sistema*/
           if($congelado1 == 2 || ($congelado2 == 2 || $congelado2 == 4 || $congelado2 == 6 || $congelado2 == 7) || $congelado3 > 0)
           {
             $response = ["status"=>'error',"message"=>'No se puede procesar la compra. Contacte a su distribuidor. <br><small>A81</small>'];//El Distribuidor esta congelado desde Sistema
             die(json_encode($response));
           }
           /*congelado en oficina*/
           if($congelado2 == 2 || $congelado2 == 4 || $congelado2 == 6 || $congelado2 == 7)
           {
             $response = ["status"=>'error',"message"=>'No se puede procesar la compra. Contacte a su distribuidor. <br><small>A82</small>'];//El Distribuidor esta congelado desde Oficina
             die(json_encode($response));
           }
           /*se encuentra bloqueado*/
           if($congelado2 == 5){
             $response = ["status"=>'error',"message"=>'No se puede procesar la compra. Contacte a su distribuidor. <br><small>A83</small>'];//El Distribuidor se encuentra bloqueado
             die(json_encode($response));
           }

           //VALIDAR QUE CUBRA EL MONTO EL VALE
           $monto_del_vale = $datos->coupon->amount;
           //$monto_a_cargar = $this->session->userdata('amount_'.$this->hash);
           $monto_a_cargar =  $this->getSession('amount');

           if(!$monto_a_cargar > 0){$monto_a_cargar = 0;}

           $credito = $monto_del_vale - $monto_a_cargar;
           if($credito < 0 && $monto_del_vale > 0)
           {
             $response = ["status"=>'error',"message"=>'Monto disponible en vale es de: <b>$'. number_format($monto_del_vale,2,'.','') .'</b>, favor de verificar'];
             die(json_encode($response));
           }

           //DATOS DEL DISTRIBUIDOR
           $distribuidor_id = $datos->distributor->number;
           $distribuidor_nombre = $datos->distributor->name.' ';
           $distribuidor_nombre2 = ($datos->distributor->middleName == null || $datos->distributor->middleName == 'null')?'':$datos->distributor->middleName.' ';
           $distribuidor_apellidop = ($datos->distributor->lastName == null || $datos->distributor->lastName == 'null')?'':$datos->distributor->lastName.' ';
           $distribuidor_apellidom = ($datos->distributor->secondLastName == null || $datos->distributor->secondLastName == 'null')?'':$datos->distributor->secondLastName;

           $distributor = "$distribuidor_nombre $distribuidor_nombre2 $distribuidor_apellidop $distribuidor_apellidom";

           ///DATOS DE CANJEANTE
           $idCustomer = $datos->coupon->idCustomer; ///SE PIDE EL ID DEL CANJEANTE

           if($idCustomer == '' || $idCustomer == null || $idCustomer == 'null'){
             // NO EXISTE CANJEANTE
             $response = ["status"=>'error',"message"=>'No se encuentra canjeante para este dpvale, favor de comunicarlo a Contact Center.'];
             die(json_encode($response));
           }

             $raw2 = $this->Dpvalecom_model->getCanjeante($idCustomer, $upFolio, $this->hash);

             if(isset($raw2['response']->ErrorMessage)){
               if(isset($raw2['response']->ErrorMessage->status)){
                 $response = ["status"=>'error',"message"=>$raw2['response']->ErrorMessage->msn];
               }else if(isset($raw2['response']->ErrorMessage->Titulo)){
                 $response = ["status"=>'error',"message"=>$raw2['response']->ErrorMessage->Titulo];
               }else{
                 $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo'];
               }
               die(json_encode($response));
             }

             $cj = $raw2['response']->results[0];

             /*SE VALIDA SI ESTA ACTIVO EL CANJEANTE*/
             //$nstatus = ($cj->status == 1)?'Habilitado':($cj->status == 2)?'Deshabilitado':'Bloqueado';

             if( $cj->status != 1 ){
               $response = ["status"=>'error',"message"=>'Estas en estatus deshabilitado o bloqueado, favor de contactar a tu distribuidor'];
               die(json_encode($response));
             }

              /*CARGA EN DETALLE DEL CANJEANTE*/
             $n1=($cj->name == null)?'':$cj->name.' ';
             $n2=($cj->middleName == null)?'':$cj->middleName.' ';
             $a1=($cj->lastName == null)?'':$cj->lastName.' ';
             $a2=($cj->secondLastName == null)?'':$cj->secondLastName.' ';
             $saldo = ($cj->customer_available > 0 )?$cj->customer_available:0;
             $sexo = ($cj->gender == 1)?'Masculino':'Femenino';
             $nc = $n1.$n2.$a1.$a2;

             /*DATOS EN SESION PARA DEL CANJEANTE*/
             $this->setSession('name_customer', $nc);
             $this->setSession('sexo_customer', $sexo);
             $this->setSession('rfc_customer', $cj->rfc);

             /*OBTENER PROMOCIONES*/
            $data = $this->Dpvalecom_model->getSeguro( $this->getSession('idbranch'), $this->hash, $upFolio );
             if(count($data) == 0){
               $response = ["status"=>'error',"message"=>'Error en obtener las promociones, favor de notificarlo a contact center del dpvale'];
               die(json_encode($response));
             }

             $idplaza = $data[0]->id_plaza;
             $raw3 = $this->Dpvalecom_model->getPromociones( $idplaza, $monto_a_cargar, $this->hash, $upFolio);
             $promociones = $raw3['response'];

             if(isset($promociones->ErrorMessage)){
               if(isset($promociones->ErrorMessage->status)){
                 $response = ["status"=>'error',"message"=>$promociones->ErrorMessage->msn];
               }else if(isset($promociones->ErrorMessage->Titulo)){
                 $response = ["status"=>'error',"message"=>$promociones->ErrorMessage->Titulo];
               }else{
                 $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo'];
               }
               die(json_encode($response));
             }

             $promos = [];
             $tienepromo = $datos->coupon->enable_offer;

             if($promociones->status == 1){
                   $n=0;
                   foreach($promociones->data as $current)
                     {
                       if( $monto_a_cargar >= $current->min_amount  and  $monto_a_cargar <= $current->max_amount)
                         {
                           $hoy = date('Y-m-d');
                           $date = strtotime($current->promo_date);
                           $fecha = date('Ymd',$date);

                           if($fecha > date('Ymd')){
                             if($tienepromo == 1 || $tienepromo == 3 || $tienepromo == "1" || $tienepromo == "3" ){ //si el vale tiene 1-promocion o es 3-opcional
                                    $proximafecha = $this->calculo_rango_fecha(date('Y-m-d',strtotime($current->promo_date)));
                                     $promos[] = array(
                                       'id_offer' => $current->id_offer ,
                                       'term' => $current->term,
                                       'promo_date' => $proximafecha,
                                       'promo_date1' => $current->promo_date,
                                       'promo' => 1
                                     );
                             }
                           }else{
                               $proximafecha = $this->calculo_rango_fecha(date('Y-m-d',strtotime($hoy)));
                               $promos[] = array(
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

             }

             /*ENVIAR SMS*/
             $sms = $this->Dpvalecom_model->enviarSMS($idCustomer,$folio,$this->hash);

             if($sms['code'] == "A05"){
                   $response = ["status"=>'ok', "message"=>$sms['message']];
                   die(json_encode($response));
             }
             if($sms['code'] == "A01"){
                   $response = ["status"=>'error',"message"=>"No se puedo enviar el SMS, <b>El Canjeante no tiene registrado teléfono celular para enviar el SMS.</b><br> Favor de comunicarlo a Contact Center.<br>"];
                   die(json_encode($response));
             }
             if($sms['code'] == "A06"){
                   $response = ["status"=>'error',"message"=>"No se puedo enviar el SMS, <b>El Canjeante no tiene registrado teléfono celular para enviar el SMS.</b><br> Favor de comunicarlo a Contact Center.<br>"];
                   die(json_encode($response));
             }

              /*
              Se guardan variables en sesion temporal
              */
              $this->setSession('customer', $idCustomer);
              $this->setSession('distributor', $distribuidor_id);
              $this->setSession('idcoupon', $id_coupon);
              $this->setSession('couponAmount', $monto_del_vale);
              $this->setSession('purchaseAmount', $monto_a_cargar);


                $respuesta = [
                "Distributor"=>[
                  "nombre"=>$distributor,
                  "id"=>$distribuidor_id
                ],
                "Customer"=>[
                    "id"=>$idCustomer,
                    "nombre"=>$nc,
                    "direccion"=>(isset($cj->address->street))?$cj->address->street:'',
                    "num_ext"=>(isset($cj->address->house_number))?$cj->address->house_number:'',
                    "num_int"=>(isset($cj->address->apartment_number))?$cj->address->apartment_number:'',
                    "cp"=>(isset($cj->address->zipcode))?$cj->address->zipcode:'',
                    "colonia"=>(isset($cj->address->neighborhood))?$cj->address->neighborhood:'',
                    "ciudad"=>(isset($cj->address->city))?$cj->address->city:'',
                    "estado"=>(isset($cj->address->state))?$cj->address->state:'',
                    "sexo"=>$sexo,
                    "telefono"=>(isset($cj->phones[0]->number))?$cj->phones[0]->number:'',
                    "fnacimiento"=>(isset($cj->birthdate))?$cj->birthdate:'',
                    "saldo_disponible"=>number_format($saldo,2,'.',''),
                    "rfc"=>(isset($cj->rfc))?$cj->rfc:'',
                    "curp"=>(isset($cj->curp))?$cj->curp:'',
                  ],
                  "Promotions" => $promos,
                  "sms" => $sms
                ];

                echo json_encode($respuesta);

   }
   /*
   checkCode
   sirve para verificar el codigo que se envio al SMS
   */
   public function checkCode(){
     if($this->validaToken())
         $token = $this->security->xss_clean($this->input->get('code'));
         $ip = $this->security->xss_clean($this->input->get('key'));
         $token = $this->db->escape_str($token);

         //$sql = "SELECT id,fechahora,status FROM sms WHERE token = ? and fechahora >= CURDATE() ORDER BY id LIMIT 1 order by fechahora";
         $sql = "SELECT id,fechahora,status FROM sms WHERE token = ? and status = 1 ORDER BY id LIMIT 1";
         $query = $this->db->query($sql, array($token));
         $row = $query->row();
         $expira_sms = $this->sms_expira;
          if (isset($row)){
              $id= $row->id;
            /* se valida el status del sms */
              if($row->status > 1){
                $respuesta = ["status"=>false,"message"=>"El código de verificación ya fue usado, favor revisar"];
              }else{
                /* Se revisa si tiene mas de 30 min el mensaje */
                $fecha1= $row->fechahora;
                // echo "<pre>";
                // echo "fehha en sql ".$fecha1;
                // echo "</pre>";
                $fecha2= date("Y/m/d H:i:s");
                // echo "<pre>";
                // echo "fecha en servidor ".$fecha2;
                // echo "</pre>";
                // echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';

                $minutos = (strtotime($fecha1)-strtotime($fecha2))/60;
                $minutos = abs($minutos); $minutos = floor($minutos);

                if($minutos > $expira_sms){
                  //$res = $this->Dpvalecom_model->setReenvio($this->session->userdata('idcoupon_'.$this->hash));
                  //$res = $this->Dpvalecom_model->setIntento($this->session->userdata('idcoupon_'.$this->hash));
                  $res = $this->Dpvalecom_model->setIntento( $this->getSession('idcoupon') );
                  if($res){$a1=true;$a2=true;}else{$a1=false;$a2=false;}
                  //,"debug"=>$minutos.$res
                  $respuesta = ["status"=>false,"message"=>"El código de verificación ya expiró, favor de enviar un nuevo codigo a su telefono.","reenvio"=>$a1,"action"=>$a2];
                }else{
                  $validate = substr(sha1(rand()), 0, 20);
                  $update = array('validacion' => $validate, 'tiempo_validacion' => date('Y-m-d h:i:s'), 'ip_validacion' => $ip, "status" => 2);
                  $where = " token = '$token' AND status = 1";
                  $x = $this->db->update('sms', $update, $where);
                  $debug = "M= $minutos";
                  $respuesta = ["status"=>true,"message"=>"El código de verificación correcto", "validate"=>$validate];
                }
              }
          }else{
           //$action = $this->Dpvalecom_model->setIntento($this->session->userdata('idcoupon_'.$this->hash));
             $action = $this->Dpvalecom_model->setIntento($this->getSession('idcoupon'));
             $respuesta = ["status"=>false,"message"=>"No valido el código de verificación proporcionado","action"=>$action];
          }

         echo json_encode($respuesta);
   }

   /*
   setventa
   sirve para guardar ya la venta en S2CREDIT
  */
      public function setventa()
      {
        if($this->validaToken())
          //$idbranch_ = $this->session->userdata('idbranch_'.$this->hash);
          $idbranch_ = $this->getSession('idbranch');

         $plaza   = $this->getSeguro(
                                     $idbranch_,
                                     $this->input->get('period')
                                    );

          $idInsurance    = number_format($plaza['monto_insurance'],2,'.','');

          $datos = array(
            "purchase2" => array(
                  "customer"       => intval($this->getSession('customer')),
                  "distributor"    => intval($this->getSession('distributor')),
                  "idCoupon"       => $this->getSession('idcoupon'),
                  "date"           => date('Y-m-d'),
                  "couponAmount"   => $this->getSession('couponAmount'),
                  "purchaseAmount" => $this->getSession('purchaseAmount'),
                  "idBranch"       => $plaza['id_plaza_s2'],
                  "idStore"        => $plaza['id_tienda_s2'],
                  "idInsurance"    => ($plaza['insurance'] > 0)?$plaza['insurance']:0,
                      "purchases" => [array(
                          "chargeType"    => "1",
                          "period"        => ($this->input->get('period')>0)?$this->input->get('period'):"12",
                          "amount"        => $this->getSession('purchaseAmount'),
                          "interest"      => "",
                          "insurance"     => ($plaza['insurance'] > 0)?$idInsurance:0,
                          "firstDueDate"  => ($this->input->get('promo')=='SI')?$this->input->get('promo_s2'):date('Y-m-d'),
                          "idOffer"       => ($this->input->get('promo')=='SI')?$this->input->get('idOffer'):''
                     )]
              )
            );

          $pedido=$this->getSession('orderId');

          //$recuperacion = $this->Dpvalecom_model->RecuperarVenta($this->session->userdata('idcoupon_'.$this->hash));
          $recuperacion = $this->Dpvalecom_model->RecuperarVenta($this->getSession('idcoupon'));

          if($recuperacion == false){
              $data = $this->Dpvalecom_model->setVenta(
                                            $datos,
                                            $this->getSession('idbranch'),
                                            $pedido,
                                            $this->getSession('idcoupon'),
                                            $this->input->get('plataforma')
                                          );

              $venta =  $data['response'];

              if($venta == null){
                $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo <br>A10'];
                die(json_encode($response));
              }

              if(isset($venta->ErrorMessage)){
                if(isset($venta->ErrorMessage->status)){
                  $response = ["status"=>'error',"message"=>$venta->ErrorMessage->msn.' code:A11'];
                }else if(isset($venta->ErrorMessage->Titulo)){
                  $response = ["status"=>'error',"message"=>$venta->ErrorMessage->Titulo.' code:A12'];
                }else{
                  $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo'];
                }
                die(json_encode($response));
              }

              if(!is_object($venta)){
                $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo code:A14'];
                die(json_encode($response));
              }

              if($venta->status != 1){
                $response = ["status"=>'error',"message"=>$venta->msn];
                die(json_encode($response));
              }

          }else{
            $venta = (object) $recuperacion['response'];
          }

          $CA = $venta->purchasesGenerated;

          if($venta->insurancePeriods != null){
            $total = 0;
            $fecha = '';
            $seguro_quincenas = 0;

             if($recuperacion == false){

                //$this->session->set_userdata('id_purchase_'.$this->hash, $venta->insurancePeriods[0]->id_purchase);
                $this->setSession('id_purchase', $venta->insurancePeriods[0]->id_purchase);
                $seguro_1er_monto= $venta->insurancePeriods[0]->amortizations[0]->amount;
                $seguro_desde    = $venta->insurancePeriods[0]->amortizations[0]->date;
                $highlights =  $venta->insurancePeriods[0]->amortizations;

                foreach ($highlights as $record) {
                    if($record->amount > 0 && $seguro_quincenas == 0){
                      $seguro_quincenas = $record->amount;
                    }
                    $total += $record->amount;
                    $fecha =  $record->date;
                 }
            }else{
               //$this->session->set_userdata('id_purchase_'.$this->hash, );
               $this->setSession('id_purchase', $venta->insurancePeriods[0]['id_purchase']);
               $seguro_1er_monto= $venta->insurancePeriods[0]['amortizations'][0]['amount'];
               $seguro_desde    = $venta->insurancePeriods[0]['amortizations'][0]['date'];
               $highlights = $venta->insurancePeriods[0]['amortizations'];

               foreach ($highlights as $record) {
                   if($record['amount'] > 0 && $seguro_quincenas == 0){
                     $seguro_quincenas = $record['amount'];
                   }
                   $total += $record['amount'];
                   $fecha =  $record['date'];
                }
            }

             $seguro_total    = $total;
             $seguro_hasta    = $fecha;

             // $this->session->set_userdata('seguro_total_'.$this->hash, $seguro_total);
             // $this->session->set_userdata('seguro_1er_monto_'.$this->hash, $seguro_1er_monto);
             // $this->session->set_userdata('seguro_desde_'.$this->hash, $seguro_desde);
             // $this->session->set_userdata('seguro_hasta_'.$this->hash, $seguro_hasta);

             $this->setSession('seguro_total', $seguro_total);
             $this->setSession('seguro_1er_monto', $seguro_1er_monto);
             $this->setSession('seguro_desde', $seguro_desde);
             $this->setSession('seguro_hasta', $seguro_hasta);

             $qns = ($this->input->get('period')>0)?$this->input->get('period'):"12";
             $fp = ($this->input->get('promo')=='SI' || $this->input->get('promo')=='si')?$this->input->get('firstDueDate'):date('Y-m-d');
             //$pagosde = $this->session->userdata('couponAmount_'.$this->hash) / $qns;
             $pagosde = $this->getSession('purchaseAmount') / $qns;
             $pagosde = $pagosde + $seguro_1er_monto;
             $response = ["status"=>'ok',
                          "message"=>'Venta Generada con exito',
                          "CA"=>$CA[0],
                          "seguro"=>true,
                          "quincenas" => $qns,
                          "fechapago" => $fp,
                          "pagosde" =>$pagosde
                         ];


          }else{
            $qns = ($this->input->get('period')>0)?$this->input->get('period'):"12";
            $fp = ($this->input->get('promo')=='SI' || $this->input->get('promo')=='si')?$this->input->get('firstDueDate'):date('Y-m-d');
            $pagosde = $this->getSession('purchaseAmount') / $qns;
            $response = ["status"=>'ok',"message"=>'Venta Generada con exito','seguro'=>false,'CA'=>$CA[0],"quincenas" => $qns,"fechapago" => $fp,"pagosde" => $pagosde];

          }


        echo json_encode($response);

      }

      public function getParentescos()
      {
        $data = $this->Dpvalecom_model->getParentescos($this->hash,$this->getSession('idcoupon'));

        $datos = $data['response'];

        if($datos == ''){
          $this->jsonManual();
        }

        if(isset($datos->ErrorMessage)){
          $this->jsonManual();
        }

        echo json_encode($datos);
      }

      public function setBeneficiario()
      {
        if($this->validaToken())
            $bf = $this->security->xss_clean($this->input->get('valores'));
            parse_str($bf, $params);
            //paraDEBUG
            //$datos = $this->Dpvalecom_model->setBeneficiario($params,5116079);
            //$datos = $this->Dpvalecom_model->setBeneficiario($params,$this->session->userdata('id_purchase_'.$this->hash));

            // !Descomentar las siguietes lineas comentadas
            // $datos = $this->Dpvalecom_model->setBeneficiario($params,$this->getSession('id_purchase'),$this->hash, $this->getSession('idcoupon'));

            // $res = $datos['response'];
            // if($res == null){
            //   $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo <br><small>Codigo A19</small>'];
            //   die(json_encode($response));
            // }

            // if(isset($res->ErrorMessage)){
            //   if(isset($res->ErrorMessage->status)){
            //     $response = ["status"=>'error',"message"=>$res->ErrorMessage->msn.' <br><small>Codigo A17</small>'];
            //   }else if(isset($res->ErrorMessage->Titulo)){
            //     $response = ["status"=>'error',"message"=>$res->ErrorMessage->Titulo.' <br><small>Codigo A18</small>'];
            //   }else{
            //     $response = ["status"=>'error',"message"=>'Se tuvo problemas de comunicación, favor de intentarlo de nuevo'];
            //   }
            //   die(json_encode($response));
            // }

            // if($res->status > 1 || $res->status == 0 || $res->status == ''){
            //   $response = ["status"=>'error',"message"=>$res->msn.'<br>Codigo A20'];
            //   die(json_encode($response));
            // }
            // !HASTA AQUI SE DESCOMENTA

            $no = $this->db->escape_str($params['beneficiario_nombre']);
            $ap = $this->db->escape_str($params['beneficiario_paterno']);
            $am = $this->db->escape_str($params['beneficiario_materno']);

            // $this->session->set_userdata('beneficiario_nombre_'.$this->hash,  "$no $ap $am");
            // $this->session->set_userdata('beneficiario_parentesco_'.$this->hash, $this->db->escape_str($params['beneficiario_nparentesco']));
            // $this->session->set_userdata('beneficiario_porcentaje_'.$this->hash, $this->db->escape_str($params['beneficiario_porcentaje']));

            $this->setSession('beneficiario_nombre', "$no $ap $am");
            $this->setSession('beneficiario_parentesco', $this->db->escape_str($params['beneficiario_nparentesco']) );
            $this->setSession('beneficiario_porcentaje', $this->db->escape_str($params['beneficiario_porcentaje']) );

            $texto = $this->getPlantillaPoliza();
            /*
            AQUI YA SE GUARDO CORRECTAMENTE EL BENEFICIARIO
            SE VA A AGREGAR LA CREACION DE LA POLIZA EN PDF Y EL MESAJE DE SALIDA.
            */
            $response = ["status"=>'ok',"message"=>'Se genero con exito la poliza',"poliza"=>$texto];

            echo json_encode($response);
      }

      public function generarpoliza()
      {
        if($this->validaToken())
        $datos =  $this->security->xss_clean($this->input->get('imgdata'));
        $data = base64_decode($datos);

        $random= rand(100000, 999999);
        //$archivo = ($this->session->userdata('idcoupon_'.$this->hash) != '')?$this->session->userdata('idcoupon_'.$this->hash):$random;
        $archivo = ($this->getSession('idcoupon') != '')?$this->getSession('idcoupon'):$random;

        $filepath = $this->path_firmas . $archivo .".png";
        file_put_contents($filepath,$data);

        $this->crearPDF($archivo,$filepath);

        $existe = $this->path_pdf."/$archivo".".pdf";

        if(file_exists($existe)){
          $link = base_url()."dpvalecom/poliza/".$archivo.".pdf";
          $response = ["status"=>'ok',"message"=>'Se genero con exito la poliza',"poliza"=>$link];
          echo json_encode($response);
        }else{
          $response = ["status"=>'error',"message"=>'Error en genera la poliza'];
          echo json_encode($response);
        }
      }

      public function download($value='')
      {
        $this->load->helper('download');
        force_download($this->path_pdf.'/'.$value, NULL);
      }

      public function reenvio()
      {
        if($this->validaToken())
        $folio =  $this->security->xss_clean($this->input->get('folio'));
        $idCustomer=0;

        /*ENVIAR SMS*/
        $sms = $this->Dpvalecom_model->reenviarSMS($idCustomer,$folio);

        if($sms['code'] == "A05"){
              $response = ["status"=>'ok', "message"=>$sms['message']];
              die(json_encode($response));
        }
        if($sms['code'] == "A01"){
              $response = ["status"=>'error',"message"=>"No se puedo enviar el SMS, <b>El Canjeante no tiene registrado teléfono celular para enviar el SMS.</b><br> Favor de comunicarlo a Contact Center.<br>"];
              die(json_encode($response));
        }
        if($sms['code'] == "A02"){
              $response = ["status"=>'ok', "message"=>$sms['message']];
              die(json_encode($response));
        }
        if($sms['code'] == false){
              $response = ["status"=>'ok', "message"=>$sms['message']];
              die(json_encode($response));
        }

        echo json_encode($sms);
      }

    /*
      UTILERIAS
    */
   private function getPlantillaPoliza(){
     $this->load->library('parser');
     $html = file_get_contents($this->plantilla_poliza);

     $valores = array(
        "fechahoy"=>date('d-m-Y'),
        "horahoy"=>date('h:i:s'),
        "certificado"=>$this->getSession('seguro_certificado'),
        "canjeante"=>$this->getSession('name_customer'),
        "rfc"=>$this->getSession('rfc_customer'),
        "sexo"=>$this->getSession('sexo_customer'),
        "seguro_quincenas"=>$this->getSession('seguro_1er_monto'),
        "seguro_total"=>$this->getSession('seguro_total'),
        "seguro_monto"=>$this->getSession('seguro_monto'),
        "seguro_desde"=>$this->getSession('seguro_desde'),
        "seguro_hasta"=>$this->getSession('seguro_hasta'),
        "foliopoliza"=>$this->getSession('seguro_foliopoliza'),
        "beneficiario_nombre"=>$this->getSession('beneficiario_nombre'),
        "beneficiario_parentesco"=>$this->getSession('beneficiario_parentesco'),
        "beneficiario_porcentaje"=>$this->getSession('beneficiario_porcentaje')
      );

      $contenido = $this->parser->parse_string($html, $valores, TRUE);

      return $contenido;
   }


   private function crearPDF($archivo,$imagen){
     $this->load->library('html2pdf');
     $guarda = $this->path_pdf."/$archivo".".pdf";
     $firma = $this->path_firmas."$archivo".".png";

     $texto = utf8_decode($this->getPlantillaPoliza());
     $texto .= '<br><img src="'.$firma.'" width="200px"/>
                <br><br><br><br>
                <p>Firma del asegurado</p>';

     $pdf = new PDF_HTML();
    	$pdf->SetFont('Arial','',12);
    	$pdf->AddPage();
    	$pdf->WriteHTML($texto);
      $pdf->Output('F', $guarda , true);
      sleep(1);
   }

   private function jsonManual(){
     $json_manual = array(["id"=>"","value"=>"Seleccioné un parentesco"],["id"=>"2","value"=>"Padre"],
       ["id"=>"3","value"=>"Madre"],["id"=>"4","value"=>"Hijo (a)"],["id"=>"5","value"=>"Hermano (a)"],
       ["id"=>"6","value"=>"T\u00edo (a)"],["id"=>"7","value"=>"Sobrino (a)"],["id"=>"8","value"=>"Abuelo (a)"],
       ["id"=>"10","value"=>"Esposo (a)"],["id"=>"15","value"=>"Concubino (a)"],["id"=>"16","value"=>"Nieto (a)"],
       ["id"=>"17","value"=>"Amigo (a)"]);
      die(json_encode($json_manual));
   }

   private function statusVale($code){
     switch ($code) {
       case 0:
         return "Vale no existe";
         break;
       case 1:
         return "Vale con status invalido";
         break;
       case 2:
         return "Vale con status invalido";
         break;
       case 3:
         return "Vale activo";
         break;
       case 4:
         return "Vale Expirado";
         break;
       case 5:
         return "Vale cancelado";
         break;
       case 6:
         return "El vale ya ha sido utilizado";
         break;
       case 7:
         return "Vale con status invalido";
         break;
       default:
         return "Estatus no encontrado";
     }
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

   private function validaToken()
   {
     // echo $this->agent->browser();
     if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){return true;}
     $hash = $this->hash;
     $token = $this->input->get('token');
           if(strlen($token) > 0  && $token == $hash){
               return true;
           }else{
               $datos = array("status"=>"error", "message" => 'ERROR EN TOKEN, la Sesión expiró');
               die(json_encode($datos));
           }
       return false;
   }

   private function getSeguro($tienda,$periodo)
   {
       $data = $this->Dpvalecom_model->getSeguro($tienda, $this->hash, $this->getSession('idcoupon'));

       if(count($data) > 0){
             $respuesta = array(
               "id_plaza_s2"=> $data[0]->id_plaza,
               "id_tienda_s2"=>$data[0]->idStore,
               "monto_insurance"=>($data[0]->idInsurance)*($periodo),
               "insurance"=>$data[0]->insurance
             );
              // $this->session->set_userdata('seguro_certificado_'.$this->hash, $data[0]->certificado);
              // $this->session->set_userdata('seguro_foliopoliza_'.$this->hash, $data[0]->numeropoliza);
              // $this->session->set_userdata('seguro_monto_'.$this->hash, $data[0]->montopoliza);

              $this->setSession('seguro_certificado',  $data[0]->certificado);
              $this->setSession('seguro_foliopoliza', $data[0]->numeropoliza);
              $this->setSession('seguro_monto', $data[0]->montopoliza);

       }else{
         $datos = array("status"=>"error", "message" => 'ERROR EN OBTENER LOS DATOS DEL SEGURO');
         die(json_encode($datos));
        }
       return $respuesta;
   }

   private function interprete($msj = ''){
      if(preg_match("/vale con referencia/i", $msj)){
        return 'Vale no existe';
      }

      return $msj;
    }

    private function setSession($name, $value){
      if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){
        $this->Dpvalecom_model->saveDBSession($this->hash, $name, $value);
      }else{
        $this->session->set_userdata($name.'_'.$this->hash, $value);
      }
    }

    private function getSession($name){
      if($this->agent->mobile() == 'Apple iPhone' || $this->agent->browser() == 'Safari' || $this->agent->browser() == 'Chrome'){
        $row = $this->Dpvalecom_model->getDBSession($this->hash, $name);
        $valor = !empty($row) ? $row[0]->valor : '';
      } else {
        $valor = $this->session->userdata($name.'_'.$this->hash);
      }
      return $valor;
    }
   /*

   PRUEBAS EXTERNAS

   */
   public function pruebaExternas($folio_vale=''){
     $res =  $this->Dpvalecom_model->RecuperarVenta($folio_vale);
     print_r($res);
   }

  }
