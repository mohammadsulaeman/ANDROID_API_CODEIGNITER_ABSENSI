<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listing()
    {
        $this->db->select('tbl_user_role.*
						   ');
        $this->db->from('tbl_user_role');
        $this->db->group_by('tbl_user_role.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function detail($id_menu)
    {
        $this->db->select('*');
        $this->db->from('tbl_user_role');
        $this->db->where('id', $id_menu);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('tbl_user_role', $data);
    }

    public function add($data)
    {
        $this->db->insert('tbl_user_role', $data);
    }
    public function edit($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_user_role', $data);
    }
}
