<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_model extends QD_Model {

    public $table = 'catalog';
    public $primary_key = 'id';

    public $attributes = 'id, father_id, sort, name, aliases, type, uptime';
    public $list_attributes = 'id, father_id, sort, grade, name, aliases, uptime';
    public $option = array('id, name');

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 选项输出
     * @param   String
     * @return  Array
     */
    public function get_option($where = array(), $order = '') {
        $result = array();
        $this->db->select($this->list_attributes);
        if (!empty($where)) $this->db->where($where);
        if (!empty($order)) $this->db->order_by($order);
        $this->db->order_by('father_id asc, sort asc');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            foreach($query->result_array() as $row){
                $result[$row['id']] = $row['name'];
            }
        }
        return $result;
    }
}

/* End of file catalog.php */
/* Location: ./application/models/catalog.php */