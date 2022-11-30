<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Newsapi_model extends CI_model
{

    public function signup($data_news)
    {
        $datasignup = array(
            'news_id' => $data_news['news_id'],
            'news_nama' => $data_news['news_nama'],
            'news_kategori' => $data_news['news_kategori'],
            'news_photo' => $data_news['news_photo'],
            'news_create' => $data_news['news_create'],
            'news_tanggal' => $data_news['news_tanggal'],
            'news_status' => $data_news['news_status']
        );
        $signup = $this->db->insert('tbl_news', $datasignup);
        return $signup;
    }

    public function news_karyawan()
    {
            $this->db->select('judul_news,deskripsi,gambar');
            $this->db->where('status_news !=0');
            $this->db->limit('4');
            return $this->db->get('tbl_news')->result_array();
    }

    
}
