<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');
    }

    public function index()
    {
        $setting = $this->setting_model->listing();

        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'namaweb',
            'Nama website',
            'required',
            array('required'    => '%s harus diisi')
        );


        if ($valid->run() === FALSE) {
            // End validasi

            $data = array(
                'title'      => 'Setting Website',
                'setting'    => $setting,
                'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                'isi'        => 'setting/list'
            );
            $this->load->view('template/wrapper', $data, FALSE);
            // Masuk database
        } else {
            $i = $this->input;
            $data = array(
                'id_setting'         => $setting->id_setting,
                'namaweb'            => $i->post('namaweb'),
                'tagline'            => $i->post('tagline'),
                'email'              => $i->post('email'),
                'website'            => $i->post('website'),
                'keywords'           => $i->post('keywords'),
                'metatext'           => $i->post('metatext'),
                'telepon'            => $i->post('telepon'),
                'alamat'             => $i->post('alamat'),
                'facebook'           => $i->post('facebook'),
                'twitter'            => $i->post('twitter'),
                'instagram'          => $i->post('instagram'),
                'youtube'            => $i->post('youtube'),
                'deskripsi'          => $i->post('deskripsi'),
                'author'             => $i->post('author'),
                'maps'               => $i->post('maps'),
                'working_hour'       => $i->post('working_hour')
            );
            $this->setting_model->edit($data);
            $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diupdate</div>');
            redirect(base_url('Setting'), 'refresh');
        }
        // End masuk database
    }

    // setting logo website
    public function logo()
    {
        $setting = $this->setting_model->listing();
        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'namaweb',
            'Nama website',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['logo']['name'])) {

                $config['upload_path']         = 'images/logo/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg';
                $config['max_size']          = '2400'; // dalam KB
                $config['max_width']         = '2048'; // dalam pixel
                $config['max_height']          = '2048';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('logo')) {

                    // End validasi

                    $data = array(
                        'title'      => 'Setting Logo Website',
                        'setting'    =>  $setting,
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'error'      =>  $this->upload->display_errors(),
                        'isi'        => 'setting/logo'
                    );
                    $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());

                    // create thumbnail gambar
                    $config['image_library']     = 'gd2';
                    $config['source_image']     = 'images/logo/' . $upload_gambar['upload_data']['file_name'];
                    //Lokasi folder thumbnail
                    $config['new_image']        = 'images/logo/thumbs/';
                    $config['create_thumb']     = TRUE;
                    $config['maintain_ratio']     = TRUE;
                    $config['width']             = 250;
                    $config['height']           = 250;
                    $config['thumb_marker']     = '';

                    $this->load->library('image_lib', $config);

                    $this->image_lib->resize();
                    // end create thumbnail
                    $i = $this->input;

                    $data = array(
                        'id_setting'    => $setting->id_setting,
                        'namaweb'         => $i->post('namaweb'),
                        //Disimpan nama file gambar
                        'logo'             => $upload_gambar['upload_data']['file_name']
                    );
                    $this->setting_model->edit($data);
                    $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diupdate</div>');
                    redirect(base_url('Setting/logo'), 'refresh');
                }
            } else {
                //Edit produk tanpa ganti gambar
                $i = $this->input;

                $data = array(
                    'id_setting'    => $setting->id_setting,
                    'namaweb'         => $i->post('namaweb'),
                    //Disimpan nama file gambar
                    //'logo' 		=> $upload_gambar['upload_data']['file_name']
                );
                $this->setting_model->edit($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diupdate</div>');
                redirect(base_url('Setting/logo'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'      => 'Setting Logo Website',
            'setting'    =>  $setting,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'        => 'setting/logo'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    // setting icon website
    public function icon()
    {
        $setting = $this->setting_model->listing();
        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'namaweb',
            'Nama website',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['icon']['name'])) {

                $config['upload_path']         = 'images/icon/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg';
                $config['max_size']          = '2400'; // dalam KB
                $config['max_width']         = '2048'; // dalam pixel
                $config['max_height']          = '2048';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('icon')) {

                    // End validasi

                    $data = array(
                        'title'      => 'Setting Icon Website',
                        'setting'    =>  $setting,
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'error'      =>  $this->upload->display_errors(),
                        'isi'        => 'setting/icon'
                    );
                    $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());

                    // create thumbnail gambar
                    $config['image_library']     = 'gd2';
                    $config['source_image']     = 'images/icon/' . $upload_gambar['upload_data']['file_name'];
                    //Lokasi folder thumbnail
                    $config['new_image']        = 'images/icon/thumbs/';
                    $config['create_thumb']     = TRUE;
                    $config['maintain_ratio']     = TRUE;
                    $config['width']             = 250;
                    $config['height']           = 250;
                    $config['thumb_marker']     = '';

                    $this->load->library('image_lib', $config);

                    $this->image_lib->resize();
                    // end create thumbnail
                    $i = $this->input;

                    $data = array(
                        'id_setting'    => $setting->id_setting,
                        'namaweb'         => $i->post('namaweb'),
                        //Disimpan nama file gambar
                        'icon'             => $upload_gambar['upload_data']['file_name']
                    );
                    $this->setting_model->edit($data);
                    $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diupdate</div>');
                    redirect(base_url('Setting/icon'), 'refresh');
                }
            } else {
                //Edit produk tanpa ganti gambar
                $i = $this->input;

                $data = array(
                    'id_setting'    => $setting->id_setting,
                    'namaweb'         => $i->post('namaweb'),
                    //Disimpan nama file gambar
                    //'icon' 		=> $upload_gambar['upload_data']['file_name']
                );
                $this->setting_model->edit($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diupdate</div>');
                redirect(base_url('Setting/icon'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'      => 'Setting Icon Website',
            'setting'    =>  $setting,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'        => 'setting/icon'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
