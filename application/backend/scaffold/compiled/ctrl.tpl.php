<?php echo '<?php'; ?>
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class <?php echo ucfirst($this->_var['table']); ?> extends QD_Controller {

    public $per_page = 20;

    function __construct()
    {
        parent::__construct();
<?php if ($this->_var['entry']): ?>
<?php $_from = $this->_var['entry']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format']):
        $this->_foreach['seek']['iteration']++;
?>
<?php if ($this->_var['format'] == 'select-from-array' || $this->_var['format'] == 'radio-from-array' || $this->_var['format'] == 'checkbox-from-array' || $this->_var['format'] == 'switch'): ?>
        $this->data['<?php echo $this->_var['field']; ?>'] = array(<?php echo $this->_var['array'][$this->_var['field']]; ?>);
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
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
<?php if ($this->_var['position']): ?>
        $this->load->helper('region');
<?php endif; ?>
        //获取结果集
        $this->load->model('<?php echo ucfirst($this->_var['table']); ?>_model', '<?php echo $this->_var['table']; ?>');
<?php if ($this->_var['wheres']): ?>
<?php $_from = $this->_var['wheres']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format']):
        $this->_foreach['seek']['iteration']++;
?>
<?php if ($this->_var['entry'] [ $this->_var['field'] ] == 'text'): ?>
        $this-><?php echo $this->_var['table']; ?>->set_like('<?php echo $this->_var['field']; ?>', $this->input->get('<?php echo $this->_var['field']; ?>'));
<?php elseif ($this->_var['entry'] [ $this->_var['field'] ] == 'catalog'): ?>
        //分类查询
        $catalog = $this->catalog('<?php echo $this->_var['table']; ?>');
        $<?php echo $this->_var['field']; ?> = $this->input->get('<?php echo $this->_var['field']; ?>');
        $ids = qd_catalog_ids($catalog, intval($<?php echo $this->_var['field']; ?>));
        if (count($ids) > 1) {
            $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', $ids, 'where_in');
            $this-><?php echo $this->_var['table']; ?>->set_condition('<?php echo $this->_var['field']; ?>', $<?php echo $this->_var['field']; ?>);
        } else {
            $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', $<?php echo $this->_var['field']; ?>);
        }
<?php elseif ($this->_var['entry'] [ $this->_var['field'] ] == 'select-from-db' || $this->_var['entry'] [ $this->_var['field'] ] == 'radio-from-db' || $this->_var['entry'] [ $this->_var['field'] ] == 'checkbox-from-db'): ?>
        $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', $this->input->get('<?php echo $this->_var['field']; ?>'));
<?php elseif ($this->_var['entry'] [ $this->_var['field'] ] == 'select-from-array' || $this->_var['entry'] [ $this->_var['field'] ] == 'radio-from-array' || $this->_var['entry'] [ $this->_var['field'] ] == 'checkbox-from-array'): ?>
        $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', $this->input->get('<?php echo $this->_var['field']; ?>'));
<?php elseif ($this->_var['entry'] [ $this->_var['field'] ] == 'switch'): ?>
        $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', $this->input->get('<?php echo $this->_var['field']; ?>'));
<?php elseif ($this->_var['entry'] [ $this->_var['field'] ] == 'date'): ?>
        $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', $this->input->get('<?php echo $this->_var['field']; ?>'));
<?php elseif ($this->_var['entry'] [ $this->_var['field'] ] == 'addtime'): ?>
        $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', strtotime($this->input->get('<?php echo $this->_var['field']; ?>')));
        $this-><?php echo $this->_var['table']; ?>->set_condition('<?php echo $this->_var['field']; ?>', $this->input->get('<?php echo $this->_var['field']; ?>'));
<?php elseif ($this->_var['entry'] [ $this->_var['field'] ] == 'position-province' || $this->_var['entry'] [ $this->_var['field'] ] == 'position-city' || $this->_var['entry'] [ $this->_var['field'] ] == 'position-district'): ?>
        //地理位置搜索
        if (qd_rigion_level($this->input->get('<?php echo $this->_var['field']; ?>')) == 'district') {
            $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', intval($this->input->get('<?php echo $this->_var['field']; ?>')));
        } else {
            $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', qd_round_up($this->input->get('<?php echo $this->_var['field']; ?>')), 'where', '<');
            $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', intval($this->input->get('<?php echo $this->_var['field']; ?>')), 'where', '>=');
        }
<?php else: ?>
        $this-><?php echo $this->_var['table']; ?>->set_where('<?php echo $this->_var['field']; ?>', $this->input->get('<?php echo $this->_var['field']; ?>'));
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['sort']): ?>
        //排序
        $this-><?php echo $this->_var['table']; ?>->set_order($this->input->get('order'), 'uptime-desc');
<?php endif; ?>
        $this->data['list'] = $this-><?php echo $this->_var['table']; ?>->list_result($cur_page, $this->per_page);
<?php if ($this->_var['wheres']): ?>
        $this->data['where'] = $this-><?php echo $this->_var['table']; ?>->get_condition();
<?php endif; ?>
        $this->data['paging'] = $this-><?php echo $this->_var['table']; ?>->paging('<?php echo $this->_var['table']; ?>/pages');
<?php if ($this->_var['relation']): ?>
        //加载关联数据
<?php $_from = $this->_var['relation']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format']):
        $this->_foreach['seek']['iteration']++;
?>
<?php if ($this->_var['entry'] [ $this->_var['field'] ] == 'catalog'): ?>
        $this->data['<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>'] = $catalog;
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php $_from = $this->_var['relation']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format']):
        $this->_foreach['seek']['iteration']++;
?>
<?php if ($this->_var['entry'] [ $this->_var['field'] ] == 'select-from-db' || $this->_var['entry'] [ $this->_var['field'] ] == 'radio-from-db' || $this->_var['entry'] [ $this->_var['field'] ] == 'checkbox-from-db'): ?>
        $this->load->model('<?php echo ucfirst(substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id"))); ?>_model', '<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>');
        $this->data['<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>'] = $this-><?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>->get_option();
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
        //加载模板
        $this->load->view('<?php echo $this->_var['table']; ?>/list', $this->data);
    }

    /**
     * 查看<?php echo empty($this->_var['comment']) ? $this->_var['table'] : $this->_var['comment']; ?>;
     * @param   Integer
     * @return  Output a view
     */
    public function view($id = 0)
    {
        if (is_numeric($id) && $id > 0) {
<?php if ($this->_var['position']): ?>
            $this->load->helper('region');

<?php endif; ?>
            $this->load->model('<?php echo ucfirst($this->_var['table']); ?>_model', '<?php echo $this->_var['table']; ?>');
            $this->data['<?php echo $this->_var['table']; ?>'] = $this-><?php echo $this->_var['table']; ?>->get($id);
<?php if ($this->_var['entry']): ?>
<?php $_from = $this->_var['entry']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('field', 'format');$this->_foreach['seek'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['seek']['total'] > 0):
    foreach ($_from AS $this->_var['field'] => $this->_var['format']):
        $this->_foreach['seek']['iteration']++;
?>
<?php if ($this->_var['format'] == 'catalog'): ?>
            $this->data['<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>'] = $this->catalog('<?php echo $this->_var['table']; ?>');

<?php elseif ($this->_var['format'] == 'select-from-db' || $this->_var['format'] == 'radio-from-db' || $this->_var['format'] == 'checkbox-from-db'): ?>
            $this->load->model('<?php echo ucfirst(substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id"))); ?>_model', '<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>');
            $this->data['<?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>'] = $this-><?php echo substr($this->_var['field'], 0, strrpos($this->_var['field'], "_id")); ?>->get_option();

<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['seo']): ?>
            $this->load->model('Seo_model', 'seo');
            $this->data['seo'] = $this->seo->get('<?php echo $this->_var['table']; ?>', $id);

<?php endif; ?>
            $this->load->view('<?php echo $this->_var['table']; ?>/view',$this->data);
        }
    }
}

/* End of file <?php echo $this->_var['table']; ?>.php */
/* Location: ./application/controllers/<?php echo $this->_var['table']; ?>.php */