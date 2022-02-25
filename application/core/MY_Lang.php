<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* CodeIgniter Config Extended Library
*
* This class extends the config to a database. Based on class written by Tim Wood (aka codearachnid).
*
* @package       CodeIgniter
* @subpackage    Extended Libraries
* @author        Arnas Lukosevicius (aka steelaz)
* @link          <a href="http://www.arnas.net/blog/">http://www.arnas.net/blog/</a>
* @link          https://expressionengine.com/forums/archive/topic/131762/database-based-config-library
*
*/
/* load the MX_Router class */
require APPPATH."third_party/MX/Lang.php";

class MY_Lang extends MX_Lang
{
    /**
     * CodeIgniter instance
     *
     * @var object
     */
    private $CI = NULL;

    /**
     * Database table name
     *
     * @var string
     */
    private $table = 'sysportal_dialogos';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Load config items from database
     *
     * @return void
     */
    public function load_db_items()
    {
        if (is_null($this->CI)) $this->CI = get_instance();

        if (!$this->CI->db->table_exists($this->table))
        {
          echo "no existe la tabla";
        }

        $query = $this->CI->db->get($this->table);

        foreach ($query->result() as $row)
        {
            //$this->set_item($row->nombre, $row->valor);
            $lang['custom_aviso_3'] = 'esto desde el inicio se carga';
        }

    }


}

/* End of file MY_Lang.php */
/* Location: ./application/libraries/MY_Lang.php */
