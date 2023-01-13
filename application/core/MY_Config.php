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
require APPPATH."third_party/MX/Config.php";

class MY_Config extends MX_Config
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
    private $table = 'parametrosconector';


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
           $this->create_table();
        }

        $query = $this->CI->db->get($this->table);

        foreach ($query->result() as $row)
        {
            $this->set_item($row->key, $row->value);
        }

    }

    /**
     * Save config item to database
     *
     * @return bool
     * @param string $key
     * @param string $value
     */
    public function save_db_item($key, $value)
    {
        if (is_null($this->CI)) $this->CI = get_instance();

        $where = array('key' => $key);
        $found = $this->CI->db->get_where($this->table, $where, 1);
        $time = date("Y-m-d H:i:s");
        if ($found->num_rows > 0)
        {
            return $this->CI->db->update($this->table, array('value' => $value,'updated' => $time), $where);
        }
        else
        {
            return $this->CI->db->insert($this->table, array('key' => $key, 'value' => $value ,'updated' => $time));
        }
    }

    /**
     * Remove config item from database
     *
     * @return bool
     * @param string $key
     */
    public function remove_db_item($key)
    {
        if (is_null($this->CI)) $this->CI = get_instance();

        return $this->CI->db->delete($this->table, array('key' => $key));
    }

    /**
     * Create database table (using "IF NOT EXISTS")
     *
     * @return void
     */
    public function create_table()
    {
        if (is_null($this->CI)) $this->CI = get_instance();

        $this->CI->load->dbforge();

        $this->CI->dbforge->add_field("'id' int(11) NOT NULL auto_increment");
        $this->CI->dbforge->add_field("'updated' timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
        $this->CI->dbforge->add_field("'key' varchar(255) NOT NULL");
        $this->CI->dbforge->add_field("'value' text NOT NULL");

        $this->CI->dbforge->add_key('id', TRUE);

        $this->CI->dbforge->create_table($this->table, TRUE);
    }
}

/* End of file MY_Config.php */
/* Location: ./application/libraries/MY_Config.php */
