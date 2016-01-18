<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends QD_Controller {

    public $per_page = 20;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pages();
    }

    public function pages($cur_page = 0)
    {
        //获取结果集
        $this->load->model('Admin_model', 'admin');
        $this->admin->set_where('username', $this->input->get('username'));
        $this->admin->set_where('groups_id', $this->input->get('groups'));
        $this->admin->set_order($this->input->get('order'));
        $this->data['list'] = $this->admin->list_result($cur_page, $this->per_page);
        $this->data['where'] = $this->admin->get_condition();
        $this->data['paging'] = $this->admin->paging('admin/pages');
        //加载关联数据
        $this->load->model('Groups_model', 'groups');
        $this->data['groups'] = $this->groups->get_option();
        //加载模板
        $this->load->view('admin/list',$this->data);
    }
    
    public function view($id)
    {
        $this->load->model('Admin_model', 'admin');
        $this->load->model('Groups_model', 'groups');
        $this->data['groups'] = $this->groups->get_option();
        $this->data['admin'] = $this->admin->get($id);

        if ($this->input->get('notice')) {
            $this->load->library('notice');
            $this->data['notice'] = $this->notice->getNotice();
        }
        $this->load->view('admin/view',$this->data);
    }

    public function add()
    {
        $this->load->model('Admin_model', 'admin');
        if ($this->admin->validate()) {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password')),
                'groups_id' => $this->input->post('groups'),
                'disabled' => $this->input->post('disabled'),
                'addtime' => time()
            );
            if ($id = $this->admin->insert($data)) {
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '用户添加成功！',
                    'location' => '/admin/view/'.$id.'?notice=add'
                ));
            }
        }
        $this->load->model('Groups_model', 'groups');
        $this->data['groups'] = $this->groups->get_option();
        $this->load->view('admin/add',$this->data);
    }

    public function edit($id)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Admin_model', 'admin');
            if($this->admin->validate()){
                $data = array(
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'groups_id' => $this->input->post('groups'),
                    'disabled' => $this->input->post('disabled')
                );
                if ($this->admin->update($id, $data)) {
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '用户编辑成功！',
                        'location' => '/admin/view/'.$id.'?notice=edit'
                    ));
                }
            }
            $this->data['admin'] = $this->admin->get($id);
            $this->load->model('Groups_model', 'groups');
            $this->data['groups'] = $this->groups->get_option();
            $this->load->view('admin/edit',$this->data);
        }
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */