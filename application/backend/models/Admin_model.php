<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends QD_Model {

    public $table = 'admin';
    public $primary_key = 'id';

    public $attributes = 'id, username, password, groups_id, addtime, last_login_time, last_login_ip, disabled';
    public $list_attributes = 'id, username, password, groups_id, addtime, disabled';
    public $option = array('id', 'username');

    public $rules = array(
        array(
            'field'   => 'username',
            'label'   => '用户名',
            'rules'   => 'required|max_length[16]'
        ),
        array(
            'field'   => 'password',
            'label'   => '密码',
            'rules'   => 'required|min_length[6]|max_length[32]|matches[repassword]'
        ),
        array(
            'field'   => 'repassword',
            'label'   => '密码',
            'rules'   => 'required|min_length[6]|max_length[32]'
        ),
        array(
            'field'   => 'groups',
            'label'   => '用户组',
            'rules'   => 'greater_than[0]'
        )
    );

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 验证登录
     * @param   String
     * @param   String
     * @return  Integer
     */
    public function verify($username,$password) {
        $this->db->select('id, username, groups_id');
        $this->db->where(array('username' => $username, 'password' => md5($password), 'disabled' => 1));
        $this->db->limit(1);
        $query = $this->db->get('admin');
        return $query->row();
    }
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */