<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
        $this->data['level'] = array(1=>'推荐一',2=>'推荐二',3=>'推荐三',4=>'推荐四',5=>'推荐五',6=>'推荐六',7=>'推荐七',8=>'推荐八',9=>'推荐九');
    }

    /**
     * 首页
     * @return  Output a view
     */
    public function index()
    {
        $this->pages();
    }

    /**
     * 列表页
     * @param   Integer
     * @return  Output a view
     */
    public function pages($cur_page = 0)
    {
        //获取结果集
        $this->load->model('Article_model', 'article');
        $this->article->set_like('title', $this->input->get('title'));
        //分类查询
        $catalog = $this->catalog('article');
        $catalog_id = $this->input->get('catalog_id');
        $ids = qd_catalog_ids($catalog, intval($catalog_id));
        if (count($ids) > 1) {
            $this->article->set_where('catalog_id', $ids, 'where_in');
            $this->article->set_condition('catalog_id', $catalog_id);
        } else {
            $this->article->set_where('catalog_id', $catalog_id);
        }
        //排序
        $this->article->set_order($this->input->get('order'), 'uptime-desc');
        $this->data['list'] = $this->article->list_result($cur_page, $this->per_page);
        $this->data['where'] = $this->article->get_condition();
        $this->data['paging'] = $this->article->paging('article/pages');
        //加载关联数据
        $this->data['catalog'] = $catalog;
        //加载模板
        $this->load->view('article/list', $this->data);
    }

    /**
     * 查看文章;
     * @param   Integer
     * @return  Output a view
     */
    public function view($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Article_model', 'article');
            $this->data['article'] = $this->article->get($id);
            $this->data['catalog'] = $this->catalog('article');

            $this->load->model('Seo_model', 'seo');
            $this->data['seo'] = $this->seo->get('article', $id);

            $this->load->view('article/view',$this->data);
        }
    }
}

/* End of file article.php */
/* Location: ./application/controllers/article.php */