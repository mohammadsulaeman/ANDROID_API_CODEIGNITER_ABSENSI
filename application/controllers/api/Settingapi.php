<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Settingapi extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("settingapi_model");
        $this->load->database();
        date_default_timezone_set(time_zone);
    }

    public function index_get()
    {
        $this->response("Api for setting absensi", 200);
    }

    public function settingdata_get()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $setting = $this->settingapi_model->setting_karyawan();
        $message = [
            'code' => '200',
            'message' => 'success',
            'setting' => $setting,
        ];
        $this->response($message, 200);
    }
}
