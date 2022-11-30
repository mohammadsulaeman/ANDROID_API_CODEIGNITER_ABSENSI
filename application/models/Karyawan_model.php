<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listing()
    {
        $this->db->select('tbl_karyawan.*,
						   COUNT(tbl_karyawan.karyawan_photo) AS total_gambar
						   ');
        $this->db->from('tbl_karyawan');

       

        $this->db->group_by('tbl_karyawan.karyawan_id');
        $this->db->order_by('karyawan_id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_product_keyword($keyword)
    {
        $this->db->select('*');
        $this->db->from('tbl_karyawan');
        $this->db->like('karyawan_name', $keyword);
        return $this->db->get()->result();
    }
    
    public function detail($id_karyawan)
    {
        $this->db->select('*');
        $this->db->from('tbl_karyawan');
        $this->db->where('karyawan_id', $id_karyawan);
        $this->db->order_by('karyawan_id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }


    public function add($data)
    {
        $this->db->insert('tbl_karyawan', $data);
    }


    public function edit($data)
    {
        $this->db->where('karyawan_id', $data['karyawan_id']);
        $this->db->update('tbl_karyawan', $data);
    }

    public function delete($data)
    {
        $this->db->where('karyawan_id', $data['karyawan_id']);
        $this->db->delete('tbl_karyawan', $data);
    }

    public function view()
    {
        return $this->db->get('tbl_karyawan')->result(); // Tampilkan semua data yang ada di tabel hadir
    }
}
