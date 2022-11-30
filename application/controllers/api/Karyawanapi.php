<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Karyawanapi extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class

        parent::__construct();
        $this->load->model("Karyawanapi_model");
        $this->load->database();
        date_default_timezone_set(time_zone);
    }

    function index_get()
    {
        $this->response("Api for karyawan absensi", REST_Controller::HTTP_OK);
    }

    function login_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $decode_data = json_decode($data);
        $reg_id = array(
            'karyawan_token' => $decode_data->karyawan_token
        );
        $condition = array(
            'password' => sha1($decode_data->password),
            'karyawan_phone' => $decode_data->karyawan_phone,
            
        );
        $cek_login = $this->Karyawanapi_model->get_data_karyawan($condition);
        $message = array();
        if ($cek_login->num_rows() > 0) {
            $this->Karyawanapi_model->edit_profile_token($reg_id, $decode_data->karyawan_phone);
            $get_karyawan = $this->Karyawanapi_model->get_data_karyawan($condition);
            $message = array(
                'code' => REST_Controller::HTTP_OK,
                'message' => 'found',
                'data' => $get_karyawan->result()
            );
            $this->response($message, REST_Controller::HTTP_OK);
        } else {
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'salah password atau nomor telepon',
                'data' => []
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    function forgotpass_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $dataupdate = array(
            'password' => sha1($dec_data->password),
        );
        $condition = array(
            'karyawan_idcard' => $dec_data->karyawan_idcard
        );
        $reset = $this->Karyawanapi_model->update($forgot,$condition);
        if ($reset) {
            $message = array(
                'code' => REST_Controller::HTTP_OK,
                'message' => 'success',
                'data' => 'data password berhasil disimpan!'
            );
            $this->response($message, REST_Controller::HTTP_OK);
        } else {
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'failed',
                'data' => ''
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    function register_karyawan_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $email = $dec_data->karyawan_email;
        $phone = $dec_data->karyawan_phone;

        $check_exist = $this->Karyawanapi_model->check_exist($email, $phone);
        $check_exist_phone = $this->Karyawanapi_model->check_exist_phone($phone);
        $check_exist_email = $this->Karyawanapi_model->check_exist_email($email);
        if ($check_exist) {
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'email and phone number already exist',
                'data' => []
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else
         if ($check_exist_phone) {
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'phone already exist',
                'data' => ''
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else if ($check_exist_email) {
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'email already exist',
                'data' => ''
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        } else {
            if ($dec_data->checked == "true") {
                $message = array(
                    'code' => REST_Controller::HTTP_OK,
                    'message' => 'next',
                    'data' => ''
                );
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $image = $dec_data->karyawan_photo;
                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
                $path = "images/karyawan/" . $namafoto;
                file_put_contents($path, base64_decode($image));
               $imagektp = $dec_data->karyawan_ktp;
            $fotoktp = time() . '-' . rand(0, 99999) . ".jpg";
            $pathktp = "images/ktp/" . $fotoktp;
            file_put_contents($pathktp, base64_decode($imagektp));
                $data_karyawan = array(
                    'karyawan_name' => $dec_data->karyawan_name,
                    'karyawan_phone' => $dec_data->karyawan_phone,
                    'karyawan_email' => $dec_data->karyawan_email,
                     'karyawan_status' => $dec_data->karyawan_status,
                    'karyawan_photo' => $namafoto, 
                    'karyawan_gender' => $dec_data->karyawan_gender,
                    'karyawan_ktp' => $fotoktp,
                    'karyawan_alamat' => $dec_data->karyawan_alamat,
                    'karyawan_lahir' => $dec_data->karyawan_lahir,
                     'karyawan_tempat' => $dec_data->karyawan_tempat,
                    'password' => sha1($dec_data->password),
                    'karyawan_code' => $dec_data->karyawan_code,
                    'karyawan_token' => time(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'karyawan_idcard' => $dec_data->karyawan_idcard
                );
                $signup = $this->Karyawanapi_model->signup($data_karyawan);
                if ($signup) {
                    $message = array(
                        'code' => REST_Controller::HTTP_OK,
                        'message' => 'success',
                        'data' => 'data karyawan berhasil di tambah'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = array(
                        'code' => REST_Controller::HTTP_NOT_FOUND,
                        'message' => 'failed',
                        'data' => ''
                    );
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        }
    }

    function karyawandatabynik_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $condition = array(
            'karyawan_idcard' => $dec_data->karyawan_idcard,
            'karyawan_id' => $dec_data->karyawan_id
            );
        $karyawan = $this->Karyawanapi_model->get_data_karyawan_nik($condition);
        $message = [
            'code' => REST_Controller::HTTP_OK,
            'message' => 'success',
            'karyawan' => $karyawan,
        ];
        $this->response($message, REST_Controller::HTTP_OK);
    }

    public function editkaryawan_post()
    {
        # code...
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $condition = array(
            'karyawan_idcard' => $dec_data->karyawan_idcard,
            'karyawan_id' => $dec_data->karyawan_id);
        $karyawan = $this->Karyawanapi_model->get_data_karyawan_nik($condition);
        if($karyawan->num_rows() > 0)
        {
            unlink('images/karyawan/'. $karyawan->karyawan_photo);

                $image = $dec_data->karyawan_photo;
                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
                $path = "images/karyawan/" . $namafoto;
                file_put_contents($path, base64_decode($image));

                
                $dataupdate = array(
                    'karyawan_name' => $dec_data->karyawan_name,
                    'karyawan_phone' => $dec_data->karyawan_phone,
                    'karyawan_email' => $dec_data->karyawan_email,
                    'karyawan_photo' => $namafoto,
                    'karyawan_status' => $dec_data->karyawan_status,
                    'update_at' => date('Y-m-d H:i:s')
                );
                $updatedatabyimage = $this->karyawanapi_model->update($dataupdate,$condition);
                if ($updatedatabyimage) {
                    # code...
                    $message = array(
                        'code' => REST_Controller::HTTP_OK,
                        'message' => 'success',
                        'data' => 'data karyawan berhasil di tambah'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                }else{
                    $message = array(
                        'code' => REST_Controller::HTTP_NOT_FOUND,
                        'message' => 'failed',
                        'data' => ''
                    );
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND); 
                }
        }else{
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'failed',
                'data' => ''
            );
            $this->response($message, REST_Controller::HTTP_NOT_FOUND); 
        }

    }


}
