<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $CI = & get_instance();
        $currentUser = $CI->session->userdata("currentUser");
        $currentUser['loggedIn'] = $CI->session->userdata("loggedIn");
        if ($currentUser['loggedIn'] == TRUE) {
            redirect(base_url('Profile/timeline'));
        }
        else {
            return TRUE;
        }
    }

    public function index() {

        $data['first_name'] = '';
        $data['last_name'] = '';
        $data['user_email'] = '';
        $data['password'] = '';
        $data['passconf'] = '';
		$data['check_login'] = 1;
        render_view('login', $data, $header = array('loginPage' => TRUE));
    }

}
