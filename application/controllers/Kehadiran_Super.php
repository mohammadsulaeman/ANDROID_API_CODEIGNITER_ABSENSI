<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Kehadiran_Super extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kehadiran_model', 'khs');
        date_default_timezone_set(time_zone);
    }

    public function index()
    {

        $kehadiran = $this->khs->listing();
        $data = array(
            'title' => 'kehadiran',
            'kehadiran'     => $kehadiran,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absen_superadmin/kehadiransuper/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
    
    public function add()
    {
        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'hadir_nama',
            'kehadiran nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            $config['upload_path']       = 'images/kehadiran/';
            $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
            $config['max_size']          = '1024000000000';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('hadir_photo')) {

                // End validasi

                $data = array(
                    'title'         => 'Add kehadiran',
                    'error'         =>  $this->upload->display_errors(),
                    'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                    'isi'           => 'absen_superadmin/kehadiransuper/add'
                );
                $this->load->view('template/wrapper', $data, FALSE);
                // Masuk database
            } else {
                $upload_gambar = array('upload_data' => $this->upload->data());
                // end create thumbnail
                $i = $this->input;

                $data = array(
                    'hadir_id'       => $this->session->userdata('hadir_id'),
                    'hadir_nama'    => $i->post('hadir_nama'),
                    'hadir_lokasi'    => $i->post('hadir_lokasi'),
                    'hadir_waktu'    => $i->post('hadir_waktu'),
                    'hadir_tanggal'     => $i->post('hadir_tanggal'),
                    //Disimpan nama file gambar
                    'hadir_photo'        => $upload_gambar['upload_data']['file_name'],
                    'hadir_status'   => $i->post('hadir_status')
                );
                $this->khs->add($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah ditambah</div>');
                redirect(base_url('Kehadiran_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Add kehadiran',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/kehadiransuper/add'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function edit($id_kehadiran)
    {
        // Ambil data kehadiran yg akan diedit
        $kehadiran     = $this->khs->detail($id_kehadiran);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'hadir_nama',
            'kehadiran nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['hadir_photo']['name'])) {

                $config['upload_path']         = 'images/kehadiran/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
                $config['max_size']          = '1024000000000';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('hadir_photo')) {

                    // End validasi

                    $data = array(
                        'title'     => 'Edit kehadiran',
                        'kehadiran'      =>  $kehadiran,
                        'error'     =>  $this->upload->display_errors(),
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'isi'       => 'absen_superadmin/kehadiransuper/edit'
                    );
                   $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());

                    $i = $this->input;

                    $data = array(
                        'hadir_id'       => $id_kehadiran,
                        'hadir_nama'    => $i->post('hadir_nama'),
                        'hadir_lokasi'    => $i->post('hadir_lokasi'),
                        'hadir_waktu'    => date('Y-m-d H:i:s'),
                        'hadir_tanggal'     => date('Y-m-d H:i:s'),
                        //Disimpan nama file gambar
                        'hadir_photo'        => $upload_gambar['upload_data']['file_name'],
                        'hadir_status'   => $i->post('hadir_status')
                    );
                    $this->khs->edit($data);
                    $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                    redirect(base_url('Kehadiran_Super'), 'refresh');
                }
            } else {
                //Edit kehadiran tanpa ganti gambar
                $i = $this->input;
                $data = array(
                    'hadir_id'       => $id_kehadiran,
                    'hadir_nama'    => $i->post('hadir_nama'),
                    'hadir_lokasi'    => $i->post('hadir_lokasi'),
                    'hadir_waktu'    => date('Y-m-d H:i:s'),
                    'hadir_tanggal'     => date('Y-m-d H:i:s'),
                    'hadir_status'   => $i->post('hadir_status')
                );
                $this->khs->edit($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                redirect(base_url('Kehadiran_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Edit kehadiran',
            'kehadiran'        =>  $kehadiran,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/kehadiransuper/edit'
        );
       $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_kehadiran)
    {
        // Proses hapus gambar
        $kehadiran = $this->khs->detail($id_kehadiran);
        unlink('./images/kehadiran/' . $kehadiran->hadir_photo);
        // End proses hapus 
        $data = array('hadir_id' => $id_kehadiran);
        $this->khs->delete($data);
        $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah dihapus</div>');
        redirect(base_url('Kehadiran_Super'), 'refresh');
    }
    
    // ekspor file dalam bentuk excel
    public function export()
    {
        $semua_pengguna = $this->khs->listing();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Karyawan')
            ->setCellValue('C1', 'Status Karyawan ')
            ->setCellValue('D1', 'Lokasi Absen')
            ->setCellValue('E1', 'Waktu Absen')
            ->setCellValue('F1', 'Tanggal Absen');

        $kolom = 2;
        $nomor = 1;
        foreach ($semua_pengguna as $pengguna) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $pengguna->hadir_nama)
                ->setCellValue('C' . $kolom, $pengguna->hadir_status)
                ->setCellValue('D' . $kolom, $pengguna->hadir_lokasi)
                ->setCellValue('E' . $kolom, $pengguna->hadir_waktu)
                ->setCellValue('F' . $kolom, $pengguna->hadir_tanggal);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Data Kehadiran RTJ.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // export file dalam bentuk pdf 
    public function cetak()
    {

        $data['kehadiran'] = $this->khs->listing();
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-data-kehadiran.pdf";
        $this->pdf->load_view('absen_superadmin/kehadiransuper/laporan_kehadiran', $data);
    }

    // export file dalam bentuk print 
    public function print()
    {
        $data['kehadiran'] = $this->khs->listing();
        $this->load->view('absen_superadmin/kehadiransuper/print', $data);
    }

    public function searchdata()
    {
        $keyword = $this->input->post('keyword');
        $kehadiran = $this->khs->get_product_keyword($keyword);
        $data = array(
            'title' => 'kehadiran',
            'kehadiran'     => $kehadiran,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absen_superadmin/kehadiransuper/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
