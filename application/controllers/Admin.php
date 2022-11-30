<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        is_logged_in();
        date_default_timezone_set(time_zone);
        $this->load->model('Dashboard_model', 'dasb');
        $this->load->model('Admin_model', 'adm');
    }

    public function index()
    {
        $data = array(
            'title' => 'Dashboard',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'counters' => $this->dasb->count(),
            'isi' => 'admin/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function role()
    {
        $roleMenu = $this->adm->listing();
        $data = array(
            'title' => 'Role access',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'roleMenu' => $roleMenu,
            'isi' => 'admin/role'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    //tambah role
    public function addrole()
    {
        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'role',
            'Role',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            
                $i = $this->input;
                $data = array(
                    'id'       => $this->session->userdata('id'),
                    'role'    => $i->post('role')
                );
                $this->adm->add($data);
                $this->session->set_flashdata('sukses', 'Data telah ditambah');
                redirect(base_url('admin/role'), 'refresh');
            }
        // End masuk database
        $data = array(
            'title'         => 'Add Role Access',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'admin/addrole'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
    //edit dan delete
    public function edit($id_role)
    {
        // Ambil data roleMenuyg akan diedit
        $roleMenu    = $this->adm->detail($id_role);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'role',
            'Role Name',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {

            $data = array(
                'id'       => $id_role,
                'role'     => $this->input->post('role')
            );
            $this->adm->edit($data);
            $this->session->set_flashdata('sukses', 'Data telah diedit');
            redirect(base_url('admin/role'), 'refresh');
        }
        // End masuk database
        $data = array(
            'title'         => 'Edit menu',
            'roleMenu'        =>  $roleMenu,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'admin/editrole'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_role)
    {
        // Proses hapus gambar
        $roleMenu = $this->adm->detail($id_role);
        // End proses hapus 
        $data = array('id' => $id_role);
        $this->adm->delete($data);
        $this->session->set_flashdata('sukses', 'Data telah dihapus');
        redirect(base_url('admin/role'), 'refresh');
    }
    //role access
    public function roleaccess($role_id)
    {
        $data = array(
            'title' => 'Role Access',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'role' => $this->db->get_where('tbl_user_role', ['id' => $role_id])->row_array(),
            'isi' => 'admin/role_access'
        );
        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('tbl_user_menu')->result_array();
        $this->load->view('template/wrapper', $data, FALSE);
    }


    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $access = $this->db->get_where('tbl_user_access_menu', $data);

        if ($access->num_rows() < 1) {
            $this->db->insert('tbl_user_access_menu', $data);
        } else {
            $this->db->delete('tbl_user_access_menu', $data);
        }

        //pesan 
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!
        </div>');
    }
}
