<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    //untuk login
    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        //validasi
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page!';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('template/auth_footer');
        } else {
            //masuk login
            $this->_login();
        }
    }

    //fungsi login
    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        //mengambil data email dari database dan di cocokan

        $user = $this->db->get_where('tbl_user', ['email' => $email])->row_array();
        //jika usernya ada
        if ($user) {
            //jika usernya aktif
            if ($user['is_active'] == 1) {
                //cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    //pesan 
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">password salah!
                </div>');
                    redirect('auth');
                }
            } else {
                //pesan 
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email belum di aktivasi!
</div>');
                redirect('auth');
            }
        } else {
        }
    }
    public function register()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
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
            $data['title'] = 'Register Page';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/register');
            $this->load->view('template/auth_footer');
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
            redirect('auth');
            
        }
    }

    private function _sendEmail($token, $type)
    {
        $this->load->library('email');
        $config = array();
        $config['charset']= "utf-8";
        $config['useragent']= "Codeigniter";
        $config['protocol']= "smtp";
        $config['mailtype']= "html";
        $config['smtp_host']= "ssl://smtp.gmail.com";
        $config['smtp_port']= "465";
        $config['smtp_timeout']= "400";
        $config['smtp_user']= "webbased457@gmail.com";
        $config['smtp_pass']= "500Milyar";
        $config['crlf']= "\r\n";
        $config['newline']= "\r\n";
        $config['wordwrap']= TRUE;

        $this->email->initialize($config);
        //pengiriman 
        $this->email->from($config['smtp_user'],'Admin PT Redioro Tunggal Jaya');
        $this->email->to($this->input->post('email'));

        //verify akun
        if ($type == 'verify') {
            $this->email->subject('verifikasi Akun');
            $this->email->message('Dear Karyawan PT REDIORO TUNGGAL JAYA' . '<br/>'
                . 'Berikut kami sampaikan link aktivasi akun anda,untuk bisa melanjuti ke proses 
                login pada website absensi PT Redioro Tunggal Jaya' . '<br/>' .
                'Silakan Segera Melakukan Proses Aktivasi Akun Anda' . '<br/>' .
                ' <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi Akun</a>' . '<br/>'
                . 'Demikian Kami Sampaikan atas perhatiaan nya kami ucapkan terimakasih' . '<br/>'
                . 'Hormat' . '<br/>'
                . 'Admin PT REDIORO TUNGGAL JAYA');
        } else if ($type == 'forget') {
            $this->email->subject('Reset Password');
            $this->email->message(
                'Dear Karyawan PT REDIORO TUNGGAL JAYA ' . '<br/>' . '
                    Berikut kami sampaikan link Reset Password akun anda,untuk bisa melanjuti ke proses login pada website absensi PT Redioro Tunggal Jaya' . '<br/>' .
                    'Silakan Segera Melakukan Proses Reset Password Akun Anda' . '<br/>' .
                    '<a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>' . '<br/>' .
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
    //verifikasi email function

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
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $emailverif . ' aktif ! silakan login.</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('tbl_user', ['email' => $emailverif]);
                    $this->db->delete('tbl_user_token', ['email' => $emailverif]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun aktivasi gagal | token sudah kadaluarsa</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun aktivasi gagal | token tidak sesuai</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun aktivasi gagal | email tidak sesuai</div>');
            redirect('auth');
        }
    }

    //function lupa password
    public function forgetpass()
    {
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Lupa Password';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/forget');
            $this->load->view('template/auth_footer');
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
                redirect('auth');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">email belum terdaftar atau belum aktif</div>');
                redirect('auth');
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
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">reset password gagal ! wrong email</div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('template/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('tbl_user');

            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Berhasil di ganti! Silakan Login Kembali</div>');
            redirect('auth');
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        //pesan 
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah Keluar!
        </div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
