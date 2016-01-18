<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seo_model extends QD_Model {

    public $table = 'seo';
    public $primary_key = 'caller, caller_id';

    public $attributes = 'title, keywords, description';
    public $list_attributes = 'caller, caller_id, title, keywords, description, addtime, uptime';

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
}

/* End of file seo.php */
/* Location: ./application/models/seo.php */