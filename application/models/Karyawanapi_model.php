<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Karyawanapi_model extends CI_model
{
    public function check_banned($phone)
    {
        $stat =  $this->db->query("SELECT karyawan_id FROM tbl_karyawan WHERE karyawan_phone='$phone'");
        if ($stat->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_exist($email, $phone)
    {
        $cek = $this->db->query("SELECT karyawan_id FROM tbl_karyawan where karyawan_email = '$email' AND karyawan_phone='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_exist_phone($phone)
    {
        $cek = $this->db->query("SELECT karyawan_id FROM tbl_karyawan where karyawan_phone='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_exist_email($email)
    {
        $cek = $this->db->query("SELECT karyawan_id FROM tbl_karyawan where karyawan_email='$email'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    

    public function get_data_karyawan($condition)
    {
        $this->db->select('tbl_karyawan.*');
        $this->db->from('tbl_karyawan');
        $this->db->where($condition);
        return $this->db->get();
    }
    public function edit_profile_token($data, $phone)
    {
        $this->db->where('karyawan_phone', $phone);
        $this->db->update('tbl_karyawan', $data);
        return true;
    }
    
    public function update($forgot){
        $reset = $this->db->update('tbl_karyawan',$forgot);
        return $reset;
    }
     public function editbiodata($editdata)
    {
        $dataedit = $this->db->update('tbl_karyawan', $editdata);
        return $dataedit;
    }
    public function signup($data_karyawan)
    {
        
        $signup = $this->db->insert('tbl_karyawan', $data_karyawan);
        return $signup;
    }

    public function kategori_merchant_active_data($idfitur)
    {
        $this->db->select('karyawan_nama,karyawan_id');
        $this->db->where('karyawan_id', $idfitur);
        return $this->db->get('tbl_karyawan')->result_array();
    }

    
}
