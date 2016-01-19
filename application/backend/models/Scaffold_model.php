<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scaffold_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function dbprefix(){
        return $this->db->dbprefix;
    }

    public function list_tables(){
        return $this->db->list_tables();
    }

    public function list_tables_more(){
        $tables = array();
        $query = $this->db->query("SHOW TABLE STATUS");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $k => $row) {
                $comment = explode(";", $row->Comment);
                $tables[$row->Name] = $comment[0]; 
            }
        }
        return $tables;
    }

    public function comment($table){
        $comment = array();
        $table = $this->db->dbprefix . $table;
        $query = $this->db->query("SHOW TABLE STATUS WHERE NAME = '" . $table . "'");
        if ($query->num_rows() > 0) {
            $row = $query->row(); 
            $comment = explode(";", $row->Comment);
        }
        return $comment[0];
    }
    
    public function field_array($table){
        $result = array();
        $table = $this->db->dbprefix . $table;
        $query = $this->db->query("SHOW FULL FIELDS FROM " . $table);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result[$row->Field]['name'] = $row->Field;
                preg_match('/([a-zA-Z]+)(\(([A-Za-z0-9,\']+)\))?/', $row->Type, $matches);
                $result[$row->Field]['type'] = $type = isset($matches[1]) ? $matches[1] : NULL;
                $result[$row->Field]['max_length'] = 0;
                if (isset($matches[3])) {
                    if ($type == 'enum') {
                        $result[$row->Field]['items'] = $matches[3];
                    } elseif (is_numeric($matches[3])) {
                        $result[$row->Field]['max_length'] = $matches[3];
                    }
                }
                $result[$row->Field]['null'] = $row->Null;
                $result[$row->Field]['default'] = $row->Default;
                $result[$row->Field]['primary_key'] = ( $row->Key == 'PRI' ? 1 : 0 );
                $result[$row->Field]['comment'] = $row->Comment;
            }
        }
        return $result;
    }
}

/* End of file scaffold.php */
/* Location: ./application/models/scaffold.php */