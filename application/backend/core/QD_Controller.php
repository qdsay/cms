<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QD_Controller extends CI_Controller {

    public $data = array(
        'enabled' => array('禁用', '启用')
    );

    public $ctrl = '';
    public $func = '';

    protected $user = array();
    protected $auth = array();
    protected $allow = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('qd', 'url'));
        $this->ctrl = $this->router->fetch_class();
        $this->func = $this->router->fetch_method();
        if ($this->checkLogin()) {
            $this->initAuth();
            $this->checkAuth();
            $this->loadMenu();
        }
    }

    /**
     * 检查是否登录
     */
    protected function checkLogin() {
        $this->load->library('session');
        if ($this->user = $this->session->userdata('user')) {
            $this->data['user'] = $this->user;
            return true;
        } else {
            redirect('/login', 'location');
        }
    }

    /**
     * 初始化权限系统
     */
    protected function initAuth()
    {
        $this->config->load('allow');
        $this->allow = $this->config->item('allow');
        foreach ($this->allow as $key => $value) {
            $allow[$key] = $value['auth'];
        }
        if ($this->user['username'] != 'admin') {
            $this->load->model('Groups_model', 'groups');
            $groups = $this->groups->get($this->user['groups']);
            $auth = unserialize($groups->auth);
            foreach ($allow as $ctrl => $value) {
                if (array_key_exists($ctrl, $auth)) {
                    foreach ($value as $func => $value) {
                        if (! in_array($func, $auth[$ctrl])) {
                            unset($allow[$ctrl][$func]);
                        }
                    }
                } else {
                    unset($allow[$ctrl]);
                }
            }
        }
        $this->data['auth'] = $this->auth = $allow;
    }

    /**
     * 检查权限
     */
    protected function checkAuth()
    {
        if ($this->ctrl == 'index') {
            return true;
        } elseif (isset($this->auth[$this->ctrl])) {
            if ($this->user['username'] == 'admin') {
                foreach ($this->auth[$this->ctrl] as $auth) {
                    if (in_array($this->func, $auth)) {
                        return true;
                    }
                }
            } else {
                foreach ($this->auth[$this->ctrl] as $key => $auth) {
                    if (in_array($this->func, $this->allow[$this->ctrl]['auth'][$key])) {
                        return true;
                    }
                }
            }
        } else {
            $this->sendNotice(array(
                'title' => '您没有权限操作此栏目！',
                'message' => '请与管理员联系获取此权限'
            ), 'warning');
        }
    }

    /**
     * 加载菜单
     */
    public function loadMenu($curmenu = '') {
        $curmenu = empty($curmenu) ? $this->ctrl : $curmenu;
        $this->config->load('navigation');
        $this->data['curmenu'] = $curmenu;
        $this->data['navbar'] = $navigation = $this->config->item('navigation');
        foreach ($navigation as $key => $nav) {
            if (array_key_exists($curmenu, $nav['menu'])) {
                $this->data['curnav'] = $key;
                $this->data['nav'] = array(
                    'title' => $navigation[$key]['title'],
                    'menu' => $navigation[$key]['menu'],
                );
                break;
            }
        }
    }

    /**
     * 分类目录
     * @param   String
     * @return  Array
     */
    public function catalog($type)
    {
        $this->load->model('Catalog_model', 'catalog');
        return $this->catalog->get_catalog($type);
    }

    /**
     * SEO设置
     * @param   Integer
     * @return  Output a view
     */
    public function seo($caller_id, $caller = '')
    {
        if (is_numeric($caller_id) && $caller_id > 0) {
            if (empty($caller)) {
                $caller = $this->ctrl;
            }
            $this->load->model('Seo_model', 'seo');
            if($this->seo->validate()){
                $data = array(
                    'title' => $this->input->post('title'),
                    'keywords' => $this->input->post('keywords'),
                    'description' => $this->input->post('description')
                );
                if ($this->seo->set($caller, $caller_id, $data)) {
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => 'SEO设置成功！',
                        'location' => '/'.$caller.'/view/'.$caller_id.'?notice=edit'
                    ));
                }
            } else {
                $this->data['caller'] = $caller;
                $this->data['caller_id'] = $caller_id;
                $this->data['seo'] = $this->seo->get_caller($caller, $caller_id);
                $this->load->view('seo',$this->data);
            }
        }
    }

    /**
     * 处理图集
     * @param   String
     * @param   Integer
     * @return  Array
     */
    public function gallery($caller_id, $field = '')
    {
        $caller = $this->ctrl;
        $update = $insert = $delete = array();
        //初始化存储
        $this->load->library('storage');
        $this->storage->initialize($caller, $field); //初始化
        //获取图集
        $this->load->model('Gallery_model', 'gallery');
        $gallery = $this->gallery->get_all(array(
            'caller' => $caller,
            'caller_id' => $caller_id
        ), 'serial asc');
        //递交
        if ($images = $this->input->post('images')) {
            //处理删除
            if ($ids = $this->input->post('ids')) {
                //删除图片
                foreach ($gallery as $key => $row) {
                    $resize = ($row->serial == 0) ? TRUE : FALSE;
                    if (! in_array($row->id, $ids)) {
                        $this->storage->remove($row->image, $resize);
                        $delete[] = $row->id;
                    }
                }
                //删除缩略图
                if ($gallery[0]->image != $images[0]) {
                    $this->storage->remove_resize($gallery[0]->image);
                }
                //删除数据
                if (! empty($delete)) {
                    $this->gallery->delete_where_in('id', $delete);
                }
            }
            //预定义
            $info = $this->input->post('info');
            //插入/更新
            foreach ($images as $serial => $source) {
                $resize = ($serial == 0) ? TRUE : FALSE;
                if (isset($ids[$serial])) { //更新
                    if ($resize) {
                        $this->storage->resize($source);
                    }
                    $update[$serial] = array(
                        'id' => $ids[$serial],
                        'info' => $info[$serial],
                        'serial' => $serial
                    );
                } else { //添加
                    $images[$serial] = $this->storage->resave($source, $resize);
                    $insert[$serial] = array(
                        'caller' => $caller,
                        'caller_id' => $caller_id,
                        'image' => $images[$serial],
                        'info' => $info[$serial],
                        'serial' => $serial
                    );
                }
            }
            if (! empty($update)) {
                $this->gallery->update_batch($update, 'id');
            }
            if (! empty($insert)) {
                $this->gallery->insert_batch($insert);
            }
            $this->load->model($caller.'_model', 'model');
            $this->model->update($caller_id, array($field => $images[0]));
            redirect($caller.'/gallery/'.$caller_id);
        }
        $this->data['gallery'] = $gallery;
    }

    /**
     * 上传
     * @param   String
     * @return  Output a json string
     */
    public function upload($field = '')
    {
        $ret['status'] = 'fail';
        $this->config->load('uploads');
        $upbase_path = $this->config->item('upbase_path');
        $upload_path = $this->config->item('upload_path');

        $configs = $this->config->item($field, $this->ctrl);
        $configs = $configs['upload_config'];

        $configs['upload_path'] = $upload_path = $upload_path .'temp/';
        $configs['upload_path'] = realpath($upbase_path) .'/'. $upload_path;
        if (!is_dir($configs['upload_path'])) {
            if (!mkdir($configs['upload_path'], 0755, true)) {
                $ret['error'] = '文件操作失败,请联系管理员检查目录权限。';
                $this->output->display($ret);
            }
        }

        $this->load->library('upload', $configs);
        if ($this->upload->do_upload('upload_'. $field)) {
            $ret['status'] = 'success';
            $data = $this->upload->data();
            $ret['filename'] = $upload_path . $data['file_name'];
            $ret['origname'] = str_replace($data['file_ext'], '', $data['orig_name']);
            if ($ret['is_image'] = $data['is_image']) {
                $ret['image_width']  = $data['image_width'];
                $ret['image_height'] = $data['image_height'];
            }
        } else {
            $ret['error'] = strip_tags($this->upload->display_errors());
        }
        $this->output->display($ret);
    }

    /**
     * 保存图片
     * @param   String
     * @param   Array
     * @param   String
     * @return  String
     */
    public function resave($field, $target = '')
    {
        $source = $this->input->post($field);
        if (! empty($source) && $source != $target) { //空返回
            $this->load->library('storage');
            $this->storage->initialize($this->ctrl, $field); //初始化
            $this->storage->remove($target); //删除原始文件
            $target = $this->storage->resave($source); //文件另存为
        } elseif (empty($source) && ! empty($target)) {
            $this->load->library('storage');
            $this->storage->initialize($this->ctrl, $field); //初始化
            $this->storage->remove($target); //删除原始文件
            $target = '';
        }
        return $target;
    }

    /**
     * 删除文件
     * @param   String
     * @return  Output a json string
     */
    public function remove($filename = '')
    {
        $ret['status'] = 'fail';
        if ($filename = $this->input->get('filename')) {
            $this->config->load('uploads');
            $filename = realpath($this->config->item('upbase_path')) . $filename;
            if (! file_exists($filename)) {
                $ret['error'] = '删除失败，找不到文件。';
            } elseif (! unlink($filename)) {
                $ret['error'] = '删除失败，无操作权限。';   
            } else {
                $ret['status'] = 'success';
            }
        } else {
            $ret['error'] = '未指定删除文件。';
        }
        $this->output->display($ret);
    }

    /**
     * 禁用
     * @param   Integer
     * @param   String
     * @return  Output a json string
     */
    public function enabled($id = 0, $ctrl = '')
    {
        $result = 'error';
        if ($this->input->is_ajax_request() && is_numeric($id) && $id > 0) {
            $enabled = $this->input->get('enabled');
            $this->load->model($this->ctrl.'_model', 'model');
            if($this->model->update($id, array('enabled' => $enabled))) {
                $result = 'success';
            }
        }
        $this->output->display($result, 'text');
    }

    /**
     * 禁用
     * @param   Integer
     * @param   String
     * @return  Output a json string
     */
    public function open($id = 0, $ctrl = '')
    {
        $result = 'error';
        if ($this->input->is_ajax_request() && is_numeric($id) && $id > 0) {
            $field = $this->input->get('field');
            $open = $this->input->get('open');
            $this->load->model($this->ctrl.'_model', 'model');
            if($this->model->update($id, array($field => $open))) {
                $result = 'success';
            }
        }
        $this->output->display($result, 'text');
    }

    /**
     * 删除
     * @param   Integer
     * @return  Output a json string
     */
    public function del($id = 0)
    {
        $result = 'error';
        if ($this->input->is_ajax_request() && is_numeric($id) && $id > 0) {
            if ($this->_callback('before_delete', array('id' => $id))) {
                $this->load->model($this->ctrl.'_model', 'model');
                if($this->model->delete($id)) {
                    $result = 'success';
                }
            }
        }
        $this->output->display($result, 'text');
    }

    /**
     * 删除选中
     * @return  Output a json string
     */
    public function batchdel()
    {
        $result = 'error';
        if ($this->input->is_ajax_request() && $ids = $this->input->post($this->ctrl)) {
            if ($this->_callback('before_batch_delete', array('ids' => $ids))) {
                $this->load->model($this->ctrl.'_model', 'model');
                if($this->model->delete_where_in('id', $ids)) {
                    $result = 'success';
                }
            }
        }
        $this->output->display($result, 'text');
    }

    /**
     * 回调
     * @param   Array
     * @param   String
     * @return  Output a view
     */
    public function _callback($event, $params = array())
    {
        //Implemented in subclasses
        return true;
    }

    /**
     * 通知
     * @param   Array
     * @param   String
     * @return  Output a view
     */
    public function sendNotice($notice, $result = '')
    {
        $this->load->library('notice');
        $data = $this->notice->send($notice, $result);

        $this->config->load('allow');
        $allow = $this->config->item('allow');
        $data['location'] = $allow[$this->ctrl]['title'];

        $this->load->library('parser');
        $html = $this->parser->parse('notice', $data);
        $this->output->display($html, 'html');
    }
}

/* End of file QD_Controller.php */
/* Location: ./application/controllers/QD_Controller.php */