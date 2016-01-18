<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appreciate_model extends QD_Model {

    public $table = 'appreciate';
    public $primary_key = 'id';

    public $attributes = 'id, name, site, logo, ued, url_id, catalog_id, promote, adapt, disabled, addtime, uptime';
    public $list_attributes = 'id, name, site, logo, url_id, catalog_id, promote, adapt, disabled, addtime, uptime';

    public $rules = array(
        array(
            'field'   => 'name',
            'label'   => 'name',
            'rules'   => 'trim|required|max_length[32]'
        ),
        array(
            'field'   => 'site',
            'label'   => 'site',
            'rules'   => 'trim|required|max_length[64]'
        ),
        array(
            'field'   => 'ued',
            'label'   => 'ued',
            'rules'   => 'max_length[64]'
        ),
        array(
            'field'   => 'catalog_id',
            'label'   => 'catalog_id',
            'rules'   => 'trim|required'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file appreciate.php */
/* Location: ./application/models/appreciate.php */