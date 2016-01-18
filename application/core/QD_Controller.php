<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QD_Controller extends CI_Controller {

    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('qd', 'url'));
        //全局配置
        $this->load->model('Setup_model', 'setup');
        $this->data['setup'] = $this->setup->get_all();
        //URL
        $this->data["url"] = '';
    }

    public function seo($type, $id = 0)
    {
        $seo = array();
        if ($id == 0) {
            $this->config->load('seo');
            $seo = $this->config->item($type, 'seo');
        } else {
            $this->load->model('Seo_model', 'seo');
            $seo = $this->seo->get($type, $id);
        }
        return $seo;
    }

    public function paging($url, $total, $per_page = 20)
    {
        $this->load->library('pagination');
        $config['base_url'] = $url;
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
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
    }
}

/* End of file qd.php */
/* Location: ./application/controllers/qd.php */