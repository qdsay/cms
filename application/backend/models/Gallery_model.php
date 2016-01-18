<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends QD_Model {

    public $table = 'gallery';
    public $primary_key = 'id';

    public $attributes = 'id, caller, caller_id, image, info, serial, addtime';
    public $list_attributes = 'id, caller, caller_id, image, info, serial, addtime';

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file gallery.php */
/* Location: ./application/models/gallery.php */