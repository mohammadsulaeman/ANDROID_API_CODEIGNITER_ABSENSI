<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
// use namespace
use Restserver\Libraries\REST_Controller;
class Perijinanapi extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("Perijinanapi_model");
        $this->load->database();
        date_default_timezone_set(time_zone);
    }

    function index_get()
    {
        $this->response("Api for Perijinan absensi",200);
    }

    
    function register_Perijinan_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
         $image = $dec_data->perijinan_bukti;
                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
                $path = "images/perijinan/" . $namafoto;
                file_put_contents($path, base64_decode($image));
            $data_Perijinan = array(
                'perijinan_nama' => $dec_data->perijinan_nama,
                'perijinan_phone' => $dec_data->perijinan_phone,
                'perijinan_keterangan' => $dec_data->perijinan_keterangan,
                'perijinan_lokasi' => $dec_data->perijinan_lokasi,
                'perijinan_waktu' => $dec_data->perijinan_waktu,
                'perijinan_tanggal' => $dec_data->perijinan_tanggal,
                'perijinan_status' => $dec_data->perijinan_status,
                'perijinan_latitude' => $dec_data->perijinan_latitude,
                'perijinan_longitude' => $dec_data->perijinan_longitude,
                'perijinan_bukti' => $namafoto
            );
            $signup = $this->Perijinanapi_model->signup($data_Perijinan);
            if ($signup) {
                $message = array(
                    'code' => '200',
                    'message' => 'success',
                    'data' => 'data perizinan berhasil disimpan!'
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'code' => '201',
                    'message' => 'failed',
                    'data' => ''
                );
                $this->response($message, 201);
            }
        
    }
    
    //mengambil semua data
    public function ijindata_get(){
    
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $ijin = $this->Perijinanapi_model->perijinan_karyawan();

        $message = [
            'code' => '200',
            'message' => 'success',
            'ijin' => $ijin,
        ];
        $this->response($message, 200);
    }
    
      public function serach_perijinan_post(){
         if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
         $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
         $keyword = $this->input->post('keyword');
        $perijinan = $this->Perijinanapi_model->get_product_keyword($keyword, $dec_data->perijinan_phone);
        if($perijinan){
             $message = [
            'code' => '200',
            'message' => 'success',
            'perijinan' => $perijinan,
        ];
        $this->response($message, 200);
        }else{
             $message = [
            'code' => '201',
            'message' => 'gagal',
            'data'=> '',
        ];
        $this->response($message, 201);
        }
        
    }
}
