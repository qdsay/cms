<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scaffold extends CI_Controller {

    protected $site = '勤道软件';
    protected $backend = 'backend';

    protected $tplpath = '';
    protected $curpath = '';

    protected $key = array('&times;','&radic;');

    protected $system = array('__construct', 'get_instance', 'index', 'pages', 'batch', 'notice', 'paging', 'upload', 'resize', 'filename', 'output', 'error');
    protected $action = array('view' => '查看', 'add' => '添加', 'edit' => '修改', 'del' => '删除');

    protected $region = array('position-province', 'position-city', 'position-district');

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Scaffold_model');
        if ($this->input->get('sync') == 'frontend') {
            $this->curpath = $this->frontend();
        } else {
            $this->tplpath = $this->backend . '/';
            $this->curpath = APPPATH;
        }
    }

    public function index()
    {
        $table = '';
        $this->data['tables'] = $this->Scaffold_model->list_tables();
        if($table = $this->input->get('table')){
            $dbprefix = $this->Scaffold_model->dbprefix();
            $table = substr($table, strlen($dbprefix));
            $this->data['fields'] = $this->Scaffold_model->field_array($table);
            $this->data['key'] = $this->key;
        }
        $this->data['table'] = $table;
        $setup = array();
        $this->data['get'] = array();
        $this->data['list'] = array();
        $this->data['sort'] = array();
        $this->data['all'] = array();
        $this->data['where'] = array();
        $this->data['entry'] = array();
        $this->data['seo'] = array();
        $file = APPPATH . 'scaffold/setup/' . $table . '.txt';
        if (file_exists($file)) {
            $setup = unserialize(file_get_contents($file));
            foreach ($setup as $key => $value) {
                $this->data[$key] = $value;
            }
        }
        $this->data['writeable'] = array(
            'backend/scaffold' => is_writable(APPPATH.'controllers'),
            'backend/controllers' => is_writable(APPPATH.'controllers'),
            'backend/models' => is_writable(APPPATH.'models'),
            'backend/views' => is_writable(APPPATH.'views'),
            'controllers' => is_writable($this->frontend().'controllers'),
            'models' => is_writable($this->frontend().'models'),
            'views' => is_writable($this->frontend().'views'),
        );
        $this->load->view('../scaffold/views/tables', $this->data);
    }

    public function ctrl($table)
    {
        $this->setup($table);
        $lists = $alls = $sort = $wheres = $entry = $upload = $gallery = $position = $seo = $array = $relation = $integer = array();
        $addtime = FALSE;

        if($this->input->post('list')){
            $lists = $this->input->post('list');
        }
        if($this->input->post('all')){
            $alls = $this->input->post('all');
        }
        if($this->input->post('sort')){
            $sort = $this->input->post('sort');
        }
        if($this->input->post('where')){
            $wheres = $this->input->post('where');
        }
        if($this->input->post('entry')){
            $entry = $this->input->post('entry');
            foreach($entry as $k => $v){
                if($v == 'attach' or $v == 'image'){
                    $upload[$k] = $v;
                } elseif ($v == 'gallery') {
                    $gallery[$k] = $v;
                } elseif (in_array($v, $this->region)) {
                    $position[$k] = $v;
                } elseif ($v == 'addtime') {
                    $addtime = true;
                } elseif ($v == 'null') {
                    unset($entry[$k]);
                }
            }
        }
        if($this->input->post('seo')){
            $seo = $this->input->post('seo');
            foreach($seo as $k => $v){
                if ($v != 'title' and $v != 'keywords' and $v != 'description') {
                    unset($seo[$k]);
                }
            }
        }
        if($this->input->post('array')){
            $array = $this->input->post('array');
        }
        if($this->input->post('integer')){
            $integer = $this->input->post('integer');
        }

        foreach($lists as $k => $v){
            if (array_key_exists($k, $entry) && ($entry[$k] == 'catalog' || $entry[$k] == 'select-from-db' || $entry[$k] == 'radio-from-db' || $entry[$k] == 'checkbox-from-db')) {
                $relation[$k] = $v;
            }
        }

        $comment = $this->Scaffold_model->comment($table);

        $fields = $this->Scaffold_model->field_array($table);
        $items = $this->fetch($fields, 'items');

        $smarty = $this->template();
        $smarty->assign('table', $table);
        $smarty->assign('comment', $comment);
        $smarty->assign('items', $items);
        $smarty->assign('lists', $lists);
        $smarty->assign('alls', $alls);
        $smarty->assign('relation', $relation);
        $smarty->assign('sort', $sort);
        $smarty->assign('wheres', $wheres);
        $smarty->assign('entry', $entry);
        $smarty->assign('upload', $upload);
        $smarty->assign('gallery', $gallery);
        $smarty->assign('array', $array);
        $smarty->assign('position', $position);
        $smarty->assign('seo', $seo);
        $smarty->assign('addtime', $addtime);
        $smarty->assign('integer', $integer);
        $string = $smarty->fetch($this->tplpath.'ctrl.tpl');

        $result = array('file'=>'', 'msg'=>'failed!');
        $file = $this->curpath.'controllers/'.ucfirst($table).'.php';
        if($this->create($file, $string)){
            $result['file'] = $file;
            $result['msg'] = 'success!';
        }
        echo json_encode($result);
    }
    
    public function model($table)
    {
        $this->setup($table);
        $gets = $lists = $alls = '';
        $alla = $wheres = $entry = $verify = $integer = array();

        $fields = $this->Scaffold_model->field_array($table);
        $primary_key = array_keys($this->fetch($fields, 'primary_key'), 1);
        $primary_key = implode(',', $primary_key);
        $null = $this->fetch($fields, 'null');
        $max_lengths = $this->fetch($fields, 'max_length');
        if($this->input->post('get')){
            foreach($this->input->post('get') as $k => $v){
                $gets = empty($gets)?$k:$gets . ', ' . $k;
            }
        }
        if($this->input->post('list')){
            foreach($this->input->post('list') as $k => $v){
                $lists = empty($lists)?$k:$lists . ', ' . $k;
            }
        }
        if($this->input->post('all')){
            foreach($this->input->post('all') as $k => $v){
                $alls = empty($alls)?$k:$alls . ', ' . $k;
                $alla[] = $k;
            }
        }
        if($this->input->post('where')){
            $wheres = $this->input->post('where');
        }
        if($this->input->post('entry')){
            $temp = $this->input->post('entry');
            foreach($temp as $k => $v){
                if ($v != 'null'){
                    $entry[$k] = $v;
                    if ($v == 'attach' or $v == 'image') {
                        $upload[$k] = $v;
                    } elseif ($v == 'gallery') {
                        $gallery[$k] = $v;
                    } elseif ($v == 'editor') {
                        $editor[$k] = $v;
                        $verify[$k] = $v;
                    } elseif ($v == 'date') {
                        $date[$k] = $v;
                        $verify[$k] = $v;
                    } elseif ($v == 'addtime') {
                        $addtime[$k] = $v;
                    } elseif (in_array($v, $this->region)) {
                        $position[$k] = $v;
                        $verify[$k] = $v;
                    } elseif ($v == 'hidden') {
                        $hidden[$k] = $v;
                    } elseif ($v == 'null') {
                        unset($entry[$k]);
                    } elseif ($v == 'disabled') {
                        //Code
                    } elseif ($v == 'switch') {
                        //Code
                    } elseif ($v == 'select-from-array' or $v == 'radio-from-array' or $v == 'checkbox-from-array' or $v == 'select-from-db' or $v == 'radio-from-db' or $v == 'checkbox-from-db') {
                        if ($null[$k] == 'NO') {
                            $verify[$k] = $v;
                        }
                    } elseif ($max_lengths[$k] > 0) {
                        $verify[$k] = $v;
                    }
                }
            }
        }
        if($this->input->post('integer')){
            $integer = $this->input->post('integer');
        }

        $smarty = $this->template();
        $smarty->assign('table', $table);
        $smarty->assign('primary_key', $primary_key);
        $smarty->assign('null', $null);
        $smarty->assign('max_lengths', $max_lengths);
        $smarty->assign('gets', $gets);
        $smarty->assign('lists', $lists);
        $smarty->assign('alls', $alls);
        $smarty->assign('alla', $alla);
        $smarty->assign('wheres', $wheres);
        $smarty->assign('entry', $entry);
        $smarty->assign('verify', $verify);
        $smarty->assign('integer', $integer);
        $string = $smarty->fetch($this->tplpath.'model.tpl');

        $result = array('file'=>'', 'msg'=>'failed!');
        $file = $this->curpath.'models/'.ucfirst($table).'_model.php';
        if($this->create($file, $string)){
            $result['file'] = $file;
            $result['msg'] = 'success!';
        }
        echo json_encode($result);
    }

    public function view($table)
    {
        $this->setup($table);
        $configs = $gets = $lists = $alls = $sort = $wheres = $entry = $catalog = $upload = $gallery = $editor = $date = $addtime = $position = $seo = $verify = $hidden = $integer = array();

        $comment = $this->Scaffold_model->comment($table);
        $fields = $this->Scaffold_model->field_array($table);
        $comments = $this->fetch($fields, 'comment');
        $type = $this->fetch($fields, 'type');
        $max_lengths = $this->fetch($fields, 'max_length');
        $null = $this->fetch($fields, 'null');
        if($this->input->post('get')){
            $gets = $this->input->post('get');
        }
        if($this->input->post('list')){
            $lists = $this->input->post('list');
        }
        if($this->input->post('all')){
            $alls = $this->input->post('all');
        }
        if($this->input->post('sort')){
            $sort = $this->input->post('sort');
        }
        if($this->input->post('where')){
            $wheres = $this->input->post('where');
        }
        if($this->input->post('entry')){
            $temp = $this->input->post('entry');
            foreach($temp as $k => $v){
                if ($v != 'null'){
                    if (in_array($v, $this->region)) {
                        if ($null[$k] == 'NO') {
                            $null['position'] = 'NO';
                        }
                        $entry['position'] = 'position';
                        $position[$k] = $v;
                        $verify[$k] = $v;
                    } else {
                        $entry[$k] = $v;
                        if ($v == 'catalog') {
                            $catalog[$k] = $v;
                            $verify[$k] = $v;
                        } elseif ($v == 'attach' or $v == 'image') {
                            $upload[$k] = $v;
                        } elseif ($v == 'gallery') {
                            $gallery[$k] = $v;
                        } elseif ($v == 'editor') {
                            $editor[$k] = $v;
                            $verify[$k] = $v;
                        } elseif ($v == 'date') {
                            $date[$k] = $v;
                            $verify[$k] = $v;
                        } elseif ($v == 'addtime') {
                            $addtime[$k] = $v;
                        } elseif ($v == 'hidden') {
                            $hidden[$k] = $v;
                        } elseif ($v == 'null') {
                            unset($entry[$k]);
                        } elseif ($v == 'disabled') {
                            //Code
                        } elseif ($v == 'switch') {
                            //Code
                        } elseif ($v == 'select-from-array' or $v == 'radio-from-array' or $v == 'checkbox-from-array' or $v == 'select-from-db' or $v == 'radio-from-db' or $v == 'checkbox-from-db') {
                            if ($null[$k] == 'NO') {
                                $verify[$k] = $v;
                            }
                        } elseif ($max_lengths[$k] > 0) {
                            $verify[$k] = $v;
                        }
                    } 
                }
            }
        }
        if (! empty($position)) {
            $temp = array();
            foreach($lists as $k => $v){
                if (array_key_exists($k, $position)) {
                    $temp['position'] = 'int';
                } else {
                    $temp[$k] = $v;
                }
            }
            $lists = $temp;
        }
        if($temp = $this->input->post('seo')){
            foreach($temp as $k => $v){
                if ($v == 'title' or $v == 'keywords' or $v == 'description') {
                    $seo[$v] = $k;
                }
            }
        }
        if($this->input->post('integer')){
            $integer = $this->input->post('integer');
        }

        $result = array();
        if (!empty($upload)) {
            $this->config->load('uploads');
            foreach ($upload as $k => $v) {
                if ($item = $this->config->item($k, $table)) {
                    $configs[$k] = floor($item['upload_config']['max_size']/1024);
                } else {
                    $result[$k]['msg'] = 'Upload field is not configured!';
                    die(json_encode($result));
                }
            }
        }

        $smarty = $this->template();
        $smarty->assign('site', $this->site);
        $smarty->assign('comment', $comment);
        $smarty->assign('type', $type);
        $smarty->assign('table', $table);
        $smarty->assign('fields', $this->field($fields));
        $smarty->assign('comments', $comments);
        $smarty->assign('max_lengths', $max_lengths);
        $smarty->assign('null', $null);
        $smarty->assign('gets', $gets);
        $smarty->assign('lists', $lists);
        $smarty->assign('alls', $alls);
        $smarty->assign('col', count($lists)+1);
        $smarty->assign('sort', $sort);
        $smarty->assign('wheres', $wheres);
        $smarty->assign('entry', $entry);
        $smarty->assign('catalog', $catalog);
        $smarty->assign('verify', $verify);
        $smarty->assign('upload', $upload);
        $smarty->assign('gallery', $gallery);
        $smarty->assign('configs', $configs);
        $smarty->assign('editor', $editor);
        $smarty->assign('position', $position);
        $smarty->assign('seo', $seo);
        $smarty->assign('date', $date);
        $smarty->assign('addtime', $addtime);
        $smarty->assign('hidden', $hidden);
        $smarty->assign('integer', $integer);

        $path = $this->curpath.'views/'.ucfirst($table);
        if(! file_exists($path)) mkdir($path, 0777);

        $actions = array('list'=>'select', 'view'=>'select');
        if (! empty($this->tplpath)) {
            $actions = array_merge($actions, array('add'=>'insert', 'edit'=>'update'));
        }

        foreach($actions as $do => $act){
            $string = $smarty->fetch($this->tplpath.'view/'.$do.'.tpl');
            $file = $path.'/'.$do.'.php';
            if($this->create($file, $string)){
                $result[$do]['file'] = $file;
                $result[$do]['msg'] = 'success!';
            } else {
                $result[$do]['file'] = $file;
                $result[$do]['msg'] = 'failed!';
            }
        }
        echo json_encode($result);
    }

    public function field($fields){
        $result = array();
        foreach($fields as $k => $row){
            $result[] = $row['name'];
        }
        return $result;
    }

    public function fetch($fields, $item){
        $result = array();
        foreach($fields as $k => $row){
            if (array_key_exists($item, $row)) {
                $result[$k] = $row[$item];
            }
        }
        return $result;
    }

    public function methods($control)
    {
        $methods = array();
        $controller = APPPATH.'controllers/' . $control . '.php';
        if (file_exists($controller)) {
            include ($controller);
            if(class_exists($control, FALSE)){
                $controller = new $control;
                foreach (get_class_methods($controller) as $method) {
                    if (!in_array($method, $this->system)) {
                        $m = new ReflectionMethod($control, $method);
                        $r = Reflection::getModifierNames($m->getModifiers());
                        if (in_array('public', $r)) {
                            $methods[] = $method;
                        }
                    }
                }
            }
        }
        return $methods;
    }

    public function template()
    {
        $this->load->library('template');
        $smarty = new template();
        $smarty->template_dir = APPPATH . 'scaffold/template';
        $smarty->cache_dir = APPPATH . 'scaffold/caches';
        $smarty->compile_dir = APPPATH . 'scaffold/compiled';
        $smarty->force_compile = TRUE;
        return $smarty;
    }

    public function setup($table)
    {
        $file = APPPATH . 'scaffold/setup/' . $table . '.txt';
        $this->create($file, serialize($this->input->post()));
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

    public function create($file, $string)
    {
        if (! is_writable($file)) {
            $path = substr($file, 0, strrpos($file, '/'));
            if (! is_dir($path)) {
                mkdir($path, true, 0777);
            }
        }
        return file_put_contents($file, $string);
    }
}

/* End of file scaffold.php */
/* Location: ./application/controllers/scaffold.php */