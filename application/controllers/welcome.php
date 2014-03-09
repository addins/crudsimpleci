<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        $viewbag['view_page'] = 'welcome_message';
        $viewbag['view_model'] = 'data';
        $viewbag['title'] = 'Welcome to CodeIgniter!';
        $this->load->view('template/mainview', $viewbag);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */