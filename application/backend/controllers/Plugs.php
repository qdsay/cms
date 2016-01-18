<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugs extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
        $this->data['current'] = '插件';
        $this->data['items'] = array('edit' => '基本信息');
        $this->data['catalog'] = array('js'=>'JS库','css'=>'CSS框架','tools'=>'站长工具');
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
        $this->load->model('Plugs_model', 'plugs');
        $this->plugs->set_like('name', $this->input->get('name'));
        $this->plugs->set_where('catalog', $this->input->get('catalog'));
        //排序
        $this->plugs->set_order($this->input->get('order'), 'uptime-desc');
        $this->data['list'] = $this->plugs->list_result($cur_page, $this->per_page);
        $this->data['where'] = $this->plugs->get_condition();
        $this->data['paging'] = $this->plugs->paging('plugs/pages');
        //加载模板
        $this->load->view('plugs/list', $this->data);
    }

    /**
     * 查看插件;
     * @param   Integer
     * @return  Output a view
     */
    public function view($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            if ($this->input->get('notice')) {
                $this->load->library('notice');
                if ($notice = $this->notice->getNotice()) {
                    $this->data['notice'] = $notice;
                }
            }

            $this->load->model('Plugs_model', 'plugs');
            $this->data['plugs'] = $this->plugs->get($id);
            $this->load->view('plugs/view',$this->data);
        }
    }

    /**
     * 添加插件;
     * @return  Output a view
     */
    public function add()
    {
        $this->load->model('Plugs_model', 'plugs');
        if ($this->plugs->validate()) {
            //数据
            $data = array(
                'name' => $this->input->post('name'),
                'keywords' => $this->input->post('keywords'),
                'description' => $this->input->post('description'),
                'contents' => $this->input->post('contents'),
                'homepage' => $this->input->post('homepage'),
                'repositories' => $this->input->post('repositories'),
                'cdn' => $this->input->post('cdn'),
                'catalog' => $this->input->post('catalog'),
                'adapt' => $this->input->post('adapt'),
                'addtime' => time()
            );
            //执行
            if ($id = $this->plugs->insert($data)) {
                //通知
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '插件添加成功！',
                    'location' => '/plugs/view/'.$id.'?notice=add'
                ));
            }
        } else {
            $this->load->view('plugs/add',$this->data);
        }
    }

    /**
     * 编辑插件;
     * @param   Integer
     * @return  Output a view
     */
    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Plugs_model', 'plugs');
            if($this->plugs->validate()){
                //数据
                $data = array(
                    'name' => $this->input->post('name'),
                    'keywords' => $this->input->post('keywords'),
                    'description' => $this->input->post('description'),
                    'contents' => $this->input->post('contents'),
                    'homepage' => $this->input->post('homepage'),
                    'repositories' => $this->input->post('repositories'),
                    'cdn' => $this->input->post('cdn'),
                    'catalog' => $this->input->post('catalog'),
                    'adapt' => $this->input->post('adapt'),
                );
                //更新
                if ($this->plugs->update($id, $data)) {
                    //通知
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '插件编辑成功！',
                        'location' => '/plugs/view/'.$id.'?notice=edit'
                    ));
                }
            } else {
                $this->data['plugs'] = $this->plugs->get($id);
                $this->load->view('plugs/edit', $this->data);
            }
        }
    }

    public function getjson($catalog = 'js')
    {
        $json = array();
        $this->load->model('Plugs_model', 'plugs');
        $plugs = $this->plugs->get_all(array('catalog' => $catalog));
        foreach ($plugs as $key => $row) {
            $json[] = $row->name;
        }
        $this->output->display($json);
    }

    public function overshot()
    {
        $url = 'http://cdn.code.baidu.com/libs.js';
        $content = file_get_contents($url);
        $content = substr($content, 11);
        if ($json = json_decode($content)) {
            $this->load->model('Plugs_model', 'plugs');
            $message = "";
            foreach ($json as $item) {
                if ($match = $this->matchName($item->filename)) {
                    $repositories = "";
                    if (property_exists($item, 'repositories') && ! empty($item->repositories)) {
                        $repositories = is_array($item->repositories) ? $item->repositories[0]->url : $item->repositories->url;
                    }
                    $cnd = 'http://apps.bdimg.com/libs/'.$item->name.'/'.$item->version.'/'.$item->filename;
                    $data = array(
                        'keywords' => property_exists($item, 'keywords') ? implode(",", $item->keywords) : "",
                        'description' => property_exists($item, 'description') ? $item->description : "",
                        'contents' => property_exists($item, 'description') ? $item->description : "",
                        'homepage' => property_exists($item, 'homepage') ? $item->homepage : "",
                        'repositories' => $repositories,
                        'cdn' => $cnd
                    );
                    if ($row = $this->plugs->get_where(array('name' => $match[1], 'catalog' => $match[2]))) {
                        $this->plugs->update($row->id, $data);
                    } else {
                        $data['name'] = $match[1];
                        $data['catalog'] = $match[2];
                        $data['addtime'] = time();
                        $this->plugs->insert($data);
                    }
                    $message += $match[2] .':'. $match[1] . '<br />';
                }
            }
            show_error('<a href="http://cdn.code.baidu.com/libs.js" target="_blank">百度CDN公共库</a> 解析成功！', 200, '解析成功：');
        } else {
            show_error('<a href="http://cdn.code.baidu.com/libs.js" target="_blank">百度CDN公共库</a> 解析出错！', 200, '解析出错：');
        }
    }

    public function matchName($filename)
    {
        $filename = preg_replace(array("/[\.-]min/i", "/[\.-]\d+/i"), "", $filename);
        preg_match('/([\w\.-]+)\.(css|js)/i', $filename, $match);
        if (! empty($match)) {
            return $match;
        }
        return false;
    }
}

/* End of file plugs.php */
/* Location: ./application/controllers/plugs.php */