<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugs_model extends QD_Model {

    public $table = 'plugs';
    public $primary_key = 'id';

    public $attributes = 'id, name, keywords, description, contents, homepage, repositories, cdn, catalog, adapt, addtime, uptime';
    public $list_attributes = 'id, name, homepage, repositories, cdn, catalog, adapt, addtime, uptime';

    public $rules = array(
        array(
            'field'   => 'name',
            'label'   => 'name',
            'rules'   => 'trim|required|max_length[255]'
        ),
        array(
            'field'   => 'keywords',
            'label'   => 'keywords',
            'rules'   => 'max_length[255]'
        ),
        array(
            'field'   => 'description',
            'label'   => 'description',
            'rules'   => 'max_length[255]'
        ),
        array(
            'field'   => 'contents',
            'label'   => 'contents',
            'rules'   => ''
        ),
        array(
            'field'   => 'homepage',
            'label'   => 'homepage',
            'rules'   => 'max_length[128]'
        ),
        array(
            'field'   => 'repositories',
            'label'   => 'repositories',
            'rules'   => 'max_length[128]'
        ),
        array(
            'field'   => 'cdn',
            'label'   => 'cdn',
            'rules'   => 'max_length[128]'
        ),
        array(
            'field'   => 'catalog',
            'label'   => 'catalog',
            'rules'   => 'trim|required'
        ),
        array(
            'field'   => 'adapt',
            'label'   => 'adapt',
            'rules'   => 'trim|required|max_length[8]'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file plugs.php */
/* Location: ./application/models/plugs.php */