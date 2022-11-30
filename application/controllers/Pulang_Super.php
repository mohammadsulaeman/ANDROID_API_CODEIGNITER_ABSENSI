<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Pulang_Super extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(time_zone);
        $this->load->model('pulang_model', 'plgs');
    }

    public function index()
    {

        $pulang = $this->plgs->listing();
        $data = array(
            'title' => 'pulang',
            'pulang'     => $pulang,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absen_superadmin/pulangsuper/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
    
    public function add()
    {
        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'pulang_nama',
            'pulang nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            $config['upload_path']       = 'images/pulang/';
            $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
            $config['max_size']          = '1024000000000';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('pulang_bukti')) {

                // End validasi

                $data = array(
                    'title'         => 'Add pulang',
                    'error'         =>  $this->upload->display_errors(),
                    'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                    'isi'           => 'absen_superadmin/pulangsuper/add'
                );
                $this->load->view('template/wrapper', $data, FALSE);
                // Masuk database
            } else {
                $upload_gambar = array('upload_data' => $this->upload->data());

                // end create thumbnail
                $i = $this->input;

                $data = array(
                    'pulang_id'       => $this->session->userdata('pulang_id'),
                    'pulang_nama'    => $i->post('pulang_nama'),
                    'pulang_lokasi'    => $i->post('pulang_lokasi'),
                    'pulang_status'    => $i->post('pulang_status'),
                    'pulang_waktu'     => $i->post('pulang_waktu'),
                    //Disimpan nama file gambar
                    'pulang_bukti'        => $upload_gambar['upload_data']['file_name'],
                    'pulang_tanggal'   => $i->post('pulang_tanggal')
                );
                $this->plgs->add($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah ditambah</div>');
                redirect(base_url('Pulang_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Add pulang',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/pulangsuper/add'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function edit($id_pulang)
    {
        // Ambil data pulang yg akan diedit
        $pulang     = $this->plgs->detail($id_pulang);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'pulang_nama',
            'pulang nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['pulang_bukti']['name'])) {

                $config['upload_path']         = 'images/pulang/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
                $config['max_size']          = '1024000000000';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('pulang_bukti')) {

                    // End validasi

                    $data = array(
                        'title'     => 'Edit pulang',
                        'pulang'      =>  $pulang,
                        'error'     =>  $this->upload->display_errors(),
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'isi'       => 'absen_superadmin/pulangsuper/edit'
                    );
                    $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());

                    $i = $this->input;

                    $data = array(
                        'pulang_id'       => $id_pulang,
                        'pulang_nama'    => $i->post('pulang_nama'),
                        'pulang_lokasi'    => $i->post('pulang_lokasi'),
                        'pulang_status'    => $i->post('pulang_status'),
                        'pulang_waktu'     => date(' H:i:s'),
                        //Disimpan nama file gambar
                        'pulang_bukti'        => $upload_gambar['upload_data']['file_name'],
                        'pulang_tanggal'   => date('Y-m-d')
                    );
                    $this->plgs->edit($data);
                    $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                    redirect(base_url('Pulang_Super'), 'refresh');
                }
            } else {
                //Edit pulang tanpa ganti gambar
                $i = $this->input;
                $data = array(
                    'pulang_id'       => $id_pulang,
                    'pulang_nama'    => $i->post('pulang_nama'),
                    'pulang_lokasi'    => $i->post('pulang_lokasi'),
                    'pulang_status'    => $i->post('pulang_status'),
                    'pulang_waktu'     => date('H:i:s'),
                    'pulang_tanggal'   => date('Y-m-d')
                );
                $this->plgs->edit($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                redirect(base_url('Pulang_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Edit pulang',
            'pulang'        =>  $pulang,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/pulangsuper/edit'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_pulang)
    {
        // Proses hapus gambar
        $pulang = $this->plgs->detail($id_pulang);
        unlink('images/pulang/' . $pulang->pulang_bukti);
        // End proses hapus 
        $data = array('pulang_id' => $id_pulang);
        $this->plgs->delete($data);
        $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah dihapus</div>');
        redirect(base_url('Pulang_Super'), 'refresh');
    }
    // ekspor file dalam bentuk excel
    public function export()
    {
        $semua_pengguna = $this->plgs->listing();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Karyawan')
            ->setCellValue('C1', 'Status Karyawan ')
            ->setCellValue('D1', 'Lokasi saat pulang')
            ->setCellValue('E1', 'Waktu saat pulang')
            ->setCellValue('F1', 'Tanggal saat pulang');

        $kolom = 2;
        $nomor = 1;
        foreach ($semua_pengguna as $pengguna) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $pengguna->pulang_nama)
                ->setCellValue('C' . $kolom, $pengguna->pulang_status)
                ->setCellValue('D' . $kolom, $pengguna->pulang_lokasi)
                ->setCellValue('E' . $kolom, $pengguna->pulang_waktu)
                ->setCellValue('F' . $kolom, $pengguna->pulang_tanggal);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Data Pulang RTJ.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // export file dalam bentuk pdf 
    public function cetak()
    {
        $data['pulang'] = $this->plgs->listing();
        $data['title'] = 'Laporan Data Pulang Karyawan';
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-data-pulang.pdf";
        $this->pdf->load_view('absen_superadmin/pulangsuper/laporan_pulang', $data);
    }

    // export file dalam bentuk print 
    public function print()
    {
        $data['pulang'] = $this->plgs->listing();
        $data['title'] = 'Laporan Data Pulang Karyawan';
        $this->load->view('absen_superadmin/pulangsuper/print', $data);
    }

    public function searchdata()
    {
        $keyword = $this->input->post('keyword');
        $pulang = $this->plgs->get_product_keyword($keyword);
        $data = array(
            'title' => 'pulang',
            'pulang'     => $pulang,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absen_superadmin/pulangsuper/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
