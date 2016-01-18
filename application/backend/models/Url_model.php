<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Url_model extends QD_Model {

    public $table = 'url';
    public $primary_key = 'id';

    public $attributes = 'id, url, favicon, title, keywords, description, promote, adapt, addtime, uptime';
    public $list_attributes = 'id, url, favicon, title, promote, adapt, addtime';

    public $rules = array(
        array(
            'field'   => 'url',
            'label'   => 'url',
            'rules'   => 'trim|required|max_length[128]'
        ),
        array(
            'field'   => 'favicon',
            'label'   => 'favicon',
            'rules'   => 'max_length[128]'
        ),
        array(
            'field'   => 'title',
            'label'   => 'title',
            'rules'   => 'max_length[128]'
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
            'field'   => 'adapt',
            'label'   => 'adapt',
            'rules'   => 'max_length[5]'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file url.php */
/* Location: ./application/models/url.php */