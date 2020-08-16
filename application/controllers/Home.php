<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Home extends CI_Controller {
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
	public function index(){
        $authenticate=$this->login();
        if($authenticate == true) {
            $this->load->view('backend_user/index');
        }
    }
	public function show_list(){
        $authenticate=$this->login();
        if($authenticate == true) {
            $data['list'] = $this->Home_model->get();
            return $this->load->view('backend_user/list', $data);
        }
	}
	public function add_service($id){
        $authenticate=$this->login();
        if($authenticate == true) {
            $this->Home_model->add_services($id);
        }
	}
	public function show_service(){
        $authenticate=$this->login();
        if($authenticate == true) {
            $data['show_service'] = $this->Home_model->show_service();
            $id = array();
            foreach ($data['show_service'] as $service) {
                array_push($id, $service->service_id);
            }
            $data['show'] = array();
            foreach ($id as $key) {
                array_push($data['show'], $this->Home_model->get($key));
            }
            return $this->load->view('backend_user/my_list', $data);
        }
	}
	public function show_signle_service($id){
        $authenticate=$this->login();
        if ($authenticate == true) {
            $data['service'] = $this->Home_model->get($id);
            $data['app1'] = $this->Home_model->get_app($data['service'][0]->app1_id);
            $data['app2'] = $this->Home_model->get_app($data['service'][0]->app2_id);
            return $this->load->view('backend_user/show_service', $data);
        }
    }
}
