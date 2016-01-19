<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends QD_Model {

    public $table = 'article';
    public $primary_key = 'id';

    public $attributes = 'id, title, catalog_id, image, contents, author, origin, level, enabled, addtime, uptime';
    public $list_attributes = 'id, title, catalog_id, image, author, enabled, addtime';

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file article.php */
/* Location: ./application/models/article.php */