<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('DS', DIRECTORY_SEPARATOR); 

class Storage {

    private $ci;

    public $target = ''; //目标文件

    public $upbase_path = ''; //跟路径
    public $target_path = ''; //目标存储路径

    public $resize_config = array(); //缩图配置
    public $resize = false; //是否生成缩略图

    public $sub_directory = false; //是否建立子目录

    /**
     * 初始化
     * @param   String
     * @param   String
     */
    public function initialize($caller, $caller_field)
    {
        //加载CI
        $this->ci =& get_instance();
        $this->ci->config->load('uploads');
        //初始化存储路径
        $this->upbase_path = realpath($this->ci->config->item('upbase_path')) . '/';
        $this->target_path = $this->ci->config->item('upload_path') . $caller . '/';
        //载入配置文件
        $config = $this->ci->config->item($caller_field, $caller);
        //存储目录配置
        if (isset($config['directory']) && $config['directory'] == 'sub') {
            $this->target_path = $this->target_path . $this->directory();
            $this->sub_directory = true;
        }
        //缩略图配置
        if (isset($config['resize_config'])) {
            $this->resize_config = $config['resize_config'];
            $this->resize = true;
        }
    }

    /**
     * 另存
     * @param   String
     * @param   Boolean
     */
    public function resave($source)
    {
        $target = '';
        $source_image = $this->upbase_path . $source;
        if (file_exists($source_image)) {
            //创建目录
            $this->set_target_path();
            //另存文件名
            $target = $this->target_path . $this->filename($source, $this->sub_directory);
            $target_image = $this->upbase_path . $target;
            //删除原始文件
            if (file_exists($target_image)) @unlink($target_image);
            //转移文件
            if (rename($source_image, $target_image)){
                $this->target = $target;
            }
            //创建缩略图
            if (! empty($this->target) && $this->resize) {
                $this->resize($target);
            }
        }
        return $this->target;
    }

    /**
     * 缩图
     */
    public function resize($target = '')
    {
        if (! empty($this->resize_config) && $this->resize_config['create_thumb']) {
            $config['create_thumb'] = $this->resize_config['create_thumb'];
            $config['image_library'] = 'gd2';
            $config['source_image'] = empty($target) ? $this->upbase_path . $this->target : $this->upbase_path . $target;
            $config['maintain_ratio'] = $this->resize_config['maintain_ratio'];
            $this->ci->load->library('image_lib');
            foreach ($this->resize_config['scale'] as $key => $value) {
                $config['width'] = $value['width'];
                $config['height'] = $value['height'];
                $config['thumb_marker'] = '_'.$key;
                $this->ci->image_lib->initialize($config);
                if (! $this->ci->image_lib->resize())
                {
                    $errors = $this->ci->image_lib->display_errors();
                    $this->ci->output->display($errors, 'html');
                }
            }
        }
    }

    /**
     * 删除
     * @param   String
     * @param   Boolean
     */
    public function remove($image, $resize = FALSE)
    {
        //删除原始文件
        $this->delfile($image);
        //删除缩略图
        if ($this->resize || $resize) {
            $this->remove_resize($image);
        }
    }

    /**
     * 删除
     * @param   String
     * @param   Boolean
     */
    public function remove_resize($image)
    {
        //删除缩略图
        if (! empty($this->resize_config)) {
            foreach ($this->resize_config['scale'] as $key => $value) {
                $this->delfile($this->thumbnail($image, '_'.$key));
            }
        }
    }

    /**
     * 创建目标路径
     */
    public function set_target_path()
    {
        $this->mkpath($this->target_path);
    }

    /**
     * 删除文件
     * @param   String
     */
    public function delfile($file)
    {
        $file = $this->upbase_path . $file;
        if (file_exists($file)) {
            @unlink($file);
        }
    }

    /**
     * 创建目录
     * @param   String
     * @return   Boolean
     */
    public function mkpath($path)
    {
        $path = $this->upbase_path . $path;
        if (is_dir($path)) {
            return true;
        }
        if (@mkdir($path, 0755, true)) {
            return true;
        }
        return FALSE;
    }

    /**
     * 生成存储目录
     * @return  String
     */
    public function directory() {
        return chunk_split(date('Ymd'),4,"/");
    }

    /**
     * 生成文件名
     * @param   String
     * @param   String
     * @return  String
    */
    public function filename($filename, $create_date = FALSE) {
        if ($create_date) {
            return substr(microtime(true) * 10000, -9) . rand(10, 99) . strchr($filename, '.');
        } else {
            return (microtime(true) * 10000) . rand(10, 99) . strchr($filename, '.');
        }
    }

    /**
     * 生成文件名
     * @param   String
     * @param   String
     * @return  String
     */
    public function thumbnail($file, $prefix) {
        $pos = strrpos($file, '.');
        return substr($file, 0, $pos) .$prefix. substr($file, $pos);
    }
}

/* End of file storage.php */
/* Location: ./application/libraries/storage.php */