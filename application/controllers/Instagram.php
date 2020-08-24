<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Instagram extends CI_Controller
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
        $_SESSION["service_app_id"]=$service_app_id;
        $_SESSION["service_use_id"]=$service_use_id;
        $authenticate=$this->login();
        if ($authenticate == true) {
            $app_id='3320781021277787';
            $url="https://api.instagram.com/oauth/authorize?client_id=$app_id&redirect_uri=https://mohajesmaili.ir/index.php/Instagram/auth&scope=user_profile,user_media&response_type=code";
            redirect($url);
        }
    }
    public function auth(){
        $authenticate=$this->login();
        if ($authenticate == true) {
            if(!empty($_GET)){
                $app_id='3320781021277787';
                $app_secret='3ea98fbe78c718bcf71dc514139d7ef1';
                $data=array(
                    'client_id'=>$app_id,
                    'client_secret'=>$app_secret,
                    'grant_type'=>'authorization_code',
                    'redirect_uri'=>'https://mohajesmaili.ir/index.php/Instagram/auth',
                    'code'=>$_GET['code'],
                );
                $ch=curl_init();
                curl_setopt($ch, CURLOPT_URL,'https://api.instagram.com/oauth/access_token');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_VERIFYPEER, false);

                $result= curl_exec($ch);
                $result= json_decode($result,true);
                curl_close($ch);
                $_SESSION['Instagram_data']=$result;
                return $this->long_auth();
            }
        }
    }
    public function long_auth(){
        $authenticate=$this->login();
        if ($authenticate == true) {
            $app_id='3320781021277787';
            $app_secret='3ea98fbe78c718bcf71dc514139d7ef1';
            $long_a="https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=$app_secret&access_token=".$_SESSION['Instagram_data']['access_token']."";
            $result= json_decode(file_get_contents($long_a),true);
            if(!empty($result)){
               $update = $this->Home_model->update_user_service($_SESSION["service_use_id"],$result['access_token'],$_SESSION['Instagram_data']['user_id'],$_SESSION['service_app_id']);
               if($update==true){
                   echo "<script>alert('اتصال با موفقیت انجام شد')</script>";
               }
            }
        }
    }
    public function get_media_id(){
        $authenticate=$this->login();
        if ($authenticate == true) {
            $url='https://graph.instagram.com/me/media?fields=id,username&access_token='.$_SESSION["Instagram_data"]["access_token"].'';
            $result= json_decode(file_get_contents($url),true);
            return $result['data']['0']['id'];
        }
    }
    public function get_media(){
        $authenticate=$this->login();
        if ($authenticate == true) {
            $url='https://graph.instagram.com/'.$this->get_media_id().'?fields=id,media_type,media_url,username,timestamp&access_token='.$_SESSION["Instagram_data"]["access_token"].'';
            echo $url;
        }
    }
}
?>