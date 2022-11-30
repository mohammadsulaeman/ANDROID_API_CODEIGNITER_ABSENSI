<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Karyawan extends CI_Controller
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
            'isi'   => 'absensi/karyawan/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
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
        $data['title'] = 'Laporan Data Karyawan';
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-data-karyawan.pdf";
        $this->pdf->load_view('absensi/karyawan/laporan_karyawan', $data);
    }

    // export file dalam bentuk print 
    public function print()
    {
        $data['karyawan'] = $this->krys->listing();
        $data['title'] = 'Laporan Data Karyawan';
        $this->load->view('absensi/karyawan/print', $data);
    }

    public function searchdata()
    {
        $keyword = $this->input->post('keyword');
        $karyawan = $this->krys->get_product_keyword($keyword);
        $data = array(
            'title' => 'karyawan',
            'karyawan'     => $karyawan,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'   => 'absensi/karyawan/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
}
