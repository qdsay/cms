<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup_model extends QD_Model {

    public $table = 'setup';
    public $primary_key = 'id';

    public $attributes = 'id, item, alias, content';
    public $list_attributes = 'id, item, alias';

    public $rules = array(
        array(
            'field'   => 'item',
            'label'   => 'item',
            'rules'   => 'trim|required|max_length[32]'
        ),
        array(
            'field'   => 'alias',
            'label'   => 'alias',
            'rules'   => 'trim|required|max_length[32]'
        ),
        array(
            'field'   => 'content',
            'label'   => 'content',
            'rules'   => 'max_length[255]'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file setup.php */
/* Location: ./application/models/setup.php */