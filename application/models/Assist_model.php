<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assist_model extends QD_Model {

    public $table = 'assist';
    public $primary_key = 'id';

    public $attributes = 'id, title, aliases, contents, disabled, addtime, uptime';
    public $list_attributes = 'id, title, aliases, disabled, addtime';

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file assist.php */
/* Location: ./application/models/assist.php */