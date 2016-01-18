<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice {

    public $notice = array(
        'result' => 'succeed',
        'title' => '执行成功',
        'location' => ''
    );

    public function send($notice, $result) {
        $this->notice['result'] = $result;
        if (is_array($notice)) {
            $this->notice = array_merge($this->notice, $notice);
        } else {
            $this->notice['title'] = $notice;
        }
        return $this->notice;
    }

    public function succeed($notice = array()) {
        $this->notice['result'] = 'succeed';
        $this->notice = array_merge($this->notice, $notice);
        $this->setNotice($this->notice);
        if (! empty($this->notice['location'])) {
            redirect($this->notice['location'], 'location');
        }
    }

    public function error($notice = array()) {
        $this->notice['result'] = 'error';
        $this->notice = array_merge($this->notice, $notice);
        $this->setNotice($this->notice);
        if (! empty($this->notice['location'])) {
            redirect($this->notice['location'], 'location');
        }
    }

    public function warning($notice = array()) {
        $this->notice['result'] = 'warning';
        $this->notice = array_merge($this->notice, $notice);
        $this->setNotice($this->notice);
        if (! empty($this->notice['location'])) {
            redirect($this->notice['location'], 'location');
        }
    }

    public function confirm($title = '') {
        $this->notice['result'] = 'confirm';
        $this->notice = array_merge($this->notice, $notice);
        $this->setNotice($this->notice);
        if (! empty($this->notice['location'])) {
            redirect($this->notice['location'], 'location');
        }
    }

    public function setNotice($data){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->session->set_flashdata('notice', $data);
    }

    public function getNotice(){
        $CI =& get_instance();
        $CI->load->library('session');
        return $CI->session->flashdata('notice');
    }
}

/* End of file notice.php */
/* Location: ./application/libraries/notice.php */