<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kehadiranapi_model extends CI_model
{

        public function signup($data_kehadiran)
        {
            $signup = $this->db->insert('tbl_hadir',$data_kehadiran);
            return $signup;
        }

        public function hadir_karyawan()
        {
                $this->db->select('hadir_id,hadir_nama,hadir_lokasi,hadir_waktu,hadir_tanggal,hadir_photo,hadir_status,hadir_latitude,hadir_longitude');
                return $this->db->get('tbl_hadir')->result_array();
        }
        
        public function get_product_keyword($keyword,$phone)
    {
        $this->db->select('*');
        $this->db->from('tbl_hadir');
        $this->db->where('hadir_phone', $phone);
        $this->db->like('hadir_tanggal', $keyword);
        return $this->db->get()->result();
    }
}
