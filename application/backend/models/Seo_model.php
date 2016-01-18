<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seo_model extends QD_Model {

    public $table = 'seo';
    public $primary_key = 'caller, caller_id';

    public $attributes = 'caller, caller_id, title, keywords, description';
    public $list_attributes = 'caller, caller_id, title, keywords, description, addtime, uptime';

    public $rules = array(
        array(
            'field'   => 'title',
            'label'   => '标题',
            'rules'   => 'required|max_length[64]'
        ),
        array(
            'field'   => 'keywords',
            'label'   => '关键词',
            'rules'   => 'max_length[255]'
        ),
        array(
            'field'   => 'description',
            'label'   => '简介',
            'rules'   => 'max_length[255]'
        )
    );

    public $result = array();

    public function __construct()
    {
        parent::__construct();
        $this->result = array(
            'title' => '', 
            'keywords' => '', 
            'description' => ''
        );
    }

    public function get_caller($caller, $caller_id){
        $this->db->select($this->attributes);
        $this->db->where(array('caller' => $caller, 'caller_id' => $caller_id));
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $this->result = $query->first_row('array');
        }
        return $this->result;
    }

    public function set($caller, $caller_id, $data){
        $this->db->select($this->attributes);
        $query = $this->db->get_where($this->table, array(
            'caller' => $caller, 
            'caller_id' => $caller_id
        ));
        if ($query->num_rows() == 1) {
            $this->db->where(array(
                'caller' => $caller, 
                'caller_id' => $caller_id
            ));
            return $this->db->update($this->table, $data);
        } else {
            $data['caller'] = $caller;
            $data['caller_id'] = $caller_id;
            return $this->db->insert($this->table, $data);
        }
    }
}

/* End of file seo.php */
/* Location: ./application/models/seo.php */