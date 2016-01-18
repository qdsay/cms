<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 分类目录
     * @param   String
     * @return  String || Json Array
     */
    public function imageUp()
    {
        $config = array(
            'savePath'   => '../uploads/editor/' ,                                  //存储文件夹
            'maxSize'    => 2048 ,                                                  //允许的文件最大尺寸，单位KB
            'allowFiles' => array( '.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp' )    //允许的文件格式
        );
        $this->load->library('uploader', $config);
        $this->uploader->upload('upfile');
        $info = $this->uploader->getFileInfo();
        $info['url'] = str_replace($config['savePath'], '/', $info['url']);

        /**
         * 返回数据
         */
        $callback = $this->input->get('callback');
        if($callback) {
            $this->output->display('<script>'.$callback.'('.json_encode($info).')</script>', 'html');
        } else {
            $this->output->display(json_encode($info), 'html');
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */