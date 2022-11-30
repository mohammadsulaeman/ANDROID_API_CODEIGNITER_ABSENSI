<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Users_model','usr');
    }

    public function index()
    {
        $user =  $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array();

        $data = array(
            'title' => 'My Profile',
            'user' =>$user ,
            'isi' => 'user/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function edit($id_users)
    {
        // Ambil data users yg akan diedit
        $users     = $this->usr->detail($id_users);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'name',
            'Nama Users',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['image']['name'])) {

                $config['upload_path']         = 'images/profile/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg';
                $config['max_size']          = '10000000000'; // dalam KB

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {

                    // End validasi

                    $data = array(
                        'title'     => 'Edit users',
                        'users'      =>  $users,
                        'error'     =>  $this->upload->display_errors(),
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'isi'       => 'user/edit'
                    );
                    $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());
                    // end create thumbnail
                    $i = $this->input;
                    $data = array(
                        'id'       => $id_users,
                        'name'    => $i->post('name'),
                        'email'    => $i->post('email'),
                        //Disimpan nama file gambar
                        'image'         => $upload_gambar['upload_data']['file_name'],
                        'jabatan'    => $i->post('jabatan'),
                        'pendidikan'    => $i->post('pendidikan'),
                        'status'    => $i->post('status'),
                        'alamat'    => $i->post('alamat'),
                        'ttl'    => $i->post('ttl'),
                        'phone'    => $i->post('phone')
                    );
                    $this->usr->edit($data);
                    $this->session->set_flashdata('sukses', 'Data telah diedit');
                    redirect(base_url('user'), 'refresh');
                }
            } else {
                //Edit users tanpa ganti gambar
                $i = $this->input;
                $data = array(
                    'id'       => $id_users,
                    'name'    => $i->post('name'),
                    'email'    => $i->post('email'),
                    'jabatan'    => $i->post('jabatan'),
                    'pendidikan'    => $i->post('pendidikan'),
                    'status'    => $i->post('status'),
                    'alamat'    => $i->post('alamat'),
                    'ttl'    => $i->post('ttl'),
                    'phone'    => $i->post('phone')
                );
                $this->usr->edit($data);
                $this->session->set_flashdata('sukses', 'Data telah diedit');
                redirect(base_url('user'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'     => 'Edit users',
            'users'      =>  $users,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'       => 'user/edit'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

}
