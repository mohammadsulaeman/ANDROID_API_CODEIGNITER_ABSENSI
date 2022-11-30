<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Supportapi extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("supportapi_model");
        $this->load->database();
        date_default_timezone_set(time_zone);
    }

    public function index_get()
    {
        $this->response("Api for support absensi", 200);
    }

    public function supportdata_get()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $support = $this->supportapi_model->support_karyawan();
        $message = [
            'code' => '200',
            'message' => 'success',
            'support' => $support,
        ];
        $this->response($message, 200);
    }
}
