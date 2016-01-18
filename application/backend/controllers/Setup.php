<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
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
        $this->load->model('Setup_model', 'setup');
        $this->setup->set_like('item', $this->input->get('item'));
        $this->data['list'] = $this->setup->list_result($cur_page, $this->per_page);
        $this->data['where'] = $this->setup->get_condition();
        $this->data['paging'] = $this->setup->paging('setup/pages');
        //加载模板
        $this->load->view('setup/list', $this->data);
    }

    /**
     * 查看系统;
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

            $this->load->model('Setup_model', 'setup');
            $this->data['setup'] = $this->setup->get($id);
            $this->load->view('setup/view',$this->data);
        }
    }

    /**
     * 添加系统;
     * @return  Output a view
     */
    public function add()
    {
        $this->load->model('Setup_model', 'setup');
        if ($this->setup->validate()) {
            $data = array(
                'item' => $this->input->post('item'),
                'alias' => $this->input->post('alias'),
                'content' => $this->input->post('content')
            );
            if ($id = $this->setup->insert($data)) {
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '系统添加成功！',
                    'location' => '/setup/view/'.$id.'?notice=add'
                ));
            }
        } else {
            $this->load->view('setup/add',$this->data);
        }
    }

    /**
     * 编辑系统;
     * @param   Integer
     * @return  Output a view
     */
    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Setup_model', 'setup');
            if($this->setup->validate()){
                $data = array(
                    'item' => $this->input->post('item'),
                    'alias' => $this->input->post('alias'),
                    'content' => $this->input->post('content')
                );

                if ($this->setup->update($id, $data)) {
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '系统编辑成功！',
                        'location' => '/setup/view/'.$id.'?notice=edit'
                    ));
                }
            } else {
                $this->data['setup'] = $this->setup->get($id);
                $this->load->view('setup/edit',$this->data);
            }
        }
    }
}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */