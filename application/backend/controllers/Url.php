<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Url extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
        $this->data['current'] = '网址';
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
        $this->load->model('Url_model', 'url');
        $this->url->set_like('url', $this->input->get('url'));
        //排序
        $this->url->set_order($this->input->get('order'), 'uptime-desc');
        $this->data['list'] = $this->url->list_result($cur_page, $this->per_page);
        $this->data['where'] = $this->url->get_condition();
        $this->data['paging'] = $this->url->paging('url/pages');
        //加载模板
        $this->load->view('url/list', $this->data);
    }

    /**
     * 查看网址;
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

            $this->load->model('Url_model', 'url');
            $this->data['url'] = $this->url->get($id);
            $this->load->view('url/view',$this->data);
        }
    }

    /**
     * 添加网址;
     * @return  Output a view
     */
    public function add()
    {
        $this->load->model('Url_model', 'url');
        if ($this->url->validate()) {
            //数据
            $data = array(
                'url' => $this->input->post('url'),
                'favicon' => $this->input->post('favicon'),
                'title' => $this->input->post('title'),
                'keywords' => $this->input->post('keywords'),
                'description' => $this->input->post('description'),
                'promote' => $this->input->post('promote'),
                'adapt' => $this->input->post('adapt'),
                'addtime' => time()
            );
            //执行
            if ($id = $this->url->insert($data)) {
                //通知
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '网址添加成功！',
                    'location' => '/url/view/'.$id.'?notice=add'
                ));
            }
        } else {
            $this->load->view('url/add',$this->data);
        }
    }

    /**
     * 编辑网址;
     * @param   Integer
     * @return  Output a view
     */
    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Url_model', 'url');
            if($this->url->validate()){
                //数据
                $data = array(
                    'url' => $this->input->post('url'),
                    'favicon' => $this->input->post('favicon'),
                    'title' => $this->input->post('title'),
                    'keywords' => $this->input->post('keywords'),
                    'description' => $this->input->post('description'),
                    'promote' => $this->input->post('promote'),
                    'adapt' => $this->input->post('adapt'),
                );
                //更新
                if ($this->url->update($id, $data)) {
                    //通知
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '网址编辑成功！',
                        'location' => '/url/view/'.$id.'?notice=edit'
                    ));
                }
            } else {
                $this->data['url'] = $this->url->get($id);
                $this->load->view('url/edit', $this->data);
            }
        }
    }
}

/* End of file url.php */
/* Location: ./application/controllers/url.php */