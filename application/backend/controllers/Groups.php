<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends QD_Controller {

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
        $this->load->model('Groups_model', 'groups');
        $this->groups->set_order($this->input->get('order'));
        $this->data['list'] = $this->groups->list_result($cur_page, $this->per_page);
        $this->data['paging'] = $this->groups->paging('groups/pages');
        //加载模板
        $this->load->view('groups/list',$this->data);
    }
    
    public function view($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Groups_model', 'groups');
            $this->config->load('allow');
            $this->data['allow'] = $this->config->item('allow');
            $groups = $this->groups->get($id);
            $groups->auth = unserialize($groups->auth);
            $this->data['groups'] = $groups;

            if ($this->input->get('notice')) {
                $this->load->library('notice');
                $this->data['notice'] = $this->notice->getNotice();
            }
            $this->load->view('groups/view',$this->data);
        }
    }

    public function add()
    {
        $this->load->model('Groups_model', 'groups');
        if ($this->groups->validate()) {
            $auth = array();
            $controler = $this->input->post('controler');
            if ($controler) {
                foreach($controler as $c){
                    $methods = array();
                    $ctrl = $this->input->post($c);
                    foreach ($ctrl as $m) {
                        $methods[] = $m;
                    }
                    $auth[$c] = $methods;
                }
            }
            $data = array(
                'name' => $this->input->post('name'),
                'auth' => serialize($auth),
                'enabled' => $this->input->post('enabled')
            );
            if ($id = $this->groups->insert($data)) {
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '用户组添加成功！',
                    'location' => '/groups/view/'.$id.'?notice=add'
                ));
            }
        }
        $this->config->load('allow');
        $this->data['allow'] = $this->config->item('allow');
        $this->load->view('groups/add',$this->data);
    }

    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Groups_model', 'groups');
            if($this->groups->validate()){
                $auth = array();
                $controler = $this->input->post('controler');
                if ($controler) {
                    foreach($controler as $c){
                        $methods = array();
                        $ctrl = $this->input->post($c);
                        foreach ($ctrl as $m) {
                            $methods[] = $m;
                        }
                        $auth[$c] = $methods;
                    }
                }
                $enabled = $this->input->post('enabled');
                if ($enabled == 0) {
                    $this->load->model('Admin_model', 'admin');
                    $this->admin->enabled(
                        array('groups_id' => $id, 'enabled' => 1),
                        array('enabled' => 0)
                    );
                }
                $data = array(
                    'name' => $this->input->post('name'),
                    'auth' => serialize($auth),
                    'enabled' => $enabled
                );
                if ($this->groups->update($id, $data)) {
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '用户组编辑成功！',
                        'location' => '/groups/view/'.$id.'?notice=edit'
                    ));
                }
            }
            $this->config->load('allow');
            $this->data['allow'] = $this->config->item('allow');
            $groups = $this->groups->get($id);
            $groups->auth = unserialize($groups->auth);
            $this->data['groups'] = $groups;
            $this->load->view('groups/edit',$this->data);
        }
    }
}

/* End of file groups.php */
/* Location: ./application/controllers/groups.php */