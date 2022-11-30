<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public function getSubMenu()
    {
        $query = "SELECT tbl_user_sub_menu.*,tbl_user_menu.menu
                FROM tbl_user_sub_menu JOIN tbl_user_menu
                ON tbl_user_sub_menu.menu_id = tbl_user_menu.id
        ";

        return $this->db->query($query)->result_array();
    }

    public function listing()
    {
        $this->db->select('*
						   ');
        $this->db->from('tbl_user_menu');
        $this->db->group_by('tbl_user_menu.id');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function detail($id_menu)
    {
        $this->db->select('*');
        $this->db->from('tbl_user_menu');
        $this->db->where('id', $id_menu);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function delete($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('tbl_user_menu', $data);
    }

    public function add($data)
    {
        $this->db->insert('tbl_user_menu', $data);
    }
    public function edit($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_user_menu', $data);
    }
    //edit dan delte submenu

    public function detailsubMenu($id_submenu)
    {
        $this->db->select('*');
        $this->db->from('tbl_user_sub_menu');
        $this->db->where('id', $id_submenu);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function deletesubMenu($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->delete('tbl_user_sub_menu', $data);
    }

    public function editsubMenu($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_user_sub_menu', $data);
    }

    public function addsubmenu($data)
    {
        $this->db->insert('tbl_user_sub_menu', $data);
    }
}
