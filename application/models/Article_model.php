<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends QD_Model {

    public $table = 'article';
    public $primary_key = 'id';

    public $attributes = 'id, title, catalog_id, image, tags, summary, contents, author, origin, level, disabled, addtime, uptime';
    public $list_attributes = 'id, title, catalog_id, image, author, disabled, addtime';

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file article.php */
/* Location: ./application/models/article.php */