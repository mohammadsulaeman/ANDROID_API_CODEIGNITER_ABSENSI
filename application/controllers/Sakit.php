<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Sakit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(time_zone);
        $this->load->model('sakit_model', 'skts');
    }

    public function index()
    {

        $sakit = $this->skts->listing();
        $data = array(
            'title' => 'sakit',
            'sakit'     => $sakit,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absensi/sakit/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

     // ekspor file dalam bentuk excel
     public function export()
     {
        $semua_pengguna = $this->skts->listing();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Karyawan')
            ->setCellValue('C1', 'Status Karyawan ')
            ->setCellValue('D1', 'Keterangan sakit ')
            ->setCellValue('E1', 'Lokasi saat sakit')
            ->setCellValue('F1', 'Waktu saat sakit')
            ->setCellValue('G1', 'Tanggal saat sakit');

        $kolom = 2;
        $nomor = 1;
        foreach ($semua_pengguna as $pengguna) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $pengguna->sakit_nama)
                ->setCellValue('C' . $kolom, $pengguna->sakit_status)
                ->setCellValue('D' . $kolom, $pengguna->sakit_keterangan)
                ->setCellValue('E' . $kolom, $pengguna->sakit_lokasi)
                ->setCellValue('F' . $kolom, $pengguna->sakit_waktu)
                ->setCellValue('G' . $kolom, $pengguna->sakit_tanggal);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Data Karyawan Sakit RTJ.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
     }
 
     // export file dalam bentuk pdf 
     public function cetak()
     {
        $data['sakit'] = $this->skts->listing();
        $data['title'] = 'Laporan Data Karyawan Sakit';
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-data-sakit.pdf";
        $this->pdf->load_view('absensi/sakit/laporan_sakit', $data);
     }
 
     // export file dalam bentuk print 
     public function print()
     {
        $data['sakit'] = $this->skts->listing();
        $data['title'] = 'Laporan Data Karyawan Sakit';
        $this->load->view('absensi/sakit/print', $data);
     }
 
     public function searchdata()
     {
        $keyword = $this->input->post('keyword');
        $sakit = $this->skts->get_product_keyword($keyword);
         $data = array(
             'title' => 'sakit',
             'sakit'     => $sakit,
             'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
             'isi'   => 'absensi/sakit/list'
         );
         $this->load->view('template/wrapper', $data, FALSE);
     }
}
