<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Create_Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Users_model', 'usr');
    }

    public function index()
    {
        $createusers = $this->usr->listing();
        $data = array(
            'title' => 'Create User',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'createusers' => $createusers,
            'isi' => 'createusers/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tbl_user.email]', [
            'is_unique' => 'Email Sudah Pernah Terdaftar!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password Tidak sama!',
            'min_length' => 'password minimal 3'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data = array(
                'title' => 'Tambah Users',
                'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                'isi' => 'createusers/add'
            );
            $this->load->view('template/wrapper', $data, FALSE);
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => $email,
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'is_active' => 0,
                'role_id' => 2,
                'date_created' => time()
            ];

            //masuk ke dalam database
            $this->db->insert('tbl_user', $data);

            // siapkan token untuk login 
            $token = base64_encode(random_bytes(32));
            $data_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            //masuk data ke dalam tabel user_token
            $this->db->insert('tbl_user_token', $data_token);

            //membuat function sendEmail
            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat Akun Anda Berhasil Di Buat.Silakan aktivasi akun anda</div>');
            redirect('Create_Users');
        }
    }

    //untuk kirim link aktivasi dan reset akun
    private function _sendEmail($token, $type)
    {
        $this->load->library('email');
        $config = array();
        $config['charset'] = "utf-8";
        $config['useragent'] = "Codeigniter";
        $config['protocol'] = "smtp";
        $config['mailtype'] = "html";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_timeout'] = "400";
        $config['smtp_user'] = "webbased457@gmail.com";
        $config['smtp_pass'] = "500Milyar";
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        //pengiriman 
        $this->email->from($config['smtp_user'], 'Admin PT Redioro Tunggal Jaya');
        $this->email->to($this->input->post('email'));

        //verify akun
        if ($type == 'verify') {
            $this->email->subject('verifikasi Akun');
            $this->email->message('Dear Karyawan PT REDIORO TUNGGAL JAYA' . '<br/>'
                . 'Berikut kami sampaikan link aktivasi akun anda,untuk bisa melanjuti ke proses 
                login pada website absensi PT Redioro Tunggal Jaya' . '<br/>' .
                'Silakan Segera Melakukan Proses Aktivasi Akun Anda' . '<br/>' .
                ' <a href="' . base_url() . 'Create_Users/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi Akun</a>' . '<br/>'
                . 'Demikian Kami Sampaikan atas perhatiaan nya kami ucapkan terimakasih' . '<br/>'
                . 'Hormat' . '<br/>'
                . 'Admin PT REDIORO TUNGGAL JAYA');
        } else if ($type == 'forget') {
            $this->email->subject('Reset Password');
            $this->email->message(
                'Dear Karyawan PT REDIORO TUNGGAL JAYA ' . '<br/>' . '
                    Berikut kami sampaikan link Reset Password akun anda,untuk bisa melanjuti ke proses login pada website absensi PT Redioro Tunggal Jaya' . '<br/>' .
                    'Silakan Segera Melakukan Proses Reset Password Akun Anda' . '<br/>' .
                    '<a href="' . base_url() . 'Create_Users/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>' . '<br/>' .
                    'Demikian Kami Sampaikan atas perhatiaan nya kami ucapkan terimakasih' . '<br/>' .
                    'Hormat' . '<br/>'
                    . 'Admin PT REDIORO TUNGGAL JAYA'
            );
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    //untuk bagian jika akun sudah di verifikasi lewat email
    public function verify()
    {
        $emailverif = $this->input->get('email');
        $tokenverif = $this->input->get('token');

        $user = $this->db->get_where('tbl_user', ['email' => $emailverif])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('tbl_user_token', ['token' => $tokenverif])->row_array();
            if ($user_token) {
                //aturan penggunaan token , jika lewat dari masa token user daftar lagi
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $emailverif);
                    $this->db->update('tbl_user');
                    $this->db->delete('tbl_user_token', ['email' => $emailverif]);

                    //pesan
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $emailverif . ' Akun Sudah Bisa Digunakan.</div>');
                    redirect('Create_Users');
                } else {
                    $this->db->delete('tbl_user', ['email' => $emailverif]);
                    $this->db->delete('tbl_user_token', ['email' => $emailverif]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun aktivasi gagal | token sudah kadaluarsa</div>');
                    redirect('Create_Users');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun aktivasi gagal | token tidak sesuai</div>');
                redirect('Create_Users');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun aktivasi gagal | email tidak sesuai</div>');
            redirect('Create_Users');
        }
    }

     //untuk aktivasi jika link resetpassword lewat email
     public function forgetpass()
     {
         $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
 
         if ($this->form_validation->run() == false) {
             $data = array(
                 'title' => 'Lupa Password',
                 'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                 'isi' => 'createusers/forget'
             );
             $this->load->view('template/wrapper', $data, FALSE);
         } else {
             $email = $this->input->post('email');
             $user = $this->db->get_where('tbl_user', ['email' => $email, 'is_active' => 1])->row_array();
 
             if ($user) {
                 $token = base64_encode(random_bytes(32));
                 $user_token = [
                     'email' => $email,
                     'token' => $token,
                     'date_created' => time()
                 ];
                 //masuk ke dalam database
                 $this->db->insert('tbl_user_token', $user_token);
                 $this->_sendEmail($token, 'forget');
                 $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Silakan cek email ! ' . $email . ' untuk bantuan lupa password</div>');
                 redirect('Create_Users');
             } else {
                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">email belum terdaftar atau belum aktif</div>');
                 redirect('Create_Users');
             }
         }
     }
 
     public function resetpassword()
     {
         $email = $this->input->get('email');
         $token = $this->input->get('token');
 
         $user = $this->db->get_where('tbl_user', ['email' => $email])->row_array();
         if ($user) {
             $user_token = $this->db->get_where('tbl_user_token', ['token' => $token])->row_array();
 
             if ($user_token) {
                 $this->session->set_userdata('reset_email', $email);
                 $this->changePassword();
             } else {
                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">reset password gagal ! wrong token</div>');
                 redirect('Create_Users');
             }
         } else {
             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">reset password gagal ! wrong email</div>');
             redirect('Create_Users');
         }
     }
 
     public function changePassword()
     {
         if (!$this->session->userdata('reset_email')) {
             redirect('Create_Users');
         }
         $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
         $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');
         if ($this->form_validation->run() == false) {
             $data = array(
                 'title' => 'Change Password',
                 'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                 'isi' => 'createusers/change_password'
             );
             $this->load->view('template/wrapper', $data, FALSE);
         } else {
             $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
             $email = $this->session->userdata('reset_email');
 
             $this->db->set('password', $password);
             $this->db->where('email', $email);
             $this->db->update('tbl_user');
 
             $this->session->unset_userdata('reset_email');
             $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Berhasil di ganti!</div>');
             redirect('Create_Users');
         }
     }

    //untuk proses edit dan delete

    //edit dan delete
    public function edit($id_users)
    {
        // Ambil data users yg akan diedit
        $createusers     = $this->usr->detail($id_users);

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

                $config['upload_path']         = './assets/img/profile/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg';
                $config['max_size']          = '2400'; // dalam KB

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {

                    // End validasi

                    $data = array(
                        'title'     => 'Edit users',
                        'createusers'      =>  $createusers,
                        'error'     =>  $this->upload->display_errors(),
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'isi'       => 'createusers/edit'
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
                    redirect(base_url('Create_Users'), 'refresh');
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
                redirect(base_url('Create_Users'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'     => 'Edit users',
            'createusers'      =>  $createusers,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'       => 'createusers/edit'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_users)
    {
        // Proses hapus gambar
        $createusers = $this->usr->detail($id_users);
        // End proses hapus 
        $data = array('id' => $id_users);
        $this->usr->delete($data);
        $this->session->set_flashdata('sukses', 'Data telah dihapus');
        redirect(base_url('Create_Users'), 'refresh');
    }
}
