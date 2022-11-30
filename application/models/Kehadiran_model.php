<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kehadiran_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listing()
    {
        $this->db->select('tbl_hadir.*,
						   COUNT(tbl_hadir.hadir_photo) AS total_gambar
						   ');
        $this->db->from('tbl_hadir');

      

        $this->db->group_by('tbl_hadir.hadir_id');
        $this->db->order_by('hadir_id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
  
    public function get_product_keyword($keyword)
    {
        $this->db->select('*');
        $this->db->from('tbl_hadir');
        $this->db->like('hadir_nama', $keyword);
        return $this->db->get()->result();
    }
    
    public function detail($id_kehadiran)
    {
        $this->db->select('*');
        $this->db->from('tbl_hadir');
        $this->db->where('hadir_id', $id_kehadiran);
        $this->db->order_by('hadir_id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    

    public function add($data)
    {
        $this->db->insert('tbl_hadir', $data);
    }


    public function edit($data)
    {
        $this->db->where('hadir_id', $data['hadir_id']);
        $this->db->update('tbl_hadir', $data);
    }

    public function delete($data)
    {
        $this->db->where('hadir_id', $data['hadir_id']);
        $this->db->delete('tbl_hadir', $data);
    }
    
    public function view()
    {
        return $this->db->get('tbl_hadir')->result(); // Tampilkan semua data yang ada di tabel hadir
    }
}
