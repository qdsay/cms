<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgets_model extends QD_Model {

    public $table = 'widgets';
    public $primary_key = 'id';

    public $attributes = 'id, name, site, image, tags, summary, detail, catalog, promote, addtime, uptime';
    public $list_attributes = 'id, name, site, image, catalog, promote, addtime, uptime';

    public $rules = array(
        array(
            'field'   => 'name',
            'label'   => 'name',
            'rules'   => 'trim|required|max_length[32]'
        ),
        array(
            'field'   => 'site',
            'label'   => 'site',
            'rules'   => 'trim|required|max_length[128]'
        ),
        array(
            'field'   => 'tags',
            'label'   => 'tags',
            'rules'   => 'max_length[255]'
        ),
        array(
            'field'   => 'summary',
            'label'   => 'summary',
            'rules'   => 'max_length[255]'
        ),
        array(
            'field'   => 'detail',
            'label'   => 'detail',
            'rules'   => ''
        ),
        array(
            'field'   => 'catalog',
            'label'   => 'catalog',
            'rules'   => 'trim|required'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file widgets.php */
/* Location: ./application/models/widgets.php */