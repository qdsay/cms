<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class {$table|ucfirst} extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
{if $entry}
{foreach name=seek from=$entry item=format key=field}
{if $format eq 'select-from-array' or $format eq 'radio-from-array' or $format eq 'checkbox-from-array' or $format eq 'switch'}
        $this->data['{$field}'] = array({$array[$field]});
{/if}
{/foreach}
{/if}
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
{if $position}
        $this->load->helper('region');
{/if}
        //获取结果集
        $this->load->model('{$table|ucfirst}_model', '{$table}');
{if $wheres}
{foreach name=seek from=$wheres item=format key=field}
{if $entry[$field] eq 'text'}
        $this->{$table}->set_like('{$field}', $this->input->get('{$field}'));
{elseif $entry[$field] eq 'catalog'}
        //分类查询
        $catalog = $this->catalog('{$table}');
        ${$field} = $this->input->get('{$field}');
        $ids = qd_catalog_ids($catalog, intval(${$field}));
        if (count($ids) > 1) {
            $this->{$table}->set_where('{$field}', $ids, 'where_in');
            $this->{$table}->set_condition('{$field}', ${$field});
        } else {
            $this->{$table}->set_where('{$field}', ${$field});
        }
{elseif $entry[$field] eq 'select-from-db' or $entry[$field] eq 'radio-from-db' or $entry[$field] eq 'checkbox-from-db'}
        $this->{$table}->set_where('{$field}', $this->input->get('{$field}'));
{elseif $entry[$field] eq 'select-from-array' or $entry[$field] eq 'radio-from-array' or $entry[$field] eq 'checkbox-from-array'}
        $this->{$table}->set_where('{$field}', $this->input->get('{$field}'));
{elseif $entry[$field] eq 'switch'}
        $this->{$table}->set_where('{$field}', $this->input->get('{$field}'));
{elseif $entry[$field] eq 'date'}
        $this->{$table}->set_where('{$field}', $this->input->get('{$field}'));
{elseif $entry[$field] eq 'addtime'}
        $this->{$table}->set_where('{$field}', strtotime($this->input->get('{$field}')));
        $this->{$table}->set_condition('{$field}', $this->input->get('{$field}'));
{elseif $entry[$field] eq 'position-province' or $entry[$field] eq 'position-city' or $entry[$field] eq 'position-district'}
        //地理位置搜索
        if (qd_rigion_level($this->input->get('{$field}')) == 'district') {
            $this->{$table}->set_where('{$field}', intval($this->input->get('{$field}')));
        } else {
            $this->{$table}->set_where('{$field}', qd_round_up($this->input->get('{$field}')), 'where', '<');
            $this->{$table}->set_where('{$field}', intval($this->input->get('{$field}')), 'where', '>=');
        }
{else}
        $this->{$table}->set_where('{$field}', $this->input->get('{$field}'));
{/if}
{/foreach}
{/if}
{if $sort}
        //排序
        $this->{$table}->set_order($this->input->get('order'), 'uptime-desc');
{/if}
        $this->data['list'] = $this->{$table}->list_result($cur_page, $this->per_page);
{if $wheres}
        $this->data['where'] = $this->{$table}->get_condition();
{/if}
        $this->data['paging'] = $this->{$table}->paging('{$table}/pages');
{if $relation}
        //加载关联数据
{foreach name=seek from=$relation item=format key=field}
{if $entry[$field] eq 'catalog'}
        $this->data['{$field|strip_id}'] = $catalog;
{/if}
{/foreach}
{foreach name=seek from=$relation item=format key=field}
{if $entry[$field] eq 'select-from-db' or $entry[$field] eq 'radio-from-db' or $entry[$field] eq 'checkbox-from-db'}
        $this->load->model('{$field|strip_id|ucfirst}_model', '{$field|strip_id}');
        $this->data['{$field|strip_id}'] = $this->{$field|strip_id}->get_option();
{/if}
{/foreach}
{/if}
        //加载模板
        $this->load->view('{$table}/list', $this->data);
    }

    /**
     * 查看{$comment|default:$table};
     * @param   Integer
     * @return  Output a view
     */
    public function view($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
{if $position}
            $this->load->helper('region');

{/if}
            $this->load->model('{$table|ucfirst}_model', '{$table}');
            $this->data['{$table}'] = $this->{$table}->get($id);
{if $entry}
{foreach name=seek from=$entry item=format key=field}
{if $format eq 'catalog'}
            $this->data['{$field|strip_id}'] = $this->catalog('{$table}');

{elseif $format eq 'select-from-db' or $format eq 'radio-from-db' or $format eq 'checkbox-from-db'}
            $this->load->model('{$field|strip_id|ucfirst}_model', '{$field|strip_id}');
            $this->data['{$field|strip_id}'] = $this->{$field|strip_id}->get_option();

{/if}
{/foreach}
{/if}
{if $seo}
            $this->load->model('Seo_model', 'seo');
            $this->data['seo'] = $this->seo->get('{$table}', $id);

{/if}
            $this->load->view('{$table}/view',$this->data);
        }
    }
}

/* End of file {$table}.php */
/* Location: ./application/controllers/{$table}.php */