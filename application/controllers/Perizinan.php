<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Perizinan extends CI_Controller
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
            'isi'   => 'absensi/perizinan/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
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
        $this->pdf->load_view('absensi/perizinan/laporan_perizinan', $data);
     }
 
     // export file dalam bentuk print 
     public function print()
     {
        $data['perizinan'] = $this->przs->listing();
        $data['title'] = 'Laporan Data Perizinan Karyawan';
        $this->load->view('absensi/perizinan/print', $data);
     }
 
     public function searchdata()
     {
        $keyword = $this->input->post('keyword');
        $perizinan = $this->przs->get_product_keyword($keyword);
         $data = array(
             'title' => 'perizinan',
             'perizinan'     => $perizinan,
             'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
             'isi'   => 'absensi/perizinan/list'
         );
         $this->load->view('template/wrapper', $data, FALSE);
     }
}
