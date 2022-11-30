<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class newsapi extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("newsapi_model");
        $this->load->database();
        date_default_timezone_set(time_zone);
    }

    function index_get()
    {
        $this->response("Api for news absensi",200);
    }

    
    function register_news_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $image = $dec_data->news_photo;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "images/news/" . $namafoto;
        file_put_contents($path, base64_decode($image));

        $data_news = array(
            'news_id' => $dec_data->news_id,
            'news_nama' => $dec_data->news_nama,
            'news_tanggal' => $dec_data->news_tanggal,
            'news_status' => $dec_data->news_status,
            'news_create' => $dec_data->news_create,
            'news_photo' => $namafoto
        );
        $signup = $this->newsapi_model->signup($data_news);
        if ($signup) {
            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => 'news berhasi ditambahkan!'
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

   public function newsdata_get(){
    $news = $this->newsapi_model->news_karyawan();
    $message = [
        'code' => '200',
        'message' => 'success',
        'news' => $news,
    ];
    $this->response($message, 200);
  }
}
