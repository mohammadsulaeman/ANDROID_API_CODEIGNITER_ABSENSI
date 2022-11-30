<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Support extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }
    public function index()
    {
        $support = $this->db->get('tbl_support')->row_array();
        $data = array(
            'title' => 'Support System',
            'support'     => $support,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'support/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
