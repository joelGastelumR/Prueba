<?php defined("BASEPATH") or die("El acceso al script no está permitido");

class Webservices {
   public function __construct() {
   }

   public function REST($cadena, $url, $metodo = 'GET',$debug = false,$raw = false){
     $headers = array(
          "Cache-Control: no-cache",
          "content-type: application/json"
      );

     if($raw){
       $json = $cadena;
     }else{
       $json = json_encode($cadena);
     }

     echo $json;
     die();
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
     curl_setopt($ch, CURLOPT_TIMEOUT, 360);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


     $response = curl_exec($ch);
     if($debug == true || $debug == TRUE || $debug == 'true' || $debug == 'TRUE'){
       $data['debug'] = curl_getinfo($ch);
       $data['request'] = $json;
     }
     $err = curl_error($ch);

     curl_close($ch);

     if ($err) {
       $data['response'] = json_encode(array("Error"=>"cURL Error #:" . $err));
     } else {
       $data['response'] = json_decode($response);
     }

     return $data;
   }

   public function WSDL($url,$cadena,$metodo = "GET")
  {
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>';
    $xml_post_string .= $cadena;

   $headers = array(
         "Content-type: text/xml;charset=\"utf-8\"",
         "Cache-Control: no-cache",
         "Pragma: no-cache",
         "Content-length: ".strlen($xml_post_string),
     );

     $ch = curl_init();
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
     curl_setopt($ch, CURLOPT_TIMEOUT, 360);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

     $response = curl_exec($ch);
     #$data['debug'] = curl_getinfo($ch);
     curl_close($ch);
     #$data['response'] = $response;

    return $response;
  }
 }
