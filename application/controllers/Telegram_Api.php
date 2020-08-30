<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Telegram_Api extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Telegram');
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
        $file = fopen(__DIR__.'/data/Log.txt', "w");
        fwrite($file, $service_app_id);
        fwrite($file, "\n");
        fwrite($file, $service_use_id);
        fclose($file);
        $authenticate=$this->login();
        if ($authenticate == true) {
            $bot = new Telegram();
            $bot->setWebhook('https://mohajesmaili.ir/index.php/Telegram_Api/get_updates/');
            redirect('http://t.me/IFTTTAI_bot');

        }
    }

    public function get_updates()
    {
        $bot=new Telegram();
        $result=$bot->getData();
        $chat_id = $result['message']['chat']['id'];
        //ob_start();
        //var_dump($result);
        //file_put_contents(__DIR__.'/Log.txt',ob_get_contents());
        //die;
        $file = fopen(__DIR__.'/data/Log.txt', "r");
        $service_app_id=fgets($file);
        $service_use_id=fgets($file);
        fclose($file);
        $get_reply=$this->Home_model->show_service('',$chat_id,8);
        if($get_reply[0]->app_1_id==$chat_id){
            if($get_reply[0]->app_1_reply==1){

            }
        }elseif($get_reply[0]->app_2_id==$chat_id){
            if($get_reply[0]->app_2_reply==1){
                $file_id=$result['message']['photo']['0']['file_id'];
                $link=APPPATH.'views/telegram_img/'.$chat_id.".jpg";

                $file = $bot->getFile($file_id);
                $bot->downloadFile($file['result']['file_path'],$link);
                $text="فایل توسط virus scan در حال پردازش است";
                $content = array('chat_id' => $chat_id, 'text' => $text);
                $bot->sendMessage($content);
                $test=$this->Home_model->update_user_service($service_use_id,null,$chat_id,$service_app_id,0);

                $virus_scan=file_get_contents("https://mohajesmaili.ir/index.php/Virustotal/auth/".$link."");
                $text="در نتیجه اسکن فایل به وسیله آنتی ویروس nod32 نتیجه".$virus_scan."برگشت داده شده است";
                $content = array('chat_id' => $chat_id, 'text' => $text);
                $bot->sendMessage($content);
            }
        }

        if($result['message']['text']=='/start'){
            $text='به ربات IFTTT خوش آمدید';
            $this->Home_model->update_user_service($service_use_id,null,$chat_id,$service_app_id);
            $content = array('chat_id' => $chat_id, 'text' => $text);
            $bot->sendMessage($content);
        }elseif($result['message']['text']=="/getlast"){
            $get_inf=$this->Home_model->show_service('',$chat_id);
            if($get_inf[0]->app_1_id==$chat_id){
                $service_app_id=2;
            }else{
                $service_app_id=1;
            }
            $service_use_id=$get_inf[0]->id;
            $last_pic_url=file_get_contents("https://mohajesmaili.ir/index.php/instagram/get_signle_media/$service_app_id/$service_use_id");
            //$img = curl_file_create($last_pic_url,'image/jpg');
            $content = array('chat_id' => $chat_id, 'text' => $last_pic_url );
            $bot->sendMessage($content);
        }elseif($result['message']['text']=="/getall") {
            $get_inf=$this->Home_model->show_service('',$chat_id);
            if($get_inf[0]->app_1_id==$chat_id){
                $service_app_id=2;
            }else{
                $service_app_id=1;
            }
            $service_use_id=$get_inf[0]->id;
            $last_pic_url=file_get_contents("https://mohajesmaili.ir/index.php/instagram/get_media/$service_app_id/$service_use_id");
            $last_pic_url = explode(',',$last_pic_url);
            //$count=count($last_pic_url);
            foreach ($last_pic_url as $all_url) {
                $content = array('chat_id' => $chat_id, 'text' => $all_url);
                $bot->sendMessage($content);
            }
        }elseif($result['message']['text']=="/scanfile"){
            $test=$this->Home_model->update_user_service($service_use_id,null,$chat_id,$service_app_id,1);
            $text = "لطفا فایل را ارسال نمایید:";
            $content = array('chat_id' => $chat_id, 'text' => $text);
            $bot->sendMessage($content);
        }

    }
}
?>