<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load library phpofficephpspreadshet
require('./application/third_party/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//load library phpofficephpspreadshet
require('./application/third_party/PDF/vendor/autoload.php');
class Sakit_Super extends CI_Controller
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
            'isi'   => 'absen_superadmin/sakitsuper/list'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }
     public function add()
    {
        //Validasi input
        $valid = $this->form_validation;
        $valid->set_rules(
            'sakit_nama',
            'sakit nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            $config['upload_path']       = 'images/sakit/';
            $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
            $config['max_size']          = '1024000000000';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('sakit_bukti')) {

                // End validasi

                $data = array(
                    'title'         => 'Add sakit',
                    'error'         =>  $this->upload->display_errors(),
                    'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                    'isi'           => 'absen_superadmin/sakitsuper/add'
                );
               $this->load->view('template/wrapper', $data, FALSE);
                // Masuk database
            } else {
                $upload_gambar = array('upload_data' => $this->upload->data());
                // end create thumbnail
                $i = $this->input;
                $data = array(
                    'sakit_id'       => $this->session->userdata('sakit_id'),
                    'sakit_nama'    => $i->post('sakit_nama'),
                    'sakit_status'    => $i->post('sakit_status'),
                    'sakit_lokasi'    => $i->post('sakit_lokasi'),
                    'sakit_tanggal'     => $i->post('sakit_tanggal'),
                    //Disimpan nama file gambar
                    'sakit_bukti'        => $upload_gambar['upload_data']['file_name'],
                    'sakit_waktu'   => $i->post('sakit_waktu'),
                    'sakit_keterangan' => $i->post('sakit_keterangan')
                );
                $this->skts->add($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah ditambah</div>');
                redirect(base_url('Sakit_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Add sakit',
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/sakitsuper/add'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function edit($id_sakit)
    {
        // Ambil data sakit yg akan diedit
        $sakit     = $this->skts->detail($id_sakit);

        //Validasi input
        $valid         = $this->form_validation;
        $valid->set_rules(
            'sakit_nama',
            'sakit nama',
            'required',
            array('required'    => '%s harus diisi')
        );

        if ($valid->run()) {
            // Check jika gambar diganti
            if (!empty($_FILES['sakit_bukti']['name'])) {

                $config['upload_path']         = 'images/sakit/';
                $config['allowed_types']     = 'gif|jpg|png|jpeg|mp4';
                $config['max_size']          = '1024000000000';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('sakit_bukti')) {

                    // End validasi

                    $data = array(
                        'title'     => 'Edit sakit',
                        'sakit'      =>  $sakit,
                        'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
                        'error'     =>  $this->upload->display_errors(),
                        'isi'       => 'absen_superadmin/sakitsuper/edit'
                    );
                    $this->load->view('template/wrapper', $data, FALSE);
                    // Masuk database
                } else {
                    $upload_gambar = array('upload_data' => $this->upload->data());

                    $i = $this->input;

                    $data = array(
                        'sakit_id'       => $id_sakit,
                        'sakit_nama'    => $i->post('sakit_nama'),
                        'sakit_status'    => $i->post('sakit_status'),
                        'sakit_lokasi'    => $i->post('sakit_lokasi'),
                        'sakit_tanggal'     => $i->post('sakit_tanggal'),
                        //Disimpan nama file gambar
                        'sakit_bukti'        => $upload_gambar['upload_data']['file_name'],
                        'sakit_waktu'   => $i->post('sakit_waktu'),
                        'sakit_keterangan' => $i->post('sakit_keterangan')
                    );
                    $this->skts->edit($data);
                    $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                    redirect(base_url('Sakit_Super'), 'refresh');
                }
            } else {
                //Edit sakit tanpa ganti gambar
                $i = $this->input;

                $data = array(
                    'sakit_id'       => $id_sakit,
                    'sakit_nama'    => $i->post('sakit_nama'),
                    'sakit_status'    => $i->post('sakit_status'),
                    'sakit_lokasi'    => $i->post('sakit_lokasi'),
                    'sakit_tanggal'     => $i->post('sakit_tanggal'),
                    'sakit_waktu'   => $i->post('sakit_waktu'),
                    'sakit_keterangan' => $i->post('sakit_keterangan')
                );
                $this->skts->edit($data);
                $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah diedit</div>');
                redirect(base_url('Sakit_Super'), 'refresh');
            }
        }
        // End masuk database
        $data = array(
            'title'         => 'Edit sakit',
            'sakit'        =>  $sakit,
            'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
            'isi'         => 'absen_superadmin/sakitsuper/edit'
        );
        $this->load->view('template/wrapper', $data, FALSE);
    }

    public function delete($id_sakit)
    {
        // Proses hapus gambar
        $sakit = $this->skts->detail($id_sakit);
        unlink('images/sakit/' . $sakit->sakit_bukti);
        // End proses hapus 
        $data = array('sakit_id' => $id_sakit);
        $this->skts->delete($data);
        $this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Data telah dihapus</div>');
        redirect(base_url('Sakit_Super'), 'refresh');
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
        $this->pdf->load_view('absen_superadmin/sakitsuper/laporan_sakit', $data);
     }
 
     // export file dalam bentuk print 
     public function print()
     {
        $data['sakit'] = $this->skts->listing();
        
        $data['title'] = 'Laporan Data Karyawan Sakit';
        $this->load->view('absen_superadmin/sakitsuper/print', $data);
     }
 
     public function searchdata()
     {
        $keyword = $this->input->post('keyword');
        $data['title'] = 'Laporan Data Karyawan Sakit';
        $sakit = $this->skts->get_product_keyword($keyword);
         $data = array(
             'title' => 'sakit',
             'sakit'     => $sakit,
             'user' => $this->db->get_where('tbl_user', ['email' => $this->session->userdata('email')])->row_array(),
             'isi'   => 'absen_superadmin/sakitsuper/list'
         );
         $this->load->view('template/wrapper', $data, FALSE);
     }
}
