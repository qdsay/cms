<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appreciate extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
        $this->data['current'] = '欣赏';
        $this->data['items'] = array('edit' => '基本信息');
        $this->data['promote'] = array(1=>'推荐一',2=>'推荐二',3=>'推荐三',4=>'推荐四',5=>'推荐五',6=>'推荐六',7=>'推荐七',8=>'推荐八',9=>'推荐九');
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
        $this->load->model('Appreciate_model', 'appreciate');
        $this->appreciate->set_like('site', $this->input->get('site'));
        //分类查询
        $catalog = $this->catalog('appreciate');
        $catalog_id = $this->input->get('catalog_id');
        $ids = qd_catalog_ids($catalog, intval($catalog_id));
        if (count($ids) > 0) {
            $this->appreciate->set_where('catalog_id', $ids, 'where_in');
            $this->appreciate->set_condition('catalog_id', $catalog_id);
        } else {
            $this->appreciate->set_where('catalog_id', $catalog_id);
        }
        //排序
        $this->appreciate->set_order($this->input->get('order'), 'uptime-desc');
        $this->data['list'] = $this->appreciate->list_result($cur_page, $this->per_page);
        $this->data['where'] = $this->appreciate->get_condition();
        $this->data['paging'] = $this->appreciate->paging('appreciate/pages');
        //加载关联数据
        $this->data['catalog'] = $catalog;
        //加载模板
        $this->load->view('appreciate/list', $this->data);
    }

    /**
     * 查看欣赏;
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

            $this->load->model('Appreciate_model', 'appreciate');
            $this->data['catalog'] = $this->catalog('appreciate');

            $this->data['appreciate'] = $this->appreciate->get($id);
            $this->load->view('appreciate/view',$this->data);
        }
    }

    /**
     * 添加欣赏;
     * @return  Output a view
     */
    public function add($url_id = 0)
    {
        $this->load->model('Appreciate_model', 'appreciate');
        if ($this->appreciate->validate()) {
            //数据
            $data = array(
                'name' => $this->input->post('name'),
                'site' => $this->input->post('site'),
                'logo' => $this->resave('logo'),
                'ued' => $this->input->post('ued'),
                'url_id' => $this->input->post('url_id'),
                'catalog_id' => $this->input->post('catalog_id'),
                'promote' => $this->input->post('promote'),
                'enabled' => $this->input->post('enabled'),
                'addtime' => time()
            );
            //执行
            if ($id = $this->appreciate->insert($data)) {
                //通知
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '欣赏添加成功！',
                    'location' => '/appreciate/view/'.$id.'?notice=add'
                ));
            }
        } else {
            $this->data['url_id'] = 0;
            $this->data['site'] = '';
            if (is_numeric($url_id) && $url_id > 0) {
                $this->load->model('Url_model', 'url');
                $url = $this->url->get($url_id);
                $this->data['url_id'] = $url->id;
                $this->data['site'] = $url->url;
            }
            $this->data['catalog'] = $this->catalog('appreciate');
            $this->load->view('appreciate/add',$this->data);
        }
    }

    /**
     * 编辑欣赏;
     * @param   Integer
     * @return  Output a view
     */
    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Appreciate_model', 'appreciate');
            $appreciate = $this->appreciate->get($id);
            if($this->appreciate->validate()){
                //数据
                $data = array(
                    'name' => $this->input->post('name'),
                    'site' => $this->input->post('site'),
                    'logo' => $this->resave('logo', $appreciate->logo),
                    'ued' => $this->input->post('ued'),
                    'catalog_id' => $this->input->post('catalog_id'),
                    'promote' => $this->input->post('promote'),
                    'enabled' => $this->input->post('enabled'),
                    'url_id' => $this->input->post('url_id')
                );
                //更新
                if ($this->appreciate->update($id, $data)) {
                    //通知
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '欣赏编辑成功！',
                        'location' => '/appreciate/view/'.$id.'?notice=edit'
                    ));
                }
            } else {
                $this->data['appreciate'] = $appreciate;
                $this->data['catalog'] = $this->catalog('appreciate');
                $this->load->view('appreciate/edit', $this->data);
            }
        }
    }

    /**
     * 更新;
     * @param   Integer
     * @return  Output a view
     */
    public function set()
    {
        $this->load->model('Url_model', 'url');
        $this->load->model('Appreciate_model', 'appreciate');
        $list = $this->appreciate->get_all();
        foreach ($list as $key => $row) {
            if ($url = $this->url->get_where(array('url' => $row->site))) {
                $data = array(
                    'url_id' => $url->id,
                    'adapt' => $url->adapt
                );
                $this->appreciate->update($row->id, $data);
            }
        }
        $this->output->display('更新完毕', 'text');
    }
}

/* End of file appreciate.php */
/* Location: ./application/controllers/appreciate.php */