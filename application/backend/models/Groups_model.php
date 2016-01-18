<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_model extends QD_Model {

    public $table = 'groups';
    public $primary_key = 'id';

    public $attributes = 'id, name, auth, disabled';
    public $list_attributes = 'id, name, disabled';
    public $option = array('id', 'name');

    public $rules = array(
        array(
            'field'   => 'name',
            'label'   => '用户组',
            'rules'   => 'required'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file groups.php */
/* Location: ./application/models/groups.php */