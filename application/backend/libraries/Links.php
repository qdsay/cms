<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links {

    public $query_url = '';
    public $sort = '';
    
    public function get_query($where, $order = '') {
        $this->query_url = '';
        if (!empty($where)) {
            foreach ($where as $k => $v) {
                $this->query_url .= empty($this->query_url)?$k.'='.$v:'&'.$k.'='.$v;
            }
        }

        if (!empty($order)) 
            $this->query_url .= empty($this->query_url)?'sort='.$order:'&sort='.$order;

        if (!empty($this->query_url)) 
            $this->query_url = '?'.$this->query_url;

        return $this->query_url;
    }

    public function set_query($query_url, $field)
    {
        if (! empty($query_url)) {
            $sort = array('asc'=>'desc', 'desc'=>'asc');
            preg_match_all("/^\?.*sort=([a-z]+)_(asc|desc){1}$/", $query_url, $match);
            if (! empty($match[1]) && ! empty($match[1])) {
                $this->sort = $match[2][0];
                return preg_replace("/sort=".$match[1][0]."_".$match[2][0]."$/", "sort=".$field."_".$sort[$match[2][0]], $query_url);
            } else {
                return $query_url .= "&sort=".$field."_desc";
            }
        } else {
            return $query_url .= "?sort=".$field."_desc";
        }
    }

    public function get_sort()
    {
        return empty($this->sort)?'':' '.$this->sort;
    }
}

/* End of file links.php */
/* Location: ./application/libraries/links.php */