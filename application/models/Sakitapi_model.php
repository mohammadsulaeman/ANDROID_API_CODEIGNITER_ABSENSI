<?php

defined('BASEPATH') or exit('No direct script access allowed');

class sakitapi_model extends CI_model
{

    public function signup($data_sakit)
    {
        
        $signup = $this->db->insert('tbl_sakit', $data_sakit);
        return $signup;
    }
    
    public function sakit_karyawan()
    {
                $this->db->select('sakit_id,sakit_nama,sakit_keterangan,sakit_bukti,sakit_lokasi,sakit_waktu,sakit_tanggal,sakit_status');
                return $this->db->get('tbl_sakit')->result_array();
    }
    
     public function get_product_keyword($keyword,$phone)
    {
        $this->db->select('*');
        $this->db->from('tbl_sakit');
        $this->db->where('sakit_phone', $phone);
        $this->db->like('sakit_tanggal', $keyword);
        return $this->db->get()->result();
    }
    
}
