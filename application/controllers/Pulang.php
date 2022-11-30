<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Pulang extends CI_Controller
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
            'isi'   => 'absensi/pulang/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
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
        $this->pdf->load_view('absensi/pulang/laporan_pulang', $data);
    }

    // export file dalam bentuk print 
    public function print()
    {
        $data['pulang'] = $this->plgs->listing();
        $data['title'] = 'Laporan Data Pulang Karyawan';
        $this->load->view('absensi/pulang/print', $data);
    }

    public function searchdata()
    {
        $keyword = $this->input->post('keyword');
        $pulang = $this->plgs->get_product_keyword($keyword);
        $data = array(
            'title' => 'pulang',
            'pulang'     => $pulang,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absensi/pulang/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
