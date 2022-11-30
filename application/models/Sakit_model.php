<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sakit_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listing()
    {
        $this->db->select('tbl_sakit.*,
						   COUNT(tbl_sakit.sakit_bukti) AS total_gambar
						   ');
        $this->db->from('tbl_sakit');



        $this->db->group_by('tbl_sakit.sakit_id');
        $this->db->order_by('sakit_id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_product_keyword($keyword)
    {
        $this->db->select('*');
        $this->db->from('tbl_sakit');
        $this->db->like('sakit_nama', $keyword);
        return $this->db->get()->result();
    }
    
     public function detail($id_sakit)
    {
        $this->db->select('*');
        $this->db->from('tbl_sakit');
        $this->db->where('sakit_id', $id_sakit);
        $this->db->order_by('sakit_id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }



    public function add($data)
    {
        $this->db->insert('tbl_sakit', $data);
    }


    public function edit($data)
    {
        $this->db->where('sakit_id', $data['sakit_id']);
        $this->db->update('tbl_sakit', $data);
    }

    public function delete($data)
    {
        $this->db->where('sakit_id', $data['sakit_id']);
        $this->db->delete('tbl_sakit', $data);
    }

    public function view()
    {
        return $this->db->get('tbl_sakit')->result(); // Tampilkan semua data yang ada di tabel hadir
    }
}
