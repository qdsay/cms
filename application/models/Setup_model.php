<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup_model extends QD_Model {

    public $table = 'setup';
    public $primary_key = 'id';

    public $attributes = 'id, item, alias, content';
    public $list_attributes = 'id, item, alias';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 列表查询
     * @return  Array
     */
    function get_all($where = array(), $order = '') {
        $result = array();
        $this->db->select('id, item, alias, content');
        if (!empty($where)) $this->db->where($where);
        if (!empty($order)) $this->db->order_by($order);
        $query = $this->db->get($this->table);
        foreach($query->result_array() as $row){
            $result[$row['alias']] = $row['content'];
        }
        return $result;
    }
}

/* End of file setup.php */
/* Location: ./application/models/setup.php */