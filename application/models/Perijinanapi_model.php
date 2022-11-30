<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perijinanapi_model extends CI_model
{

    public function signup($data_Perijinan)
    {

        $signup = $this->db->insert('tbl_perijinan', $data_Perijinan);
        return $signup;
    }

    public function perijinan_karyawan()
    {
        $this->db->select("perijinan_id,perijinan_nama,perijinan_keterangan,perijinan_status,perijinan_tanggal,perijinan_waktu,perijinan_lokasi,perijinan_bukti,reponse_kepala,nama_kepala");
        return $this->db->get('tbl_perijinan')->result_array();
    }
    
     public function get_product_keyword($keyword,$phone)
    {
        $this->db->select('*');
        $this->db->from('tbl_perijinan');
        $this->db->where('perijinan_phone', $phone);
        $this->db->like('perijinan_tanggal', $keyword);
        return $this->db->get()->result();
    }
}
