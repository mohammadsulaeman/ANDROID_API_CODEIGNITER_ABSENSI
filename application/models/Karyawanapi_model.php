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
    
    public function update($dataupdate,$condition){
        $reset = $this->db->update('tbl_karyawan',$dataupdate,$condition);
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

    public function get_data_karyawan_nik($condition)
    {
        $this->db->select('tbl_karyawan.*');
        $this->db->from('tbl_karyawan');
        $this->db->where($condition);
        return $this->db->get();
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
}
