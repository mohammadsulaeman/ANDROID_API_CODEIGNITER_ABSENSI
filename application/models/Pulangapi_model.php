<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pulangapi_model extends CI_model
{

    public function signup($data_pulang)
    {
        
        $signup = $this->db->insert('tbl_pulang', $data_pulang);
        return $signup;
    }

    public function pulang_karyawan()
    {
                $this->db->select('pulang_id,pulang_nama,pulang_bukti,pulang_lokasi,pulang_waktu,pulang_tanggal,pulang_status');
                return $this->db->get('tbl_pulang')->result_array();
    }
    
     public function get_product_keyword($keyword,$phone)
    {
        $this->db->select('*');
        $this->db->from('tbl_pulang');
        $this->db->where('pulang_phone', $phone);
        $this->db->like('pulang_tanggal', $keyword);
        return $this->db->get()->result();
    }
    
}
