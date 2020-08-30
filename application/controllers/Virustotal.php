<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Virustotal extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Home_model');
    }
    public function login(){
        if(empty($_POST)){
            if(empty($_SESSION['user'])){
                $this->load->view('backend_user/login');
            }else{
                return true;
            }
        }else{
            $status=$this->Home_model->check_user($_POST);
            if($status==true) {
                $_SESSION["user"] = $status;
                $this->load->view('backend_user/index');
            }else{
                $this->load->view('backend_user/login');
            }
        }
    }
    public function app_connect($service_app_id,$service_use_id){
        $authenticate=$this->login();
        if ($authenticate == true) {
            $update = $this->Home_model->update_user_service($service_use_id,'','',$service_app_id);
            if($update==true){
                echo "<script>alert('اتصال با موفقیت انجام شد')</script>";
            }
        }
    }
    public function auth($file_link){
        $api_key='7d2df3e0ddd5cafe6f813439340013727b6ad459f2e9f30c9df46ac2e9543762';
        $data=array(
            'apikey'=>$api_key,
            'file'=>$file_link,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.virustotal.com/vtapi/v2/file/scan");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $resource_id=$result['resource'];
        $get_result_file=file_get_contents("https://www.virustotal.com/vtapi/v2/file/report?apikey=".$api_key."&resource=".$resource_id."");
        $get_result_file = json_decode($get_result_file, true);
        var_dump($get_result_file['scans']['ESET-NOD32']['detected']);
    }
}
?>