<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class {$table|ucfirst} extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
        $this->data['current'] = '{$comment|default:$table}';
        $this->data['items'] = array('edit' => '基本信息'{if $gallery}, 'gallery' => '图集管理'{/if}{if $seo}, 'seo' => 'SEO设置'{/if});
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
        $this->{$table}->set_catalog($catalog, $this->input->get('catalog_id'));
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
            if ($this->input->get('notice')) {
                $this->load->library('notice');
                if ($notice = $this->notice->getNotice()) {
                    $this->data['notice'] = $notice;
                }
            }

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
{if $gallery}
            //获取图集
            $this->load->model('Gallery_model', 'gallery');
            $this->data['gallery'] = $this->gallery->get_all(array(
                'caller' => '{$table}',
                'caller_id' => $id
            ), 'serial asc');

{/if}
{if $seo}
            $this->load->model('Seo_model', 'seo');
            $this->data['seo'] = $this->seo->get_caller('{$table}', $id);

{/if}
            $this->load->model('{$table|ucfirst}_model', '{$table}');
            $this->data['{$table}'] = $this->{$table}->get($id);
            $this->load->view('{$table}/view',$this->data);
        }
    }

    /**
     * 添加{$comment|default:$table};
     * @return  Output a view
     */
    public function add()
    {
        $this->load->model('{$table|ucfirst}_model', '{$table}');
        if ($this->{$table}->validate()) {
            //数据
            $data = array(
{if $entry}
{foreach name=seek from=$entry item=format key=field}
{if $format eq 'null' or $format eq 'gallery'}
{elseif $format eq 'addtime'}
                '{$field}' => time(){if not $smarty.foreach.seek.last},{/if}

{elseif $seo[$field] eq 'keywords'}
                '{$field}' => qd_cleanup($this->input->post('{$field}')){if not $smarty.foreach.seek.last},{/if}

{elseif $upload and ($format eq 'image' or $format eq 'attach')}
                '{$field}' => $this->resave('{$field}'){if not $smarty.foreach.seek.last},{/if}

{else}
                '{$field}' => $this->input->post('{$field}'){if not $smarty.foreach.seek.last},{/if}

{/if}
{/foreach}
{/if}
            );
            //执行
            if ($id = $this->{$table}->insert($data)) {
{if $seo}
                //添加SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->set('{$table}', $id, array(
{foreach name=seek from=$seo item=format key=field}
                    '{$format}' => $data['{$field}'],
{/foreach}
{if $addtime}
                    'addtime' => $data['addtime']
{else}
                    'addtime' => time()
{/if}
                ));
{/if}
                //通知
                $this->load->library('notice');
                $this->notice->succeed(array(
                    'title' => '{$comment|default:$table}添加成功！',
{if $gallery}
                    'location' => '/{$table}/gallery/'.$id.'?notice=add'
{elseif $seo}
                    'location' => '/{$table}/seo/'.$id.'?notice=add'
{else}
                    'location' => '/{$table}/view/'.$id.'?notice=add'
{/if}
                ));
            }
        } else {
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
            $this->load->view('{$table}/add',$this->data);
        }
    }

    /**
     * 编辑{$comment|default:$table};
     * @param   Integer
     * @return  Output a view
     */
    public function edit($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
            $this->load->model('{$table|ucfirst}_model', '{$table}');
{if $upload}
            ${$table} = $this->{$table}->get($id);
{/if}
            if($this->{$table}->validate()){
{if $entry}
                //数据
                $data = array(
{foreach name=seek from=$entry item=format key=field}
{if $format eq 'null' or $format eq 'addtime' or $format eq 'gallery'}
{elseif $seo[$field] eq 'keywords'}
                    '{$field}' => qd_cleanup($this->input->post('{$field}')){if not $smarty.foreach.seek.last},{/if}

{elseif $upload and ($format eq 'image' or $format eq 'attach')}
                    '{$field}' => $this->resave('{$field}', ${$table}->{$field}){if not $smarty.foreach.seek.last},{/if}

{else}
                    '{$field}' => $this->input->post('{$field}'){if not $smarty.foreach.seek.last},{/if}

{/if}
{/foreach}
                );
{/if}
                //更新
                if ($this->{$table}->update($id, $data)) {
                    //通知
                    $this->load->library('notice');
                    $this->notice->succeed(array(
                        'title' => '{$comment|default:$table}编辑成功！',
                        'location' => '/{$table}/view/'.$id.'?notice=edit'
                    ));
                }
            } else {
{if $upload}
                $this->data['{$table}'] = ${$table};
{else}
                $this->data['{$table}'] = $this->{$table}->get($id);
{/if}
{if $entry}
{foreach name=seek from=$entry item=format key=field}
{if $format eq 'catalog'}
                $this->data['{$field|strip_id}'] = $this->catalog('{$table}');
{/if}
{/foreach}
{foreach name=seek from=$entry item=format key=field}
{if $format eq 'select-from-db' or $format eq 'radio-from-db' or $format eq 'checkbox-from-db'}

                $this->load->model('{$field|strip_id|ucfirst}_model', '{$field|strip_id}');
                $this->data['{$field|strip_id}'] = $this->{$field|strip_id}->get_option();
{/if}
{/foreach}
{/if}
                $this->load->view('{$table}/edit', $this->data);
            }
        }
    }
{if $gallery}

    /**
     * 获取图集
     * @param   String
     * @param   Integer
     * @return  Array
     */
    public function gallery($id, $field = '{$field}')
    {
        if (is_numeric($id) && $id > 0) {
{foreach name=seek from=$gallery item=format key=field}
            parent::gallery($id, '{$field}');
{/foreach}
            $this->data['caller'] = '{$table}';
            $this->data['caller_id'] = $id;
            $this->load->view('gallery', $this->data);
        }
    }
{/if}
{if $gallery or $seo}

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
{if $gallery}
                //删除图集
                $this->load->model('Gallery_model', 'gallery');
                $this->gallery->delete_where(array(
                    'caller' => '{$table}', 
                    'caller_id' => $params['id']
                ));
{/if}
{if $seo}
                //删除SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->delete_where(array(
                    'caller' => '{$table}', 
                    'caller_id' => $params['id']
                ));
{/if}
                break;

            case 'before_batch_delete':
{if $gallery}
                //删除图集
                $this->load->model('Gallery_model', 'gallery');
                $this->gallery->set_where('caller', '{$table}');
                $this->gallery->set_where('caller_id', $params['ids'], 'where_in');
                $this->gallery->delete_result();
{/if}
{if $seo}
                //删除SEO信息
                $this->load->model('Seo_model', 'seo');
                $this->seo->set_where('caller', '{$table}');
                $this->seo->set_where('caller_id', $params['ids'], 'where_in');
                $this->seo->delete_result();
{/if}
                break;

            default:
                # code...
                break;
        }
    }
{/if}
}

/* End of file {$table}.php */
/* Location: ./application/controllers/{$table}.php */