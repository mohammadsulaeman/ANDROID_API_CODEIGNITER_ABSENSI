<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('menu_model', 'mn');
        is_logged_in();
    }

    //menu list
    public function index()
    {
        $menu = $this->mn->listing();
        $data = array(
            'title' => 'Menu Management',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'menu' => $menu,
            'isi' => 'menu/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
    //edit,delete,tambah menu
    public function add()
    {
        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'menu',
            'Menu',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {

            $i = $this->input;
            $data = array(
                'id'       => $this->session->userdata('id'),
                'menu'    => $i->post('menu')
            );
            $this->mn->add($data);
            $this->session->set_flashdata('sukses', 'Data telah ditambah');
            redirect(base_url('menu'), 'refresh');
        }
        // End masuk database
        $data = array(
            'title'         => 'Add Menu Management',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'menu/addmenu'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
    public function edit($id_menu)
    {
        // Ambil data menu yg akan diedit
        $menu     = $this->mn->detail($id_menu);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'menu',
            'menu nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {

            $data = array(
                'id'       => $id_menu,
                'menu'     => $this->input->post('menu')
            );
            $this->mn->edit($data);
            $this->session->set_flashdata('sukses', 'Data telah diedit');
            redirect(base_url('menu'), 'refresh');
        }
        // End masuk database
        $data = array(
            'title'         => 'Edit menu',
            'menu'        =>  $menu,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'menu/edit'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_menu)
    {
        // Proses hapus gambar
        $menu = $this->mn->detail($id_menu);
        // End proses hapus 
        $data = array('id' => $id_menu);
        $this->mn->delete($data);
        $this->session->set_flashdata('sukses', 'Data telah dihapus');
        redirect(base_url('menu'), 'refresh');
    }

    //submenu list
    public function submenu()
    {
        $menu = $this->mn->listing();
        $subMenu = $this->mn->getSubMenu();
        $data = array(
            'title' => 'Submenu Management',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'subMenu' => $subMenu,
            'menu' => $menu,
            'isi' => 'menu/submenu'
        );
        //ruler
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        //ruler
        $this->form_validation->set_rules('menu_id', 'Menu_id', 'required|trim');
        //ruler
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
        //ruler
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/wrapper', $data, FALSE);
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->insert('tbl_user_sub_menu', $data);
            //pesan 
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">tambah submenu berhasil!
             </div>');
            redirect('menu/submenu');
        }
    }

    //editsubmenu, tambahsubmenu,deletesubmenu
    public function editsubmenu($id_submenu)
    {
        // Ambil data menu yg akan diedit
        $subMenu     = $this->mn->detailsubMenu($id_submenu);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'title',
            'Title nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {

            $data = array(
                'id'       => $id_submenu,
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            );
            $this->mn->editsubMenu($data);
            $this->session->set_flashdata('sukses', 'Data telah diedit');
            redirect(base_url('menu/submenu'), 'refresh');
        }
        // End masuk database
        $data = array(
            'title'         => 'SubMenu Management',
            'subMenu'        =>  $subMenu,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'menu/editsubmenu'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function deletesubmenu($id_submenu)
    {
        
        // End proses hapus 
        $data = array('id' => $id_submenu);
        $this->mn->deletesubMenu($data);
        $this->session->set_flashdata('sukses', 'Data telah dihapus');
        redirect(base_url('menu/submenu'), 'refresh');
    }
}
