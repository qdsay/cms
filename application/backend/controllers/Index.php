<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends QD_Controller {

    public $backend = 'backend';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['dir'] = array(
            'application/backend/cache' => '缓存',
            'application/backend/logs' => '日志',
            'application/cache' => '缓存',
            'application/logs' => '日志',
            'uploads' => '文件'
        );
        $this->data['writeable'] = array(
            'application/backend/cache' => is_writable(APPPATH.'cache'),
            'application/backend/logs' => is_writable(APPPATH.'logs'),
            'application/cache' => is_writable($this->frontend().'cache'),
            'application/logs' => is_writable($this->frontend().'logs'),
            'uploads' => is_writable($this->uploads())
        );

        $this->data['scaffold'] = array(
            'application/backend/scaffold' => file_exists(APPPATH.'scaffold'),
            'application/backend/controller/Scaffold.php' => file_exists(APPPATH.'controllers/Scaffold.php'),
            'application/backend/models/Scaffold_model.php' => file_exists(APPPATH.'models/Scaffold_model.php'),
        );

        $this->load->view('index',$this->data);
    }

    public function frontend()
    {
        $frontend = '';
        $length = strlen(APPPATH);
        if ($pos = strrpos(APPPATH, $this->backend)) {
            $frontend = substr(APPPATH, 0, $pos);
        }
        return $frontend;
    }

    public function uploads()
    {
        $this->config->load('uploads');
        $upbase_path = $this->config->item('upbase_path');
        $upload_path = $this->config->item('upload_path');
        return realpath($upbase_path) .'/'. $upload_path;
    }
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */