<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assist extends QD_Controller {

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
        $this->load->model('Assist_model', 'assist');
        $this->assist->set_like('title', $this->input->get('title'));
        $this->assist->set_like('aliases', $this->input->get('aliases'));
        //排序
        $this->assist->set_order($this->input->get('order'), 'uptime-desc');
        $this->data['list'] = $this->assist->list_result($cur_page, $this->per_page);
        $this->data['where'] = $this->assist->get_condition();
        $this->data['paging'] = $this->assist->paging('assist/pages');
        //加载模板
        $this->load->view('assist/list', $this->data);
    }

    /**
     * 查看页面;
     * @param   Integer
     * @return  Output a view
     */
    public function view($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Assist_model', 'assist');
            $this->data['assist'] = $this->assist->get($id);
            $this->load->model('Seo_model', 'seo');
            $this->data['seo'] = $this->seo->get('assist', $id);

            $this->load->view('assist/view',$this->data);
        }
    }
}

/* End of file assist.php */
/* Location: ./application/controllers/assist.php */