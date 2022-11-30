<?php

class Users_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listing()
    {
        $this->db->select('tbl_user.*
						   ');
        $this->db->from('tbl_user');
        $this->db->where('role_id !=',1);
        $this->db->group_by('tbl_user.id');
        $query = $this->db->get();
        return $query->result();
    }

    // Tambah kategori
    public function add($data)
    {
        $this->db->insert('tbl_user', $data);
    }

    public function detail($id_users)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('id', $id_users);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('tbl_user', $data);
    }

    public function edit($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_user', $data);
    }
}
