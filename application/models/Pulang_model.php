<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pulang_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listing()
    {
        $this->db->select('tbl_pulang.*,
						   COUNT(tbl_pulang.pulang_bukti) AS total_gambar
						   ');
        $this->db->from('tbl_pulang');



        $this->db->group_by('tbl_pulang.pulang_id');
        $this->db->order_by('pulang_id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_product_keyword($keyword)
    {
        $this->db->select('*');
        $this->db->from('tbl_pulang');
        $this->db->like('pulang_nama', $keyword);
        return $this->db->get()->result();
    }
    
      public function detail($id_pulang)
    {
        $this->db->select('*');
        $this->db->from('tbl_pulang');
        $this->db->where('pulang_id', $id_pulang);
        $this->db->order_by('pulang_id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }



    public function add($data)
    {
        $this->db->insert('tbl_pulang', $data);
    }


    public function edit($data)
    {
        $this->db->where('pulang_id', $data['pulang_id']);
        $this->db->update('tbl_pulang', $data);
    }

    public function delete($data)
    {
        $this->db->where('pulang_id', $data['pulang_id']);
        $this->db->delete('tbl_pulang', $data);
    }

    public function view()
    {
        return $this->db->get('tbl_pulang')->result(); // Tampilkan semua data yang ada di tabel hadir
    }
}
