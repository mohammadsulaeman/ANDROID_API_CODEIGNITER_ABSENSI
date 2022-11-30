<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Kehadiranapi extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("Kehadiranapi_model");
        $this->load->database();
        date_default_timezone_set(time_zone);
    }

    function index_get()
    {
        $this->response("Api for kehadiran absensi", 200);
    }


    function register_kehadiran_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $image = $dec_data->hadir_photo;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "images/kehadiran/" . $namafoto;
        file_put_contents($path, base64_decode($image));
        $data_kehadiran = array(
            'hadir_nama' => $dec_data->hadir_nama,
            'hadir_phone' => $dec_data->hadir_phone,
            'hadir_lokasi' => $dec_data->hadir_lokasi,
            'hadir_waktu' => $dec_data->hadir_waktu,
            'hadir_tanggal' => $dec_data->hadir_tanggal,
            'hadir_status' => $dec_data->hadir_status,
            'hadir_latitude' => $dec_data->hadir_latitude,
            'hadir_longitude' => $dec_data->hadir_longitude,
            'hadir_photo' => $namafoto
        );
        $signup = $this->Kehadiranapi_model->signup($data_kehadiran);
        if ($signup) {
            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => 'data kehadiran berhasil disimpan!'
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


    public function hadirdata_get()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $hadirhome = $this->Kehadiranapi_model->hadir_karyawan();
        $message = [
            'code' => '200',
            'message' => 'success',
            'hadirhome' => $hadirhome,
        ];
        $this->response($message, 200);
    }
    
    public function serach_kehadiran_post(){
         if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
         $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
         $keyword = $this->input->post('keyword');
        $kehadiran = $this->Kehadiranapi_model->get_product_keyword($keyword,$dec_data->hadir_phone);
         $message = [
            'code' => '200',
            'message' => 'success',
            'kehadiran' => $kehadiran,
        ];
        $this->response($message, 200);
    }
}
