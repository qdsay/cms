<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QD_Output extends CI_Output {

    public function __construct()
    {
        parent::__construct();
    }

    public function display($data, $mimetype = 'json'){
        switch ($mimetype) {
            case 'json':
                $data = json_encode($data);
                break;

            case 'xml':
                # code...
                break;
            
            default:
                # code...
                break;
        }
        $this->set_content_type($mimetype)
             ->set_output($data)
             ->_display();
        exit();
    }

    public function error($message) {
        show_error($message);
    }
}

/* End of file qd.php */
/* Location: ./application/controllers/qd.php */