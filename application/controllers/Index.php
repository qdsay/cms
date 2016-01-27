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
            'enabled' => 1
        ));

        $this->load->view('index',$this->data);
    }
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */