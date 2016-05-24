<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_sdk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('twitter');
    }
    /**
     * Shows a form to post to Twitter
     * @return [type] [description]
     */
    public function index()
    {
        $this->load->view('test');
    }

    public function get_url()
    {
        echo json_encode( array('url' => $this->twitter->oauthUrl() ) );
    }

    public function post_it() {
        $this->twitter->status = trim($this->input->post('status'));
        $response = $this->twitter->post();
        echo $response;
    }

    public function twitter_response()
    {
        if ($this->input->get('denied') != '') {
            echo '<script>window.close();</script>';
        }
        if ($this->input->get('oauth_token') != '') {
            $this->twitter->getAccessToken($this->input->get('oauth_verifier'));
            echo json_encode($this->input->get());
        }
    }
}
