<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
// use namespace
use Restserver\Libraries\REST_Controller;
class Pulangapi extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("Pulangapi_model");
        $this->load->database();
        date_default_timezone_set(time_zone);
    }

    function index_get()
    {
        $this->response("Api for pulang absensi",200);
    }

    
    function register_pulang_post()
    {
       if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $image = $dec_data->pulang_bukti;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "images/pulang/" . $namafoto;
        file_put_contents($path, base64_decode($image));
        $data_pulang = array(
            'pulang_nama' => $dec_data->pulang_nama,
            'pulang_phone' => $dec_data->pulang_phone,
            'pulang_lokasi' => $dec_data->pulang_lokasi,
            'pulang_waktu' => $dec_data->pulang_waktu,
            'pulang_tanggal' => $dec_data->pulang_tanggal,
            'pulang_status' => $dec_data->pulang_status,
            'pulang_latitude' => $dec_data->pulang_latitude,
            'pulang_longitude' => $dec_data->pulang_longitude,
            'pulang_bukti' => $namafoto
        );
        $signup = $this->Pulangapi_model->signup($data_pulang);
        if ($signup) {
            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => 'data pulang karyawan berhasil disimpan!'
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'code' => '404',
                'message' => 'failed',
                'data' => ''
            );
            $this->response($message, 404);
        }
    
    }

     public function pulangdata_get()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $keluarhome = $this->Pulangapi_model->pulang_karyawan();
        $message = [
            'code' => '200',
            'message' => 'success',
            'keluarhome' => $keluarhome,
        ];
        $this->response($message, 200);
    }
      public function serach_pulang_get(){
         if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
         $keyword = $this->input->post('keyword');
        $pulang = $this->Kehadiranapi_model->get_product_keyword($keyword, $dec_data->pulang_phone);
         $message = [
            'code' => '200',
            'message' => 'success',
            'pulang' => $pulang,
        ];
        $this->response($message, 200);
    }
}
