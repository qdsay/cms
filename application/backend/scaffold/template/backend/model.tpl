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

    public $rules = array(
{foreach name=seek from=$verify item=type key=field}
{if $entry[$field] eq 'password'}
        array(
            'field'   => '{$field}',
            'label'   => '{$comments[$field]|default:$field}',
            'rules'   => 'min_length[6]|{if $max_lengths[$field] gt 0}max_length[{$max_lengths[$field]}]{/if}|matches[re{$field}]{if $null[$field] eq 'NO'}|required{/if}'
        ),
        array(
            'field'   => 're{$field}',
            'label'   => '{$comments[$field]|default:$field}',
            'rules'   => 'min_length[6]|{if $max_lengths[$field] gt 0}max_length[{$max_lengths[$field]}]{/if}{if $null[$field] eq 'NO'}|required{/if}'
        ){if not $smarty.foreach.seek.last},{/if}

{elseif $entry[$field] eq 'select-from-db' or $entry[$field] eq 'radio-from-db' or $entry[$field] eq 'checkbox-from-db' or $entry[$field] eq 'position-province' or $entry[$field] eq 'position-city' or $entry[$field] eq 'position-district' or $entry[$field] eq 'catalog'}
        array(
            'field'   => '{$field}',
            'label'   => '{$comments[$field]|default:$field}',
            'rules'   => 'is_natural_no_zero{if $null[$field] eq 'NO'}|required{/if}'
        ){if not $smarty.foreach.seek.last},{/if}

{elseif $entry[$field] eq 'select-from-array' or $entry[$field] eq 'radio-from-array' or $entry[$field] eq 'checkbox-from-array'}
        array(
            'field'   => '{$field}',
            'label'   => '{$comments[$field]|default:$field}',
            'rules'   => '{if $integer[$field]}is_natural_no_zero{elseif $max_lengths[$field] gt 0}trim|max_length[{$max_lengths[$field]}]{/if}{if $null[$field] eq 'NO'}|required{/if}'
        ){if not $smarty.foreach.seek.last},{/if}

{elseif $entry[$field] eq 'text' or $entry[$field] eq 'textarea'}
        array(
            'field'   => '{$field}',
            'label'   => '{$comments[$field]|default:$field}',
            'rules'   => 'trim|max_length[{$max_lengths[$field]}]{if $null[$field] eq 'NO'}|required{/if}'
        ){if not $smarty.foreach.seek.last},{/if}

{elseif $entry[$field] eq 'editor' and $null[$field] eq 'NO'}
        array(
            'field'   => '{$field}',
            'label'   => '{$comments[$field]|default:$field}',
            'rules'   => 'required'
        ){if not $smarty.foreach.seek.last},{/if}

{/if}
{/foreach}
    );

    public function __construct()
    {
        parent::__construct();
    }
{if $wheres}
{foreach name=seek from=$wheres item=format key=field}
{if $entry[$field] eq 'catalog'}

    public function set_catalog($catalog, ${$field}) {
        $ids = qd_catalog_ids($catalog, intval(${$field}));
        if (count($ids) > 1) {
            $this->{$table}->set_where('{$field}', $ids, 'where_in');
            $this->{$table}->set_condition('{$field}', ${$field});
        } else {
            $this->{$table}->set_where('{$field}', ${$field});
        }
    }
{/if}
{/foreach}
{/if}
}

/* End of file {$table}.php */
/* Location: ./application/models/{$table}.php */