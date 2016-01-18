<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgets extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
        $this->data['current'] = '工具';
        $this->data['items'] = array('edit' => '基本信息');
        $this->data['catalog'] = array('yun'=>'云服务','api'=>'Api接口','html5'=>'H5制作','im'=>'IM通讯','comment'=>'留言评论','analysis'=>'统计分析','share'=>'关注分享','other'=>'其他');
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
        $this->load->model('Widgets_model', 'widgets');
        $this->widgets->set_like('name', $this->input->get('name'));
        $this->widgets->set_where('catalog', $this->input->get('catalog'));
        //排序
        $this->widgets->set_order($this->input->get('order'), 'uptime-desc');
        $this->data['list'] = $this->widgets->list_result($cur_page, $this->per_page);
        $this->data['where'] = $this->widgets->get_condition();
        $this->data['paging'] = $this->widgets->paging('widgets/pages');
        //加载模板
        $this->load->view('widgets/list', $this->data);
    }

    /**
     * 查看工具;
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

            $this->load->model('Widgets_model', 'widgets');
            $this->data['widgets'] = $this->widgets->get($id);
            $this->load->view('widgets/view',$this->data);
        }
    }

    /**
     * 添加工具;
     * @return  Output a view
     */
    public function add()
    {
        $this->load->model('Widgets_model', 'widgets');
        if ($this->widgets->validate()) {
            //数据
            $data = array(
                'name' => $this->input->post('name'),
                'site' => $this->input->post('site'),
                'image' => $this->resave('image'),
                'tags' => $this->input->post('tags'),
                'summary' => $this->input->post('summary'),
                'detail' => $this->input->post('detail'),
                'catalog' => $this->input->post('catalog'),
                'promote' => $this->input->post('promote'),
                'addtime' => time()
            );
            //执行
            if ($id = $this->widgets->insert($data)) {
                //通知
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '工具添加成功！',
                    'location' => '/widgets/view/'.$id.'?notice=add'
                ));
            }
        } else {
            $this->load->view('widgets/add',$this->data);
        }
    }

    /**
     * 编辑工具;
     * @param   Integer
     * @return  Output a view
     */
    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Widgets_model', 'widgets');
            $widgets = $this->widgets->get($id);
            if($this->widgets->validate()){
                //数据
                $data = array(
                    'name' => $this->input->post('name'),
                    'site' => $this->input->post('site'),
                    'image' => $this->resave('image', $widgets->image),
                    'tags' => $this->input->post('tags'),
                    'summary' => $this->input->post('summary'),
                    'detail' => $this->input->post('detail'),
                    'catalog' => $this->input->post('catalog'),
                    'promote' => $this->input->post('promote'),
                );
                //更新
                if ($this->widgets->update($id, $data)) {
                    //通知
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '工具编辑成功！',
                        'location' => '/widgets/view/'.$id.'?notice=edit'
                    ));
                }
            } else {
                $this->data['widgets'] = $widgets;
                $this->load->view('widgets/edit', $this->data);
            }
        }
    }
}

/* End of file widgets.php */
/* Location: ./application/controllers/widgets.php */