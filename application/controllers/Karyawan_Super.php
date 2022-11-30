<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Karyawan_Super extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Karyawan_model', 'krys');
        date_default_timezone_set(time_zone);
        
    }

    public function index()
    {

        $karyawan = $this->krys->listing();
        $data = array(
            'title' => 'karyawan',
            'karyawan'     => $karyawan,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absen_superadmin/karyawansuper/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
    
    public function add()
    {
        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'karyawan_name',
            'karyawan nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            $config['upload_path']       = 'images/karyawan/';
            $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
            $config['max_size']          = '1024000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('karyawan_photo')) {

                // End validasi

                $data = array(
                    'title'         => 'Add karyawan',
                    'error'         =>  $this->upload->display_errors(),
                    'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                    'isi'           => 'absen_superadmin/karyawansuper/add'
                );
               $this->load->view('template/wrapper', $data, FALSE);
                // Masuk database
            } else {
                $upload_gambar = array('upload_data' => $this->upload->data());

                // end create thumbnail
                $i = $this->input;

                $data = array(
                    'karyawan_name'    => $i->post('karyawan_name'),
                    'karyawan_phone'    => $i->post('karyawan_phone'),
                    'karyawan_email'    => $i->post('karyawan_email'),
                    'karyawan_tempat'    => $i->post('karyawan_tempat'),
                    'karyawan_status'    => $i->post('karyawan_status'),
                    'karyawan_photo'        => $upload_gambar['upload_data']['file_name'],
                    'karyawan_gender'       => $i->post('karyawan_gender'),
                    'karyawan_code'     => $i->post('karyawan_code'),
                    'karyawan_alamat'   => $i->post('karyawan_alamat'),
                    'karyawan_lahir'     => $i->post('karyawan_lahir')
                );
                $this->krys->add($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah ditambah</div>');
                redirect(base_url('Karyawan_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Add karyawan',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/karyawansuper/add'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function edit($id_karyawan)
    {
        // Ambil data karyawan yg akan diedit
        $karyawan     = $this->krys->detail($id_karyawan);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'karyawan_name',
            'karyawan nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['karyawan_photo']['name'])) {

                $config['upload_path']         = 'images/karyawan/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
                $config['max_size']          = '1024000000000';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('karyawan_photo')) {

                    // End validasi

                    $data = array(
                        'title'     => 'Edit karyawan',
                        'karyawan'      =>  $karyawan,
                        'error'     =>  $this->upload->display_errors(),
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'isi'       => 'absen_superadmin/karyawansuper/edit'
                    );
                    $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());

                    $i = $this->input;

                    $data = array(
                        'karyawan_id'       => $id_karyawan,
                        'karyawan_name'    => $i->post('karyawan_name'),
                        'karyawan_phone'    => $i->post('karyawan_phone'),
                        'karyawan_status'    => $i->post('karyawan_status'),
                        'karyawan_photo'        => $upload_gambar['upload_data']['file_name'],
                        'karyawan_gender'       => $i->post('karyawan_gender'),
                        'karyawan_code'     => $i->post('karyawan_code'),
                        'karyawan_alamat'   => $i->post('karyawan_alamat'),
                        'karyawan_lahir'     => $i->post('karyawan_lahir'),
                        'password'         => SHA1($i->post('password'))
                    );
                    $this->krys->edit($data);
                    $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                    redirect(base_url('Karyawan_Super'), 'refresh');
                }
            } else {
                //Edit karyawan tanpa ganti gambar
                $i = $this->input;
                $data = array(
                    'karyawan_id'       => $id_karyawan,
                    'karyawan_name'    => $i->post('karyawan_name'),
                    'karyawan_phone'    => $i->post('karyawan_phone'),
                    'karyawan_status'    => $i->post('karyawan_status'),
                    'karyawan_gender'       => $i->post('karyawan_gender'),
                    'karyawan_code'     => $i->post('karyawan_code'),
                    'karyawan_alamat'   => $i->post('karyawan_alamat'),
                    'karyawan_lahir'     => $i->post('karyawan_lahir'),
                    'password'         => SHA1($i->post('password'))
                );
                $this->krys->edit($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                redirect(base_url('Karyawan_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Edit karyawan',
            'karyawan'        =>  $karyawan,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/karyawansuper/edit'
        );
       $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_karyawan)
    {
        // Proses hapus gambar
        $karyawan = $this->krys->detail($id_karyawan);
        unlink('images/karyawan/' . $karyawan->karyawan_photo);
        // unlink('images/ktp/' . $karyawan->karyawan_ktp);
        // End proses hapus 
        $data = array('karyawan_id' => $id_karyawan);
        $this->krys->delete($data);
        $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah dihapus</div>');
        redirect(base_url('Karyawan_Super'), 'refresh');
    }
    // ekspor file dalam bentuk excel
    public function export()
    {
        $semua_pengguna = $this->krys->listing();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Karyawan')
            ->setCellValue('C1', 'Nomor Telepon')
            ->setCellValue('D1', 'Status Karyawan')
            ->setCellValue('E1', 'Jenis Kelamin')
            ->setCellValue('F1', 'Tempat Lahir')
            ->setCellValue('G1', 'Tanggal Lahir')
            ->setCellValue('H1', 'Alamat Saat Ini');

        $kolom = 2;
        $nomor = 1;
        foreach ($semua_pengguna as $pengguna) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $pengguna->karyawan_name)
                ->setCellValue('C' . $kolom, $pengguna->karyawan_phone)
                ->setCellValue('D' . $kolom, $pengguna->karyawan_status)
                ->setCellValue('E' . $kolom, $pengguna->karyawan_gender)
                ->setCellValue('F' . $kolom, $pengguna->karyawan_tempat)
                ->setCellValue('G' . $kolom, date('j F Y', strtotime($pengguna->karyawan_lahir)))
                ->setCellValue('H' . $kolom, $pengguna->karyawan_alamat);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Data Karyawan RTJ.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // export file dalam bentuk pdf 
    public function cetak()
    {

        $data['karyawan'] = $this->krys->listing();
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-data-karyawan.pdf";
        $this->pdf->load_view('absen_superadmin/karyawansuper/laporan_karyawan', $data);
    }

    // export file dalam bentuk print 
    public function print()
    {
        $data['karyawan'] = $this->krys->listing();
        $data['title'] = 'Laporan Data Karyawan';
        $this->load->view('absen_superadmin/karyawansuper/print', $data);
    }

    public function searchdata()
    {
        $keyword = $this->input->post('keyword');
        $karyawan = $this->krys->get_product_keyword($keyword);
        $data = array(
            'title' => 'karyawan',
            'karyawan'     => $karyawan,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absen_superadmin/karyawansuper/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
