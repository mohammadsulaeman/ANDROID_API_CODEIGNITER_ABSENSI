<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supportapi_model extends CI_model
{
    public function support_karyawan()
    {
        $this->db->select('nama,alamat,phone,email,pendidikan,instansi,deskripsi,photo,github,portofolio');
        return $this->db->get('tbl_support')->result_array();
    }
}
