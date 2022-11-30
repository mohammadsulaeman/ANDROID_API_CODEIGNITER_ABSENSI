<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Perizinan_Super extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(time_zone);
        $this->load->model('perizinan_model', 'przs');
    }

    public function index()
    {

        $perizinan = $this->przs->listing();
        $data = array(
            'title' => 'perizinan',
            'perizinan'     => $perizinan,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absen_superadmin/perizinansuper/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
    
    public function add()
    {
        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'perijinan_nama',
            'Perizinan nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            $config['upload_path']       = 'images/perijinan/';
            $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
            $config['max_size']          = '1024000000000';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('perijinan_bukti')) {

                // End validasi

                $data = array(
                    'title'         => 'Add Perizinan',
                    'error'         =>  $this->upload->display_errors(),
                    'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                    'isi'           => 'absen_superadmin/perizinansuper/add'
                );
                $this->load->view('template/wrapper', $data, FALSE);
                // Masuk database
            } else {
                $upload_gambar = array('upload_data' => $this->upload->data());
                // end create thumbnail
                $i = $this->input;

                $data = array(
                    'perijinan_id'       => $this->session->userdata('perijinan_id'),
                    'perijinan_nama'    => $i->post('perijinan_nama'),
                    'perijinan_keterangan'    => $i->post('perijinan_keterangan'),
                    'perijinan_status'    => $i->post('perijinan_status'),
                    'perijinan_tanggal'     => $i->post('perijinan_tanggal'),
                    //Disimpan nama file gambar
                    'perijinan_bukti'        => $upload_gambar['upload_data']['file_name'],
                    'perijinan_waktu'   => $i->post('perijinan_waktu'),
                    'perijinan_lokasi'   => $i->post('perijinan_lokasi')
                );
                $this->przs->add($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah ditambah</div>');
                redirect(base_url('Perizinan_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Add Perizinan',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/perizinansuper/add'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function edit($id_Perijinan)
    {
        // Ambil data Perizinansuper yg akan diedit
        $perizinan     = $this->przs->detail($id_Perijinan);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'perijinan_nama',
            'Perizinan nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['perijinan_bukti']['name'])) {

                $config['upload_path']         = 'images/perijinan/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
                $config['max_size']          = '1024000000000';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('perijinan_bukti')) {

                    // End validasi

                    $data = array(
                        'title'     => 'Edit Perizinan',
                        'Perizinan'      =>  $perizinan,
                        'error'     =>  $this->upload->display_errors(),
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'isi'       => 'absen_superadmin/perizinansuper/edit'
                    );
                    $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());

                    $i = $this->input;

                    $data = array(
                        'perijinan_id'       => $id_Perijinan,
                        'perijinan_nama'    => $i->post('perijinan_nama'),
                        'perijinan_keterangan'    => $i->post('perijinan_keterangan'),
                        'perijinan_status'    => $i->post('perijinan_status'),
                        'perijinan_tanggal'     => date('Y-m-d'),
                        //Disimpan nama file gambar
                        'perijinan_bukti'        => $upload_gambar['upload_data']['file_name'],
                        'perijinan_waktu'   => date('H:i:s'),
                        'perijinan_lokasi'   => $i->post('perijinan_lokasi'),
                        'reponse_kepala'   => $i->post('reponse_kepala'),
                        'nama_kepala'   => $i->post('nama_kepala')
                    );
                    $this->przs->edit($data);
                    $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                    redirect(base_url('Perizinan_Super'), 'refresh');
                }
            } else {
                //Edit Perizinansuper tanpa ganti gambar
                $i = $this->input;
                $data = array(
                    'perijinan_id'       => $id_Perijinan,
                    'perijinan_nama'    => $i->post('perijinan_nama'),
                    'perijinan_keterangan'    => $i->post('perijinan_keterangan'),
                    'perijinan_status'    => $i->post('perijinan_status'),
                    'perijinan_tanggal'     => date('Y-m-d'),
                    'perijinan_waktu'   => date('H:i:s'),
                    'perijinan_lokasi'   => $i->post('perijinan_lokasi'),
                    'reponse_kepala'   => $i->post('reponse_kepala'),
                    'nama_kepala'   => $i->post('nama_kepala')
                );
                $this->przs->edit($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                redirect(base_url('Perizinan_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Edit Perizinan',
            'perizinan'        =>  $perizinan,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/perizinansuper/edit'
        );
       $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_Perijinan)
    {
        // Proses hapus gambar
        $perizinan = $this->przs->detail($id_Perijinan);
        unlink('images/perijinan/' . $perizinan->perijinan_bukti);
        // End proses hapus 
        $data = array('perijinan_id' => $id_Perijinan);
        $this->przs->delete($data);
        $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah dihapus</div>');
        redirect(base_url('Perizinan_Super'), 'refresh');
    }
     // ekspor file dalam bentuk excel
     public function export()
     {
        $semua_pengguna = $this->przs->listing();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Karyawan')
            ->setCellValue('C1', 'Status Karyawan ')
            ->setCellValue('D1', 'Keterangan Izin ')
            ->setCellValue('E1', 'Lokasi saat izin')
            ->setCellValue('F1', 'Waktu saat izin')
            ->setCellValue('G1', 'Tanggal saat izin')
            ->setCellValue('H1', 'Respon Pemberi izin')
            ->setCellValue('I1', 'Nama Pemberi izin');

        $kolom = 2;
        $nomor = 1;
        foreach ($semua_pengguna as $pengguna) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $pengguna->perijinan_nama)
                ->setCellValue('C' . $kolom, $pengguna->perijinan_status)
                ->setCellValue('D' . $kolom, $pengguna->perijinan_keterangan)
                ->setCellValue('E' . $kolom, $pengguna->perijinan_lokasi)
                ->setCellValue('F' . $kolom, $pengguna->perijinan_waktu)
                ->setCellValue('G' . $kolom, $pengguna->perijinan_tanggal)
                ->setCellValue('H' . $kolom, $pengguna->reponse_kepala)
                ->setCellValue('I' . $kolom, $pengguna->nama_kepala);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Data Perizinan RTJ.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
     }
 
     // export file dalam bentuk pdf 
     public function cetak()
     {
 
        $data['perizinan'] = $this->przs->listing();
        $data['title'] = 'Laporan Data Perizinan Karyawan';
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-data-perizinan.pdf";
        $this->pdf->load_view('absen_superadmin/perizinansuper/laporan_perizinan', $data);
     }
 
     // export file dalam bentuk print 
     public function print()
     {
        $data['perizinan'] = $this->przs->listing();
        $data['title'] = 'Laporan Data Perizinan Karyawan';
        $this->load->view('absen_superadmin/perizinansuper/print', $data);
     }
 
     public function searchdata()
     {
        $keyword = $this->input->post('keyword');
        $perizinan = $this->przs->get_product_keyword($keyword);
         $data = array(
             'title' => 'perizinan',
             'perizinan'     => $perizinan,
             'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
             'isi'   => 'absen_superadmin/perizinansuper/list'
         );
         $this->load->view('template/wrapper', $data, FALSE);
     }
}
