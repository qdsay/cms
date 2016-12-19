<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QD_Model extends CI_Model {

    public $table = '';
    public $primary_key = '';

    public $attributes = '*';
    public $list_attributes = '*';
    public $option = array();

    public $join = array();
    public $where = array();
    public $condition = array();
    public $order = array();
    public $query = array();
    public $total = 0;

    public $cur_page = 0;
    public $per_page = 20;
    public $query_url = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 设置属性
     * @param   String
     */
    public function set_attributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * 设置属性
     * @param   String
     */
    public function set_list_attributes($list_attributes)
    {
        $this->list_attributes = $list_attributes;
    }

    /**
     * 设置属性
     * @param   String
     */
    public function set_option($option)
    {
        $this->option = $option;
    }

    /**
     * 查询
     * @param   Integer
     * @return  Mixed
     */
    public function get($primary_value, $type = 'object')
    {
        $this->db->select($this->attributes);
        $this->db->where($this->primary_key, $primary_value);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->first_row($type);
    }

    /**
     * 查询
     * @param   Array
     * @return  Mixed
     */
    public function get_where($where = array(), $order = '', $type = 'object')
    {
        $this->db->select($this->attributes);
        ! empty($where) && $this->db->where($where);
        ! empty($order) && $this->db->order_by($order);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->first_row($type);
    }

    /**
     * 列表查询
     * @param   Array
     * @param   Integer
     * @param   Integer
     * @param   String
     * @return  Mixed
     */
    public function get_list_where($where = array(), $offset = 0, $num = 10, $order = '', $type = 'object')
    {
        $this->db->select($this->list_attributes);
        ! empty($where) && $this->db->where($where);
        ! empty($order) && $this->db->order_by($order);
        $this->db->limit($num, $offset);
        $query = $this->db->get($this->table);
        return $query->result($type);
    }

    /**
     * 列表查询
     * @param   String
     * @param   Array
     * @param   Integer
     * @param   Integer
     * @param   String
     * @return  Mixed
     */
    public function get_where_in($field, $in = array(), $offset = 0, $num = 10, $order = '', $type = 'object')
    {
        $result = array();
        if (! empty($in))
        {
            $this->db->select($this->list_attributes);
            $this->db->where_in($field, $in);
            ! empty($order) && $this->db->order_by($order);
            $this->db->limit($num, $offset);
            $query = $this->db->get($this->table);
            $result = $query->result($type);
        }
        return $result;
    }

    /**
     * 列表查询
     * @param   Array
     * @param   String
     * @return  Mixed
     */
    public function get_all($where = array(), $order = '', $type = 'object')
    {
        $this->db->select($this->list_attributes);
        ! empty($where) && $this->db->where($where);
        ! empty($order) && $this->db->order_by($order);
        $query = $this->db->get($this->table);
        return $query->result($type);
    }

    /**
     * 选项输出
     * @param   Array
     * @param   String
     * @return  Array
     */
    public function get_option($where = array(), $order = '')
    {
        $result = array();
        if (! empty($this->option))
        {
            $this->db->select(implode(",", $this->option));
            ! empty($where) && $this->db->where($where);
            ! empty($order) && $this->db->order_by($order);
            $query = $this->db->get($this->table);
            if ($query->num_rows() > 0)
            {
                foreach($query->result_array() as $row)
                {
                    $result[$row[$this->option[0]]] = $row[$this->option[1]];
                }
            }
        }
        return $result;
    }

    /**
     * 验证输入
     * @param   String
     * @return  Boolean
     */
    public function validate($group = '')
    {
        if (count($_POST) == 0)
        {
            return FALSE;
        }

        $this->load->library('form_validation');
        if (! empty($group) && isset($this->rules[$group]))
        {
            $this->form_validation->set_rules($this->rules[$group]);
        }
        else
        {
            $this->form_validation->set_rules($this->rules);
        }

        return $this->form_validation->run();
    }

    /**
     * 插入数据
     * @param   Array
     * @return  Integer
     */
    public function insert($data)
    {
        if (! empty($data))
        {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }
        return FALSE;
    }

    /**
     * 批量插入目标结果集
     * @param   Array
     * @return  Boolean
     */
    public function insert_batch($data)
    {
        if (! empty($data))
        {
            return $this->db->insert_batch($this->table, $data);
        }
        return FALSE;
    }

    /**
     * 更新目标结果集
     * @param   Integer
     * @param   Array
     * @return  Boolean
     */
    public function update($primary_value, $data)
    {
        if (! empty($data))
        {
            $this->db->where($this->primary_key, $primary_value);
            return $this->db->update($this->table, $data);
        }
        return FALSE;
    }

    /**
     * 更新目标结果集
     * @param   Array
     * @param   Array
     * @return  Boolean
     */
    public function update_where($where, $data)
    {
        if (! empty($data))
        {
            $this->db->where($where);
            return $this->db->update($this->table, $data);
        }
        return FALSE;
    }

    /**
     * 更新目标结果集
     * @param   Array
     * @param   Array
     * @return  Boolean
     */
    public function update_where_in($field, $in, $data) {
        if (is_array($in) && ! empty($in))
        {
            $this->db->where_in($field, $in);
            return $this->db->update($this->table, $data);
        }
        return FALSE;
    }

    /**
     * 更新目标结果集
     * @param   Array
     * @return  Boolean
     */
    public function update_batch($data, $field)
    {
        if (! empty($data))
        {
            return $this->db->update_batch($this->table, $data, $field);
        }
        return FALSE;
    }

    /**
     * 删除目标结果集
     * @param   Integer
     * @return  Boolean
     */
    public function delete($primary_value)
    {
        if ($primary_value)
        {
            $this->db->where($this->primary_key, $primary_value);
            return $this->db->delete($this->table);
        }
        return FALSE;
    }

    /**
     * 删除目标结果集
     * @param   Array
     * @return  Boolean
     */
    public function delete_where($where)
    {
        if (! empty($where))
        {
            $this->db->where($where);
            return $this->db->delete($this->table);
        }
        return FALSE;
    }

    /**
     * 批量操作
     * @param   String
     * @param   Array
     * @return  Boolean
     */
    public function delete_where_in($field, $in)
    {
        if (! empty($in))
        {
            $this->db->where_in($field, $in);
            return $this->db->delete($this->table);
        }
        return FALSE;
    }

    /**
     * 替换目标结果集
     * @param   Array
     * @return  Boolean
     */
    public function replace($data)
    {
        if (! empty($data))
        {
            return $this->db->replace($this->table, $data);
        }
        return FALSE;
    }

    /**
     * 列表查询，配合list_result, set_where，set_like, set_order子句，获取结果集，用于列表查询，获取Query_url。
     */
    public function select_list($list_attributes = '')
    {
        if (empty($list_attributes))
        {
            $this->db->select($this->list_attributes);
        }
        else
        {
            $this->db->select($list_attributes);
        }
    }

    /**
     * 列表查询，匹配set_where，set_like, set_order子句，获取Query_url。
     * @param   Integer
     * @param   Integer
     * @return  Mixed
     */
    public function list_result($cur_page = 0, $per_page = 20, $type = 'object')
    {
        $this->cur_page = $cur_page;
        $this->per_page = $per_page;
        $offset = $cur_page ? $per_page * ($cur_page - 1) : 0;
        //加载where子句
        $this->db->select($this->list_attributes);
        $this->load_join();
        $this->load_where();
        $this->load_query();
        $this->load_order();
        $this->db->limit($per_page, $offset);
        $query = $this->db->get($this->table);
        return $query->result($type);
    }

    /**
     * 匹配set_where，set_like子句，更新查询结果。
     * @return  Mixed
     */
    public function update_result($data)
    {
        //加载where子句
        $this->load_where();
        $this->load_query();
        return $this->db->update($this->table, $data);
    }

    /**
     * 匹配set_where，set_like子句，删除查询结果。
     * @return  Mixed
     */
    public function delete_result()
    {
        //加载where子句
        $this->load_where();
        $this->load_query();
        return $this->db->delete($this->table);
    }

    /**
     * 列表查询，匹配set_where，set_like, 获取Query_url。
     * @param   Integer
     * @param   Integer
     * @return  Mixed
     */
    public function total()
    {
        //加载where子句
        $this->load_join();
        $this->load_where();
        $this->load_query();
        $this->total = $this->db->count_all_results($this->table);
        return $this->total;
    }

    /**
     * 查询统计
     * @param   Array
     * @return  Integer
     */
    public function count_where($where = array())
    {
        $this->db->where($where);
        $this->total = $this->db->count_all_results($this->table);
        return $this->total;
    }

    /**
     * 设置Where子句
     * @param   String
     * @param   Mixed
     * @param   String
     * @param   String
     */
    public function set_where($field, $value, $statement = 'where', $operator = '', $condition = TRUE)
    {
        if ($condition)
        {
            $this->set_condition($field, $value);
        }

        if ($value !== FALSE && $value !== NULL && $value !== "")
        {
            $this->where[] = array('field' => $field, 'value' => $value, 'statement' => $statement, 'operator' => $operator);
        }
    }

    /**
     * 设置Like子句
     * @param   String
     * @param   Mixed
     * @param   String
     * @param   String
     */
    public function set_like($field, $match, $statement = 'like', $operator = 'both', $condition = TRUE)
    {
        if ($condition)
        {
            $this->set_condition($field, $match);
        }

        if ($match !== FALSE && $match !== NULL && $match !== "")
        {
            $this->where[] = array('field' => $field, 'match' => $match, 'statement' => $statement, 'operator' => $operator);
        }
    }

    /**
     * 自定义字符串设置Where查询条件
     * @param   String
     */
    public function set_query($query)
    {
        if (! empty($query))
        {
            $this->query[] = $query;
        }
    }

    /**
     * 加载条件
     */
    public function join($table, $condition, $manner = 'inner')
    {
        $this->join[] = array(
            'table' => $table,
            'condition' => $condition,
            'manner' => $manner
        );
    }

    /**
     * 加载条件
     */
    public function load_join()
    {
        if (! empty($this->join))
        {
            foreach ($this->join as $join)
            {
                $this->db->join($join['table'], $join['condition'], $join['manner']);
            }
        }
    }

    /**
     * 加载条件
     */
    public function load_where()
    {
        if (! empty($this->where))
        {
            foreach ($this->where as $item)
            {
                switch ($item['statement'])
                {
                    case 'where':
                        $field = empty($item['operator']) ? $item['field'] : $item['field'].' '.$item['operator'];
                        $this->db->where($field, $item['value']);
                        break;

                    case 'or_where':
                        $field = empty($item['operator']) ? $item['field'] : $item['field'].' '.$item['operator'];
                        $this->db->or_where($field, $item['value']);
                        break;

                    case 'where_in':
                        $this->db->where_in($item['field'], $item['value']);
                        break;

                    case 'or_where_in':
                        $this->db->or_where_in($item['field'], $item['value']);
                        break;

                    case 'where_not_in':
                        $this->db->where_not_in($item['field'], $item['value']);
                        break;

                    case 'or_where_not_in':
                        $this->db->or_where_not_in($item['field'], $item['value']);
                        break;

                    case 'like':
                        $this->db->like($item['field'], $item['match'], $item['operator']);
                        break;

                    case 'or_like':
                        $this->db->or_like($item['field'], $item['match'], $item['operator']);
                        break;

                    case 'not_like':
                        $this->db->not_like($item['field'], $item['match'], $item['operator']);
                        break;

                    case 'or_not_like':
                        $this->db->or_not_like($item['field'], $item['match'], $item['operator']);
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }
        return;
    }

    /**
     * 加载条件
     */
    public function load_query()
    {
        if (! empty($this->query))
        {
            foreach ($this->query as $query)
            {
                $this->db->where($query);
            }
        }
    }

    /**
     * 设置查询条件
     * @param   String
     * @param   Mixed
     */
    public function set_condition($field, $value)
    {
        $this->condition[$field] = $value;
    }

    /**
     * 返回查询条件
     * @return  String
     */
    public function get_condition()
    {
        return $this->condition;
    }

    /**
     * 设置排序
     * @param   String
     */
    public function set_order($order, $default = '')
    {
        if (! empty($order))
        {
            $order = explode('-', $order);
            $this->order = array('field' => $order[0], 'sort' => $order[1]);
        }
        elseif (! empty($default))
        {
            $default = explode('-', $default);
            $this->order = array('field' => $default[0], 'sort' => $default[1]);
        }
        return;
    }

    /**
     * 加载排序
     * @return  String
     */
    public function load_order()
    {
        if (! empty($this->order))
        {
            $this->db->order_by($this->order['field'] .' '. $this->order['sort']);
        }
        return;
    }

    /**
     * 分页
     * @param   String
     * @return  Mixed
     */
    public function paging($base_url, $uri_segment = 3)
    {

        $this->config->load('pagination');
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url($base_url);
        $config['total_rows'] = $this->total();
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $uri_segment;

        $suffix = $this->get_query_url();
        if (!empty($suffix))
        {
            $config['suffix'] = $suffix;
            $config['first_url'] = $config['base_url'].$suffix;
        }

        $this->load->library('pagination', $config);
        if ($this->cur_page > $this->pagination->cur_page)
        {
            redirect($base_url.'/'.$this->pagination->cur_page.$suffix, 'location');
        }
        return $this->pagination;
    }

    /**
     * 返回查询参数
     * @return  String
     */
    public function get_query_url() {
        //查询条件
        if (! empty($this->condition))
        {
            foreach ($this->condition as $k => $v)
            {
                if (! empty($v))
                {
                    $this->query_url .= empty($this->query_url) ? $k.'='.$v : '&'.$k.'='.$v;
                }
            }
        }
        //排序
        if (! empty($this->order))
        {
            $order = 'order='. $this->order['field'] .'-'. $this->order['sort'];
            $this->query_url .= empty($this->query_url) ? $order : '&'. $order;
        }
        //链接条件
        if (! empty($this->query_url))
        {
            $this->query_url = '?'.$this->query_url;
        }

        return $this->query_url;
    }

    public function last_query()
    {
        return $this->db->last_query();
    }
}

/* End of file QD_Model.php */
/* Location: ./application/core/QD_Model.php */