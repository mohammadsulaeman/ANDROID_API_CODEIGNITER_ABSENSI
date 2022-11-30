<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perizinan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listing()
    {
        $this->db->select('tbl_perijinan.*,
						   COUNT(tbl_perijinan.perijinan_bukti) AS total_gambar
						   ');
        $this->db->from('tbl_perijinan');



        $this->db->group_by('tbl_perijinan.perijinan_id');
        $this->db->order_by('perijinan_id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_product_keyword($keyword)
    {
        $this->db->select('*');
        $this->db->from('tbl_perijinan');
        $this->db->like('perijinan_nama', $keyword);
        return $this->db->get()->result();
    }
    
    public function detail($id_perijinan)
    {
        $this->db->select('*');
        $this->db->from('tbl_perijinan');
        $this->db->where('perijinan_id', $id_perijinan);
        $this->db->order_by('perijinan_id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }



    public function add($data)
    {
        $this->db->insert('tbl_perijinan', $data);
    }


    public function edit($data)
    {
        $this->db->where('perijinan_id', $data['perijinan_id']);
        $this->db->update('tbl_perijinan', $data);
    }

    public function delete($data)
    {
        $this->db->where('perijinan_id', $data['perijinan_id']);
        $this->db->delete('tbl_perijinan', $data);
    }

    public function view()
    {
        return $this->db->get('tbl_perijinan')->result(); // Tampilkan semua data yang ada di tabel hadir
    }
}
