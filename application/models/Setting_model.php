<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Listing
    public function listing()
    {
        $query = $this->db->get('tbl_setting');
        return $query->row();
    }

    //Edit
    public function edit($data)
    {
        $this->db->where('id_setting', $data['id_setting']);
        $this->db->update('tbl_setting', $data);
    }

    
}
