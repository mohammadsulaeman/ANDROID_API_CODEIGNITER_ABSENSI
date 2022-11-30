<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
// use namespace
use Restserver\Libraries\REST_Controller;

class Sakitapi extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("Sakitapi_model");
        $this->load->database();
        date_default_timezone_set(time_zone);
    }

    function index_get()
    {
        $this->response("Api for sakit absensi", 200);
    }


    function register_sakit_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $image = $dec_data->sakit_bukti;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "images/sakit/" . $namafoto;
        file_put_contents($path, base64_decode($image));
        $data_sakit = array(
            'sakit_nama' => $dec_data->sakit_nama,
            'sakit_phone' => $dec_data->sakit_phone,
            'sakit_keterangan' => $dec_data->sakit_keterangan,
            'sakit_lokasi' => $dec_data->sakit_lokasi,
            'sakit_waktu' => $dec_data->sakit_waktu,
            'sakit_tanggal' => $dec_data->sakit_tanggal,
            'sakit_status' => $dec_data->sakit_status,
            'sakit_latitude' => $dec_data->sakit_latitude,
            'sakit_longitude' => $dec_data->sakit_longitude,
            'sakit_bukti' => $namafoto
        );
        $signup = $this->Sakitapi_model->signup($data_sakit);
        if ($signup) {
            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => 'data karyawan sakit berhasil disimpan!'
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

    public function sakitdata_get()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $sakithome = $this->Sakitapi_model->sakit_karyawan();
        $message = [
            'code' => '200',
            'message' => 'success',
            'sakithome' => $sakithome,
        ];
        $this->response($message, 200);
    }
      public function serach_sakit_get(){
         if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
         $keyword = $this->input->post('keyword');
        $sakit = $this->Kehadiranapi_model->get_product_keyword($keyword,$dec_data->sakit_phone);
         $message = [
            'code' => '200',
            'message' => 'success',
            'sakit' => $sakit,
        ];
        $this->response($message, 200);
    }
}
