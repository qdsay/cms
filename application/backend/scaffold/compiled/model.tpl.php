<?php echo '<?php'; ?>
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class <?php echo ucfirst($this->_var['table']); ?>_model extends QD_Model {

    public $table = '<?php echo $this->_var['table']; ?>';
<?php if ($this->_var['primary_key']): ?>
    public $primary_key = '<?php echo $this->_var['primary_key']; ?>';
<?php endif; ?>

    public $attributes = '<?php echo $this->_var['gets']; ?>';
    public $list_attributes = '<?php echo $this->_var['lists']; ?>';
<?php if ($this->_var['alls'] != ""): ?>
    public $option = array('<?php echo $this->_var['alla']['0']; ?>', '<?php echo $this->_var['alla']['1']; ?>');
<?php endif; ?>

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file <?php echo $this->_var['table']; ?>.php */
/* Location: ./application/models/<?php echo $this->_var['table']; ?>.php */