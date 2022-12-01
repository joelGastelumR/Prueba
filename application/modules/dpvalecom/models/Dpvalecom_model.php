<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpvalecom_model extends CI_Model {
  public function __construct()
  {
    parent::__construct();
    $this->config->load_db_items();
    $this->load->library('webservices');
    // $this->url_ws_s2credit = "http://10.200.3.103:7082/pos/s2credit";
    $this->url_ws_s2credit = $this->config->item('WS_s2credit');
    // echo $this->url_ws_s2credit;
    //$this->db2 = $this->load->database('postgres',true);
    $this->db2 = $this->load->database('s2credit',true);
    $this->db3 = $this->load->database('default',true);
    $this->numero_intentos=5;
    $this->numero_reenvios=5;
    $this->tiempo_espera_intentos=10; //son minutos
    $this->tiempo_espera_reenvios=1440; // son minutos


  }

  public function getInfo($token)
  {
    $row = $this->db->query("SELECT cliente,hostvalido,token,s2_tienda FROM apikeys
                             WHERE estado = '1' and token = '$token' ")->result();
     if($row){
       return $row;
     }else{
       return "error";
     }
  }

  public function getVale($folio, $token){
        $json = array("coupon-search"=>array("coupon"=>$folio));
        $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');

        $this->setTrackingWs($token, 'getVale', $folio, $json, $data);
    return $data;
  }

  public function getCanjeante($folio, $dpvale, $token){
        $json = array("search-customer"=>array("data"=>$folio));
        $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
        $this->setTrackingWs($token, 'getCanjeante', $dpvale, $json, $data);
    return $data;
  }

  public function getPromociones($plaza,$monto,$token,$dpvale)
  {
      $json = array("offers"=>array("id_branch"=>$plaza,"amount"=>$monto,"date"=>date('Y-m-d')));
      $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
      $this->setTrackingWs($token, 'getPromociones', $dpvale, $json, $data);
    return $data;
  }

  public function getSeguro($tienda,$token,$dpvale){
      $this->db->where('tienda', $tienda);
      $data = $this->db->get('tiendas_equivalencia')->result();
      $json = array('tienda' => $tienda );
      $this->setTrackingWs($token, 'getSeguro', $dpvale, $json, $data);
      return $data;
  }

  public function enviarSMS($idCustomer,$folio, $token){
    /*Se busca el numero de telefono en la tabla de postgress*/
    /*busqueda por ID CANJEANTE*/
    //$row = $this->db2->query("SELECT cell_phone FROM voucher WHERE status = '1' and customer_id = '$idCustomer' ")->result();
    /*BUSQUEDA POR FOLIO DEL VALE EN POSTGRESS*/
    //$row = $this->db2->query("SELECT cell_phone FROM voucher WHERE status = '1' and voucher_id = '$folio' ")->result();

    $foundTel = false;
    /*BUSQUEDA EN LA TABLA DE CONFIGURACIONES[PORTAL EMPRESARIAL]*/
    $row = $this->db3->query("SELECT telefono as cell_phone FROM config_tel_vale WHERE vale ='$folio'")->result();
    if($row){
      $tel = $row[0]->cell_phone;
      $foundTel=true;
    }else{
    /*BUSQUEDA POR FOLIO DEL VALE EN S2CREDIT*/
    $row = $this->db2->query("SELECT customer_phone_number as cell_phone FROM s2credit_ecoupons WHERE reference_number_encode ='$folio' ")->result();
    if($row){$tel = $row[0]->cell_phone;$foundTel=true;}


    }
  if($foundTel){

       if(strlen($tel)>10){ $tel = substr($tel, -10); }
       if($tel == '' || strlen($tel) < 10 || $tel == 0){
          $data = ["status"=>false, "code" => "A06" ,"message"=>'Numero telefonico no encontrado'];
          $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $data);
          return $data;
       }

       $sms_tel = $tel;
       $sms_token = $this->getToken();

       //cambios sms
       /*$sms_url = $this->config->item('sms_url');
       $sms_account = $this->config->item('sms_user');
       $sms_password = $this->config->item('sms_pass');*/
       if(ENVIRONMENT=="development"){
         //NEW BUS
        // $sms_url = "http://10.200.5.89:7085/sms/api/EnviarSMS";
        //$sms_url = "http://aceqa.grupodp.com.mx:7083/sms/api/EnviarSMS";
        //OLD BUS
        $sms_url = "http://10.200.3.102:7082/sms/api/EnviarSMS";
       }else{
        $sms_url = "http://10.200.3.103:7082/sms/api/EnviarSMS";
       }

       //cambios sms
       //$sms_mensaje = "DP-$sms_token es tu código de verificación de Dpvale";
       $sms_mensaje = "DP-$sms_token es tu codigo de verificacion de dpvale";
       $hide_tel = $this->hiddenString($tel,0,3);

       //cambios sms
       /*$args = [
       "user"=>$sms_account,
       "password"=>$sms_password,
       "service"=>"1",
       "data"=> [
                  'message' => "$sms_mensaje",
                  'cellphones' => ["$sms_tel"],
                  'lada' => '1',
                  'combination' => null,
                ],
        ];*/
        $args = [
         "mensaje" => "$sms_mensaje",
         "telefonos" => ["52$sms_tel"]
        ];

        $enEspera = $this->sms_esperando($tel, $folio);

        if($enEspera){
            $data = ["status"=>true, "code" => "A04" , "message"=>'Mensaje SMS ya enviado al numero '.$hide_tel];
        }else{
          //envio el SMS
          $raw = $this->webservices->REST($args, $sms_url, 'POST');
          $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $raw);
          $response = $raw['response'];

          if( $response == '' ){
            $data = ["status"=>"error", "code" => "A05" , "message"=>'Fallo, Servicio de SMS,<br>Erro: No se pudo obtener la funcion para enviar<br>No responde el servidor'];
            $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $data);
            return $data;
          }
          if( isset( $raw['response']->ErrorMessage ) ){
            $data = ["status"=>false, "code" => "A05" , "message"=>'Fallo, Servicio de SMS,<br>Erro: No se pudo obtener la funcion para enviar<br>el webservices no responde'];
            $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $data);
            return $data;
          }

          //cambios sms
         /*if( isset( $raw['response']->Message[0]->error ) ){
           $data = ["status"=>false, "code" => "A05" , "message"=>'Fallo, Servicio de SMS,<br>Erro: No se pudo obtener la funcion para enviar<br>'.$raw['response']->Message[0]->error];
           $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $data);
           return $data;
         }*/
         if( isset( $raw['response']->requestError ) ){
           $data = ["status"=>false, "code" => "A05" , "message"=>'Fallo, Servicio de SMS,<br>Erro: No se pudo obtener la funcion para enviar<br>'.$raw['response']->Message[0]->error];
           $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $data);
           return $data;
         }

         //cambios sms
         //if( isset( $raw['response']->Message[0]->id )){
         if( isset( $raw['response']->messages[0]->messageId )){
             /* SE GUARDA EN LA TABLA SMS DE ESPERA*/
             $arreglo = array(
               "origen"=>'Dpvale-EC',
               "token"=>$sms_token,
               "telefono"=>$tel,
               "folio"=>strtoupper($folio)
             );
             $this->db->insert('sms', $arreglo);

             $data = ["status"=>true, "code" => "A03", "message"=>'Mensaje SMS enviado al numero '.$hide_tel];
         }else{
           $data = ["status"=>false, "code" => "A05" , "message"=>'Fallo, Servicio de SMS,<br>Erro: No se pudo obtener la funcion para enviar<br>'.$raw['response']->Message[0]->error];
           $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $data);
           return $data;
         }
        }
        $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $data);
        return $data;
      }else{
        $data = ["status"=>false, "code" => "A01" ,"message"=>'Numero telefonico no encontrado'];
      }
     $this->setTrackingWs($token, 'enviarSMS', $folio, $row, $data);
     return $data;
  }

  public function reenviarSMS($idCustomer,$folio_vale){
    $row = $this->db2->query("SELECT customer_phone_number as cell_phone FROM s2credit_ecoupons WHERE reference_number_encode = '$folio_vale' ")->result();
    if($row){
       $tel = $row[0]->cell_phone;
       if(strlen($tel)>10){ $tel = substr($tel, -10); }
       if($tel == '' || strlen($tel) < 10 || $tel == 0){
          $data = ["status"=>false, "code" => "A06" ,"message"=>'Numero telefonico no encontrado'];
          return $data;
       }
       $sms_tel = $tel;
       $sms_token = $this->getToken();

       //cambios sms
       /*$sms_url = $this->config->item('sms_url');
       $sms_account = $this->config->item('sms_user');
       $sms_password = $this->config->item('sms_pass');*/
       if(ENVIRONMENT=="development"){
         //NEW BUS
        // $sms_url = "http://10.200.5.89:7085/sms/api/EnviarSMS";
        //$sms_url = "http://aceqa.grupodp.com.mx:7083/sms/api/EnviarSMS";
        //OLD BUS
        $sms_url = "http://10.200.3.102:7082/sms/api/EnviarSMS";
       }else{
        $sms_url = "http://10.200.3.103:7082/sms/api/EnviarSMS";
       }

       //cambios sms
       //$sms_mensaje = "DP-$sms_token es tu código de verificación de Dpvale";
       $sms_mensaje = "DP-$sms_token es tu codigo de verificacion de dpvale";
       $hide_tel = $this->hiddenString($tel,0,3);

       //cambios sms
        /*$args = [
        "user"=>$sms_account,
        "password"=>$sms_password,
        "service"=>"1",
        "data"=> [
                   'message' => "$sms_mensaje",
                   'cellphones' => ["$sms_tel"],
                   'lada' => '1',
                   'combination' => null,
                 ],
         ];*/
         $args = [
          "mensaje" => "$sms_mensaje",
          "telefonos" => ["52$sms_tel"]
         ];

        //Reenviando el mensaje
          $raw = $this->webservices->REST($args, $sms_url, 'POST');
          $response = $raw['response'];

          if( $response == '' ){
            $data = ["status"=>false, "code" => "A05" , "message"=>'Fallo, Servicio de SMS,<br>Erro: No se pudo obtener la funcion para enviar<br>No responde el servidor'];
            return $data;
          }
          if( isset( $raw['response']->ErrorMessage ) ){
            $data = ["status"=>false, "code" => "A05" , "message"=>'Fallo, Servicio de SMS,<br>Erro: No se pudo obtener la funcion para enviar<br>el webservices no responde'];
            return $data;
          }
          //cambios sms
         /*if( isset( $raw['response']->Message[0]->error ) ){
           $data = ["status"=>false, "code" => "A02" , "message"=>"SMS error: ".$raw['response']->Message[0]->error, 'number'=>$hide_tel];
           return $data;
         }*/
         if( isset( $raw['response']->requestError ) ){
           $data = ["status"=>false, "code" => "A02" , "message"=>"SMS error: ".$raw['response']->requestError->serviceException->text, 'number'=>$hide_tel];
           return $data;
         }
         else{
            $row = $this->db->query("SELECT reenvios FROM sms WHERE status = '1' and folio = '$folio_vale'")->result();
            if($row){$num_reenvio=$row[0]->reenvios + 1;}else{$num_reenvio=1;}

            /*Se desactiva el SMS anterior*/
            $data = array('status' => 2);
            $this->db->where('folio', $folio_vale);
            $this->db->update('sms', $data);

              /* SE GUARDA EN LA TABLA SMS DE ESPERA*/
              $arreglo = array(
                "origen"=>'Dpvale-EC',
                "token"=>$sms_token,
                "telefono"=>$tel,
                "folio"=>strtoupper($folio_vale),
                "reenvios"=>$num_reenvio
              );
              $this->db->insert('sms', $arreglo);

              $data = ["status"=>true, "code" => "A03", "message"=>'Mensaje SMS enviado al numero '.$hide_tel];
          }

        return $data;
     }else{
       $data = ["status"=>false, "code" => "A01" ,"message"=>'Numero telefonico no encontrado'];
     }

     return $data;
  }

  public function setVenta($datos,$tienda,$pedido=0,$folio,$plataforma)
  {
    #debug tracking preventa
    $track = array(
      'tienda' => $tienda,
      'metodo' => 'preventa',
      'pedido' => $pedido,
      'folio' =>$folio,
      'tipo' =>'VLEC',
      'plataforma' => $plataforma,
      'request' => json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
      'fechahora' => date('Y-m-d H:i:s')
    );
    $this->setTracking($track);

    // esta linea solo se comento para debugs
    $data = $this->webservices->REST($datos, $this->url_ws_s2credit, 'POST');

    #debug tracking postventa
    $datos = array(
      'tienda' => $tienda,
      'metodo' => 'postventa',
      'pedido' => $pedido,
      'folio' =>$folio,
      'tipo' =>'VLEC',
      'plataforma' => $plataforma,
      'response' => json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
      'fechahora' => date('Y-m-d H:i:s')
    );
    $this->setTracking($datos);

    return $data;
  }

  public function getParentescos($token,$folio){
    $json = array("relationship"=>array());
    $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
    $this->setTrackingWs($token, 'getParentescos', $folio, $json, $data);
    return $data;
  }

  public function setBeneficiario($bf,$id,$token,$folio){
        $json = array("beneficiary-change"=>array(
          "id_relationship"=> $this->db->escape_str($bf['parentesco']),
          "id_purchase" => intval($id),
          "name" => $this->db->escape_str($bf['beneficiario_nombre']),
          "last_name" => $this->db->escape_str($bf['beneficiario_paterno']),
          "second_last_name" => $this->db->escape_str($bf['beneficiario_materno'])
        ));
        $data = $this->webservices->REST($json, $this->url_ws_s2credit, 'POST');
        $this->setTrackingWs($token, 'setBeneficiario', $folio, $json, $data);
    return $data;
  }

  public function setReenvio($folio_vale){
    $row = $this->db->query("SELECT reenvios FROM sms WHERE status = '1' and folio = '$folio_vale'")->result();
    if($row){
      if($row[0]->reenvios >= $this->numero_reenvios){
        $data = array('fecha_baneo' => date("Y-m-d H:i:s"));
        $this->db->where('folio', $folio_vale);
        $this->db->where('status', 1);
        $this->db->update('sms', $data);
        return false;
      }else{
        $data = array('reenvios' => $row[0]->reenvios + 1);
        $this->db->where('folio', $folio_vale);
        $this->db->where('status', 1);
        $this->db->update('sms', $data);
         $regreso = 'reenvio';
         return true;
      }
    }else{
      $data = array('reenvios' => 1);
      $this->db->insert('sms', $data);
      return true;
    }
  }

  public function setIntento($folio_vale){
    $row = $this->db->query("SELECT intentos FROM sms WHERE status = '1' and folio = '$folio_vale'")->result();
    if($row){
      if($row[0]->intentos >= $this->numero_intentos){
        $data = array('fecha_baneo' => date("Y-m-d H:i:s"));
        $this->db->where('folio', $folio_vale);
        $this->db->where('status', 1);
        $this->db->update('sms', $data);
        return false;
      }else{
        $r = $row[0]->intentos + 1;
        $data = array('intentos' => $r);
        $this->db->where('folio', $folio_vale);
        $this->db->where('status', 1);
        $this->db->update('sms', $data);
        return true;
      }
    }else{
      $data = array('reintentos' => 1);
      $this->db->insert('sms', $data);
      return true;
    }
  }

  public function getStatusBaneo($folio_vale){
    $row = $this->db->query("SELECT reenvios,intentos,fecha_baneo FROM sms WHERE status = '1' and folio = '$folio_vale'")->result();

    $respuesta['status'] = false;
    $respuesta['message']='';

    if($row){
      $fecha1= ($row[0]->fecha_baneo =='')?date("Y/m/d H:i:s"):$row[0]->fecha_baneo;

      $fecha2= date("Y/m/d H:i:s");

      if($row[0]->reenvios >= $this->numero_reenvios){
        $minutos = $this->minutosTranscurridos($fecha1,$fecha2);

        if($minutos > $this->tiempo_espera_reenvios){
          $respuesta['status'] = false;
          $respuesta['message'] = '';
          $data = array('reenvios' => 0);
          $this->db->where('folio', $folio_vale);
          $this->db->update('sms', $data);
        }else{
          $respuesta['status'] = true;
          $respuesta['message'] = 'Por superar el numero de reenvios permitidos, Debe esperar 24 horas para reactivar el vale, tiempo restante: '.(intval($this->tiempo_espera_reenvios) - intval($minutos)) .' Minutos';
        }

      }

      if($row[0]->intentos >= $this->numero_intentos){
        $minutos = $this->minutosTranscurridos($fecha1,$fecha2);

        if($minutos > $this->tiempo_espera_intentos){
          $respuesta['status'] = false;
          $respuesta['message'] = $minutos;
          $data = array('intentos' => 0);
          $this->db->where('folio', $folio_vale);
          $this->db->update('sms', $data);
        }else{
          $respuesta['status'] = true;
          $respuesta['message'] = 'Por superar el numero de intentos permitidos, Debe esperar 10 mins, tiempo restante: '.(intval($this->tiempo_espera_intentos) - intval($minutos)) .' Minutos';
        }

      }
    }
    return $respuesta;
  }

  public function RecuperarVenta($folio_vale)
  {
    $row = $this->db->query("SELECT id,response FROM log_tracking WHERE metodo = 'postventa' AND folio = '$folio_vale'")->result();

      if($row){
        foreach ($row as $fila){
          $contenido = json_decode($fila->response,true);
          if(@$contenido['response']['status']==1){
            //echo "ESTE ES EL ID QUE VOY A MANDAR $fila->id";
            return $contenido;
          }
        }
        return false;
      }else{
        return false;
      }
  }


  private function minutosTranscurridos($fecha_i,$fecha_f){
  $minutos = (strtotime($fecha_i)-strtotime($fecha_f))/60;
  $minutos = abs($minutos); $minutos = floor($minutos);
  return $minutos;
  }
  private function setTracking($datos){
        $this->db->insert('log_tracking', $datos);
  }
  public function setTrackingWs($token, $metodo, $folio, $request, $response){
     $data = array(
      'token' => $token,
      'metodo' => $metodo,
      'folio' => $folio,
      'request' => json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
      'response' => json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
      'fechahora' => date('Y-m-d H:i:s')
     );
     $this->db->insert('log_tracking_ws', $data);
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

  private function getToken(){
    $length = 7;
    return strtoupper(substr(sha1(rand()), 0, $length));
  }

  private function hiddenString($str, $start = 1, $end = 1){
    $len = strlen($str);
    return substr($str, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($str, $len - $end, $end);
  }

  private function sms_esperando($telefono,$folio){
    $row = $this->db->query("SELECT * FROM sms WHERE status = '1' and telefono = '$telefono' and folio = '$folio' ")->result();
    if($row){
      return true;
    }else{
      return false;
    }
  }



}
