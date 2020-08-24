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
    public function app_connect(){
        $authenticate=$this->login();
        if ($authenticate == true) {
            $bot = new Telegram();
            $bot->setWebhook('https://mohajesmaili.ir/index.php/Telegram_Api/get_updates/');

        }
    }

    public function get_updates()
    {
        $bot=new Telegram();
        $result=$bot->getData();
        $text = $result['message'] ['text'];
        $chat_id = $result['message'] ['chat']['id'];
        $content = array('chat_id' => $chat_id, 'text' => 'Test');
        $bot->sendMessage($content);
    }

}
?>