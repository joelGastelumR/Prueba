<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_model extends CI_Model {
  public function __construct()
	{
		parent::__construct();
  }

  public function getDatos($idcliente){
     $row = $this->db->query("SELECT cliente,hostvalido,token,s2_tienda, lib.source, lib.obfuscate,lib.urlbase,lib.url_error FROM apikeys
                              INNER JOIN versionlibs AS lib ON lib.idversionlib = apikeys.libversion AND STATUS = '1'
                              WHERE apikeys.estado = '1' and idcliente = '$idcliente' ")->result();
      if($row){
        return $row;
      }else{
        return "error";
      }
  }

}
