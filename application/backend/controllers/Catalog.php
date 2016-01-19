<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends QD_Controller {

    function __construct()
    {
        parent::__construct();
        $this->data['type'] = array('article' => '站点分类');
    }

    /**
     * 首页
     * @return  Output view
     */
    public function index()
    {
        $this->pages();
    }

    /**
     * 列表页
     * @param   Integer
     * @return  Output view
     */
    public function pages($type = '')
    {
        $type = empty($type) ? key($this->data['type']) : $type;
        $this->data['where'] = empty($type) ? array() : array('type' => $type);

        $this->load->model('Catalog_model', 'catalog');
        $list = $this->catalog->get_catalog($type);

        $catalog = array();
        foreach ($list as $a) { //第一级
            if ($a['grade'] == 0) {
                $catalog[$a['id']] = $a;
                foreach ($list as $b) { //第二级
                    if ($b['father_id'] == $a['id'] && $b['grade'] == 1) {
                        $catalog[$b['id']] = $b;
                        foreach ($list as $c) { //第三级
                            if ($c['father_id'] == $b['id'] && $c['grade'] == 2) {
                                $catalog[$c['id']] = $c;
                            }
                        }
                    }
                }
            }
        }

        $this->data['list'] = $catalog;
        $this->load->view('catalog/list',$this->data);
    }

    /**
     * 保存分类
     * @param   String
     * @return  Output view
     */
    public function save($type = '')
    {
        if (isset($this->data['type'][$type])) {
            $fid = $this->input->post('fid');
            $sort = $this->input->post('sort');
            $grade = $this->input->post('grade');
            $name = $this->input->post('name');

            $insert = array();
            $this->load->model('Catalog_model', 'catalog');
            foreach ($sort as $key => $value) {
                if (isset($fid[$key]) && isset($grade[$key]) && isset($name[$key])) {
                    $insert[] = array(
                        'sort' => $value,
                        'father_id' => $fid[$key],
                        'grade' => $grade[$key],
                        'name' => $name[$key],
                        'type' => $type
                    );
                } else {
                    $this->catalog->update_where(array(
                        'id' => $key,
                        'type' => $type
                    ), array('sort' => $value));
                }
            }
            if (! empty($insert)) {
                $this->catalog->insert_batch($insert);
            }
            $this->load->library('notice');
            $this->notice->succeed(array(
                'title' => '分类目录编辑成功！',
                'location' => '/catalog/pages/'.$type
            ));
        }
    }

    /**
     * 查看分类
     * @param   String
     * @param   Integer
     * @return  Output view
     */
    public function view($type, $id)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Catalog_model', 'catalog');
            $this->data['catalog'] = $this->catalog->get($id);

            if ($this->input->get('notice')) {
                $this->load->library('notice');
                if ($notice = $this->notice->getNotice()) {
                    $this->data['notice'] = $notice;
                }
            }
            $this->data['current'] = $type;
            $this->load->model('Seo_model', 'seo');
            $this->data['seo'] = $this->seo->get_caller('catalog', $id);

            $this->load->view('catalog/view',$this->data);
        }
    }

    /**
     * 编辑分类
     * @param   String
     * @param   Integer
     * @return  Output view
     */
    public function edit($type, $id)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Catalog_model', 'catalog');
            $catalog = $this->catalog->get($id);
            if($this->catalog->validate()){
                $data = array(
                    'name' => $this->input->post('name'),
                    'aliases' => $this->input->post('aliases'),
                    'enabled' => $this->input->post('enabled'),
                );

                if ($this->catalog->update_where(array('id' => $id, 'type' => $type), $data)) {
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '分类目录编辑成功！',
                        'location' => '/catalog/view/'.$type.'/'.$id.'?notice=edit'
                    ));
                }
            }
            $this->data['current'] = $type;
            $this->data['catalog'] = $catalog;
            $this->load->view('catalog/edit',$this->data);
        }
    }

    /**
     * SEO设置
     * @param   String
     * @param   Integer
     * @return  Output view
     */
    public function seo($type, $id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Seo_model', 'seo');
            if($this->seo->validate()){
                $data = array(
                    'title' => $this->input->post('title'),
                    'keywords' => $this->input->post('keywords'),
                    'description' => $this->input->post('description'),
                    'addtime' => time()
                );
                if ($this->seo->set('catalog', $id, $data)) {
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => 'SEO设置成功！',
                        'location' => '/catalog/view/'.$type.'/'.$id.'?notice=edit'
                    ));
                }
            }
            $this->data['current'] = $type;
            $this->load->model('Catalog_model', 'catalog');
            $this->data['catalog'] = $this->catalog->get($id);
            $this->data['seo'] = $this->seo->get_caller('catalog', $id);
            $this->load->view('catalog/seo',$this->data);
        }
    }

    /**
     * 删除分类
     * @param   String
     * @return  Output a json string
     */
    public function del($type = '')
    {
        $ret['status'] = 'fail';
        $id = $this->input->post('id');
        if ($this->input->is_ajax_request() && is_numeric($id) && $id > 0) {
            $this->load->model('Catalog_model', 'catalog');
            if ($this->catalog->count_where(array('father_id' => $id))) {
                $ret['error'] = '删除失败, 移除子类后再试试。';
                $this->output->display($ret);
            }
            $this->load->model(ucfirst($type).'_model', $type);
            if ($this->$type->count_where(array('catalog_id' => $id))) {
                $ret['error'] = '删除失败, 分类不为空。';
                $this->output->display($ret);
            }
            if ($this->catalog->delete($id)) {
                $ret['status'] = 'success';
                $this->output->display($ret);
            }
        }
    }
}

/* End of file catalog.php */
/* Location: ./application/controllers/catalog.php */