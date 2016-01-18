<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('DS', DIRECTORY_SEPARATOR); 

class Gallery {

    private $ci;

    public function __construct()
    {
        //加载CI
        $this->ci =& get_instance();
        $this->ci->load->library('storage');
    }
}

/* End of file gallery.php */
/* Location: ./application/libraries/gallery.php */