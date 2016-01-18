<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class {$table|ucfirst}_model extends QD_Model {

    public $table = '{$table}';
{if $primary_key}
    public $primary_key = '{$primary_key}';
{/if}

    public $attributes = '{$gets}';
    public $list_attributes = '{$lists}';
{if $alls neq ""}
    public $option = array('{$alla[0]}', '{$alla[1]}');
{/if}

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file {$table}.php */
/* Location: ./application/models/{$table}.php */