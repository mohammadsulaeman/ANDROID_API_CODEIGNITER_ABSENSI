<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listing()
    {
        $this->db->select('tbl_news.*
						   ');
        $this->db->from('tbl_news');
        $this->db->group_by('tbl_news.id_news');
        $this->db->order_by('id_news', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function detail($id_news)
    {
        $this->db->select('*');
        $this->db->from('tbl_news');
        $this->db->where('id_news', $id_news);
        $this->db->order_by('id_news', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function add($data)
    {
        $this->db->insert('tbl_news', $data);
    }

    public function edit($data)
    {
        $this->db->where('id_news', $data['id_news']);
        $this->db->update('tbl_news', $data);
    }

    public function delete($data)
    {
        $this->db->where('id_news', $data['id_news']);
        $this->db->delete('tbl_news', $data);
    }

    public function get_product_keyword($keyword)
    {
        $this->db->select('*');
        $this->db->from('tbl_news');
        $this->db->like('judul_news', $keyword);
        return $this->db->get()->result();
    }
}
