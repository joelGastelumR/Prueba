<?php
defined("BASEPATH") or die("El acceso al script no está permitido");

class Encriptacion {

   public function encriptar($string = 'NADA'){
 	    $key = 'v,vEcfhUcBQ.WSd:QT0=2(|$;JfR|WM|sZ4596.^pN+$3"A-6Ov?:(Ip>0,?&HL';
      return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
  }

  public function desencriptar($string){
	    $key = 'v,vEcfhUcBQ.WSd:QT0=2(|$;JfR|WM|sZ4596.^pN+$3"A-6Ov?:(Ip>0,?&HL';
	     return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
   }

   private function encrypt($text){
        $key = '_Ng{qi-eQ4_evg?z';
        $block = mcrypt_get_block_size('rijndael_128', 'ecb');
        $pad = $block - (strlen($text) % $block);
        $text .= str_repeat(chr($pad), $pad);
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $text, MCRYPT_MODE_ECB));
   }

   private function decrypt($str){
        $key = '_Ng{qi-eQ4_evg?z';
        $str = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB);
        $block = mcrypt_get_block_size('rijndael_128', 'ecb');
        $pad = ord($str[($len = strlen($str)) - 1]);
        $len = strlen($str);
        $pad = ord($str[$len-1]);
        return substr($str, 0, strlen($str) - $pad);
   }

   public function randomPassword($length,$count, $characters) {

    // $length - the length of the generated password
    // $count - number of passwords to be generated
    // $characters - types of characters to be used in the password

    #EJEMPLOS
        // generate one password using 5 upper and lower case characters
        #randomPassword(5,1,"lower_case,upper_case");

        // generate three passwords using 10 lower case characters and numbers
        #randomPassword(10,3,"lower_case,numbers");

        // generate five passwords using 12 lower case and upper case characters, numbers and special symbols
        #randomPassword(12,5,"lower_case,upper_case,numbers,special_symbols");


    // define variables used within the function
        $symbols = array();
        $passwords = array();
        $used_symbols = '';
        $pass = '';

    // an array of different character types
        $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
        $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $symbols["numbers"] = '1234567890';
        $symbols["special_symbols"] = '!?~@#-_+<>[]{}';

        $characters = explode(",",$characters); // get characters types to be used for the passsword
        foreach ($characters as $key=>$value) {
            $used_symbols .= $symbols[$value]; // build a string with all characters
        }
        $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

        for ($p = 0; $p < $count; $p++) {
            $pass = '';
            for ($i = 0; $i < $length; $i++) {
                $n = rand(0, $symbols_length); // get a random character from the string with all characters
                $pass .= $used_symbols[$n]; // add the character to the password string
            }
            $passwords[] = $pass;
        }

        return $passwords; // return the generated password
    }

     public function cross_encrypt($string) {
          return $this->encrypt($string);
     }

     public function cross_decrypt($string) {
          return $this->decrypt($string);
     }

}
