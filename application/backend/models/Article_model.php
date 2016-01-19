<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends QD_Model {

    public $table = 'article';
    public $primary_key = 'id';

    public $attributes = 'id, title, catalog_id, image, contents, author, origin, level, enabled, addtime, uptime';
    public $list_attributes = 'id, title, catalog_id, image, author, enabled, addtime';

    public $rules = array(
        array(
            'field'   => 'title',
            'label'   => 'title',
            'rules'   => 'trim|max_length[128]|required'
        ),
        array(
            'field'   => 'catalog_id',
            'label'   => 'catalog_id',
            'rules'   => 'is_natural_no_zero|required'
        ),
        array(
            'field'   => 'author',
            'label'   => 'author',
            'rules'   => 'trim|max_length[32]'
        ),
        array(
            'field'   => 'origin',
            'label'   => 'origin',
            'rules'   => 'trim|max_length[64]'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }

    public function set_catalog($catalog, $catalog_id) {
        $ids = qd_catalog_ids($catalog, intval($catalog_id));
        if (count($ids) > 1) {
            $this->article->set_where('catalog_id', $ids, 'where_in');
            $this->article->set_condition('catalog_id', $catalog_id);
        } else {
            $this->article->set_where('catalog_id', $catalog_id);
        }
    }
}

/* End of file article.php */
/* Location: ./application/models/article.php */