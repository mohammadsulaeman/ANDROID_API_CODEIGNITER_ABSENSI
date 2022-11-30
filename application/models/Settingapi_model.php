<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settingapi_model extends CI_model
{
    public function setting_karyawan()
    {
        $this->db->select('tagline,email,telepon,alamat,deskripsi');
        return $this->db->get('tbl_setting')->result_array();
    }
}
