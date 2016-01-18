<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QD_Pagination extends CI_Pagination {

    public $links = '';
    public $query = '';

    public function __construct($config)
    {
        parent::__construct();
        $CI =& get_instance();
        $CI->config->load('pagination');
        $config = $CI->config->item('pagination') + $config;
        $this->initialize($config);
        $this->links = $this->create_links();
        $this->query = $this->suffix;
    }

    public function links()
    {
        return $this->links;
    }

    public function tinylinks()
    {
        if (empty($this->links)) {
            return '';
        }
        $num_pages = ceil($this->total_rows / $this->per_page);
        if ($this->cur_page == 1) {
            $next = 2;
            return '<a class="disabled" href="#">&lt;</a><a href="'.$this->base_url.$this->prefix.'/'.$next.$this->suffix.'">&gt;</a>';
        } elseif ($this->cur_page > 1 && $this->cur_page < $num_pages) {
            $prev = $this->cur_page - 1;
            if ($prev == 1) $prev = '';
            $next = $this->cur_page + 1;
            return '<a href="'.$this->base_url.$this->prefix.'/'.$prev.$this->suffix.'">&lt;</a><a href="'.$this->base_url.$this->prefix.'/'.$next.$this->suffix.'">&gt;</a>';
        } elseif ($this->cur_page == $num_pages) {
            $prev = $num_pages - 1;
            if ($prev == 1) $prev = '';
            return '<a href="'.$this->base_url.$this->prefix.'/'.$prev.$this->suffix.'">&lt;</a><a class="disabled" href="#">&gt;</a>';
        }
    }
}