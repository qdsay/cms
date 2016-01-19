<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assist extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
        $this->data['current'] = '页面';
        $this->data['items'] = array('edit' => '基本信息', 'seo' => 'SEO设置');
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
            if ($this->input->get('notice')) {
                $this->load->library('notice');
                if ($notice = $this->notice->getNotice()) {
                    $this->data['notice'] = $notice;
                }
            }

            $this->load->model('Assist_model', 'assist');

            $this->load->model('Seo_model', 'seo');
            $this->data['seo'] = $this->seo->get_caller('assist', $id);

            $this->data['assist'] = $this->assist->get($id);
            $this->load->view('assist/view',$this->data);
        }
    }

    /**
     * 添加页面;
     * @return  Output a view
     */
    public function add()
    {
        $this->load->model('Assist_model', 'assist');
        if ($this->assist->validate()) {
            //数据
            $data = array(
                'title' => $this->input->post('title'),
                'aliases' => $this->input->post('aliases'),
                'contents' => $this->input->post('contents'),
                'enabled' => $this->input->post('enabled'),
                'addtime' => time()
            );
            //执行
            if ($id = $this->assist->insert($data)) {
                //添加SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->set('assist', $id, array(
                    'title' => $data['title'],
                    'addtime' => $data['addtime']
                ));
                //通知
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '页面添加成功！',
                    'location' => '/assist/seo/'.$id.'?notice=add'
                ));
            }
        } else {
            $this->load->view('assist/add',$this->data);
        }
    }

    /**
     * 编辑页面;
     * @param   Integer
     * @return  Output a view
     */
    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('Assist_model', 'assist');
            if($this->assist->validate()){
                //数据
                $data = array(
                    'title' => $this->input->post('title'),
                    'aliases' => $this->input->post('aliases'),
                    'contents' => $this->input->post('contents'),
                    'enabled' => $this->input->post('enabled'),
                );
                //更新
                if ($this->assist->update($id, $data)) {
                    //通知
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '页面编辑成功！',
                        'location' => '/assist/view/'.$id.'?notice=edit'
                    ));
                }
            } else {
                $this->data['assist'] = $this->assist->get($id);
                $this->load->view('assist/edit', $this->data);
            }
        }
    }

    /**
     * 回调
     * @param   String
     * @param   Array
     * @return  Output a view
     */
    public function _callback($event, $params = array())
    {
        switch ($event) {
            case 'before_delete':
                //删除SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->delete_where(array(
                    'caller' => 'assist', 
                    'caller_id' => $params['id']
                ));
                break;

            case 'before_batch_delete':
                //删除SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->set_where('caller', 'assist');
                $this->seo->set_where('caller_id', $params['ids'], 'where_in');
                $this->seo->delete_result();
                break;

            default:
                # code...
                break;
        }
    }
}

/* End of file assist.php */
/* Location: ./application/controllers/assist.php */