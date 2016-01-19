<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
        $this->data['current'] = '文章';
        $this->data['items'] = array('edit' => '基本信息', 'seo' => 'SEO设置');
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
        $this->article->set_catalog($catalog, $this->input->get('catalog_id'));
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
            if ($this->input->get('notice')) {
                $this->load->library('notice');
                if ($notice = $this->notice->getNotice()) {
                    $this->data['notice'] = $notice;
                }
            }

            $this->data['catalog'] = $this->catalog('article');

            $this->load->model('Seo_model', 'seo');
            $this->data['seo'] = $this->seo->get_caller('article', $id);

            $this->load->model('Article_model', 'article');
            $this->data['article'] = $this->article->get($id);
            $this->load->view('article/view',$this->data);
        }
    }

    /**
     * 添加文章;
     * @return  Output a view
     */
    public function add()
    {
        $this->load->model('Article_model', 'article');
        if ($this->article->validate()) {
            //数据
            $data = array(
                'title' => $this->input->post('title'),
                'catalog_id' => $this->input->post('catalog_id'),
                'image' => $this->resave('image'),
                'contents' => $this->input->post('contents'),
                'author' => $this->input->post('author'),
                'origin' => $this->input->post('origin'),
                'level' => $this->input->post('level'),
                'disabled' => $this->input->post('disabled'),
                'addtime' => time()
            );
            //执行
            if ($id = $this->article->insert($data)) {
                //添加SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->set('article', $id, array(
                    'title' => $data['title'],
                    'addtime' => $data['addtime']
                ));
                //通知
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '文章添加成功！',
                    'location' => '/article/seo/'.$id.'?notice=add'
                ));
            }
        } else {
            $this->data['catalog'] = $this->catalog('article');

            $this->load->view('article/add',$this->data);
        }
    }

    /**
     * 编辑文章;
     * @param   Integer
     * @return  Output a view
     */
    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Article_model', 'article');
            $article = $this->article->get($id);
            if($this->article->validate()){
                //数据
                $data = array(
                    'title' => $this->input->post('title'),
                    'catalog_id' => $this->input->post('catalog_id'),
                    'image' => $this->resave('image', $article->image),
                    'contents' => $this->input->post('contents'),
                    'author' => $this->input->post('author'),
                    'origin' => $this->input->post('origin'),
                    'level' => $this->input->post('level'),
                    'disabled' => $this->input->post('disabled'),
                );
                //更新
                if ($this->article->update($id, $data)) {
                    //通知
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '文章编辑成功！',
                        'location' => '/article/view/'.$id.'?notice=edit'
                    ));
                }
            } else {
                $this->data['article'] = $article;
                $this->data['catalog'] = $this->catalog('article');
                $this->load->view('article/edit', $this->data);
            }
        }
    }

    /**
     * 回调
     * @param   String
     * @param   Array
     * @return  Output a view
     */
    public function _callback($event, $params = array())
    {
        switch ($event) {
            case 'before_delete':
                //删除SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->delete_where(array(
                    'caller' => 'article', 
                    'caller_id' => $params['id']
                ));
                break;

            case 'before_batch_delete':
                //删除SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->set_where('caller', 'article');
                $this->seo->set_where('caller_id', $params['ids'], 'where_in');
                $this->seo->delete_result();
                break;

            default:
                # code...
                break;
        }
    }
}

/* End of file article.php */
/* Location: ./application/controllers/article.php */