<?php
defined('BASEPATH') or exit('No direct script access allowed');

class news extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
        date_default_timezone_set(time_zone);
    }

    public function index()
    {

        $news = $this->news_model->listing();
        $data = array(
            'title' => 'news',
            'news'     => $news,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'berita/news/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function add()
    {
        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'judul_news',
            'Judul News',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            $config['upload_path']       = 'images/news/';
            $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
            $config['max_size']          = '1024000'; // dalam KB
            $config['max_width']         = '2048'; // dalam pixel
            $config['max_height']        = '2048';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {

                // End validasi

                $data = array(
                    'title'         => 'Add News',
                    'error'         =>  $this->upload->display_errors(),
                    'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                    'isi'           => 'berita/news/add'
                );
                $this->load->view('template/wrapper', $data, FALSE);
                // Masuk database
            } else {
                $upload_gambar = array('upload_data' => $this->upload->data());

                // create thumbnail gambar
                $config['image_library']     = 'gd2';
                $config['source_image']     = 'images/news/' . $upload_gambar['upload_data']['file_name'];
                //Lokasi folder thumbnail
                $config['new_image']        = 'images/news/thumbs/';
                $config['create_thumb']     = TRUE;
                $config['maintain_ratio']     = TRUE;
                $config['width']             = 250;
                $config['height']           = 250;
                $config['thumb_marker']     = '';

                $this->load->library('image_lib', $config);

                $this->image_lib->resize();
                // end create thumbnail
                $i = $this->input;
                // Slug news
                $slug_news = url_title($this->input->post('judul_news'), 'dash', TRUE);
                $data = array(
                    'id_news'       => $this->session->userdata('id_news'),
                    'judul_news'    => $i->post('judul_news'),
                    'slug_news'     => $slug_news,
                    'deskripsi'     => $i->post('deskripsi'),
                    //Disimpan nama file gambar
                    'gambar'        => $upload_gambar['upload_data']['file_name'],
                    'status_news'   => $i->post('status_news'),
                    'tanggal_post'  => date('Y-m-d H:i:s')
                );
                $this->news_model->add($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah ditambah</div>');
                redirect(base_url('News'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Add News',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'berita/news/add'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function edit($id_news)
    {
        // Ambil data news yg akan diedit
        $news     = $this->news_model->detail($id_news);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'judul_news',
            'Judul News',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['gambar']['name'])) {

                $config['upload_path']         = 'images/news/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
                $config['max_size']          = '1024000'; // dalam KB
                $config['max_width']         = '2048'; // dalam pixel
                $config['max_height']          = '2048';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gambar')) {

                    // End validasi

                    $data = array(
                        'title'     => 'Edit News',
                        'news'      =>  $news,
                        'error'     =>  $this->upload->display_errors(),
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'isi'       => 'berita/news/edit'
                    );
                    $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());

                    // create thumbnail gambar
                    $config['image_library']     = 'gd2';
                    $config['source_image']     = 'images/news/' . $upload_gambar['upload_data']['file_name'];
                    //Lokasi folder thumbnail
                    $config['new_image']        = 'images/news/thumbs/';
                    $config['create_thumb']     = TRUE;
                    $config['maintain_ratio']     = TRUE;
                    $config['width']             = 250;
                    $config['height']           = 250;
                    $config['thumb_marker']     = '';

                    $this->load->library('image_lib', $config);

                    $this->image_lib->resize();
                    // end create thumbnail
                    $i = $this->input;
                    // Slug news
                    $slug_news = url_title($this->input->post('judul_news'), 'dash', TRUE);
                    $data = array(
                        'id_news'       => $id_news,
                        'judul_news'    => $i->post('judul_news'),
                        'slug_news'     => $slug_news,
                        'deskripsi'     => $i->post('deskripsi'),
                        //Disimpan nama file gambar
                        'gambar'         => $upload_gambar['upload_data']['file_name'],
                        'status_news'     => $i->post('status_news')
                    );
                    $this->news_model->edit($data);
                    $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                    redirect(base_url('News'), 'refresh');
                }
            } else {
                //Edit news tanpa ganti gambar
                $i = $this->input;
                // Slug news
                $slug_news = url_title($this->input->post('judul_news'), 'dash', TRUE);
                $data = array(
                    'id_news'      => $id_news,
                    'judul_news'   => $i->post('judul_news'),
                    'slug_news'    => $slug_news,
                    'deskripsi'    => $i->post('deskripsi'),
                    //Disimpan nama file gambar (gambar tdk diganti)
                    //'gambar' 		=> $upload_gambar['upload_data']['file_name'],
                    'status_news'  => $i->post('status_news')
                );
                $this->news_model->edit($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                redirect(base_url('News'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Edit News',
            'news'        =>  $news,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'berita/news/edit'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_news)
    {
        // Proses hapus gambar
        $news = $this->news_model->detail($id_news);
        unlink('images/news/' . $news->gambar);
        unlink('images/news/thumbs/' . $news->gambar);
        // End proses hapus 
        $data = array('id_news' => $id_news);
        $this->news_model->delete($data);
        $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah dihapus</div>');
        redirect(base_url('News'), 'refresh');
    }

    public function searchdata()
    {
        $keyword = $this->input->post('keyword');
        $news = $this->news_model->get_product_keyword($keyword);
        $data = array(
            'title' => 'news',
            'news'     => $news,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'berita/news/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
