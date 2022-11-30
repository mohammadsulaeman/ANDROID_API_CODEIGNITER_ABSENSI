<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Kehadiran extends CI_Controller
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
            'isi'   => 'absensi/kehadiran/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
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
        $data['title'] = 'Laporan Data Kehadiran';
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-data-kehadiran.pdf";
        $this->pdf->load_view('absensi/kehadiran/laporan_kehadiran', $data);
    }

    // export file dalam bentuk print 
    public function print()
    {
        $data['kehadiran'] = $this->khs->listing();
        $data['title'] = 'Laporan Data Kehadiran';
        $this->load->view('absensi/kehadiran/print', $data);
    }

    public function searchdata()
    {
        $keyword = $this->input->post('keyword');
        $kehadiran = $this->khs->get_product_keyword($keyword);
        $data = array(
            'title' => 'kehadiran',
            'kehadiran'     => $kehadiran,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absensi/kehadiran/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
