<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_model extends QD_Model {

    public $table = 'catalog';
    public $primary_key = 'id';

    public $attributes = 'id, father_id, sort, name, aliases, type, disabled, uptime';
    public $list_attributes = 'id, father_id, sort, grade, name, aliases, disabled, uptime';
    public $option = array('id', 'name');

    public $rules = array(
        array(
            'field'   => 'name',
            'label'   => '分类名称',
            'rules'   => 'required'
        ),
        array(
            'field'   => 'aliases',
            'label'   => '分类别名',
            'rules'   => 'max_length[32]'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 选项输出
     * @param   String
     * @return  Array
     */
    public function get_catalog($type) {
        $catalog = array();
        $this->db->select('id, father_id, sort, grade, name');
        $this->db->where('type', $type);
        $this->db->order_by('father_id asc, sort asc');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $list = $query->result_array();
            foreach ($list as $row) {
                $catalog[$row['id']] = $row;
            }
        }
        return $catalog;
    }

    /**
     * 选项输出
     * @param   String
     * @return  Array
     */
    public function get_all_option($type) {
        $option = array();
        $this->db->select('id, father_id, sort, grade, name');
        $this->db->where('type', $type);
        $this->db->order_by('father_id asc, sort asc');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $list = $query->result_array();
            foreach ($list as $a) { //第一级
                if ($a['grade'] == 0) {
                    $option[$a['id']]['name'] = $a['name'];
                    foreach ($list as $b) { //第二级
                        if ($b['father_id'] == $a['id'] && $b['grade'] == 1) {
                            $option[$a['id']]['option'][$b['id']]['name'] = $b['name'];
                            foreach ($list as $c) { //第三级
                                if ($c['father_id'] == $b['id'] && $c['grade'] == 2) {
                                    $option[$a['id']]['option'][$b['id']]['option'][$c['id']]['name'] = $c['name'];
                                }
                            }
                        }
                    }
                }
            }
        }
        return $option;
    }
}

/* End of file catalog.php */
/* Location: ./application/models/catalog.php */