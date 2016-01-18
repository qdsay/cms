<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends QD_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['curnav'] = 'index';
    }

    public function index()
    {
        //分类
        $this->load->model('Catalog_model', 'catalog');
        $this->data['catalog'] = $this->catalog->get_option(array(
            'type' => 'appreciate',
            'disabled' => 1
        ));
        //欣赏
        $this->load->model('Appreciate_model', 'appreciate');
        $this->data['appreciate'] = $this->appreciate->get_list_where(array(), 0, 79, 'promote desc, id desc');
        //$this->load->model('Url_model', 'url');
        //$this->data["recently"] = $this->url->get_list_where(array('favicon !=' => ''), 0, 50, 'id desc');
        $this->load->view('index',$this->data);
    }
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */