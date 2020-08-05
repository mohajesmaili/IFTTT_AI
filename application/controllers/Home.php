<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
				$this->load->view('backend_user/index');
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
	public function show_list(){
		$data['list']=$this->Home_model->get();
		return $this->load->view('backend_user/list',$data);
	}
	public function add_service($id){
		$this->Home_model->add_services($id);
	}
	public function show_service(){
		$data['show_service']=$this->Home_model->show_service();
		$id=array();
		foreach ($data['show_service'] as $service){
			array_push($id,$service->service_id);
		}
		$data['show']=array();
		foreach ($id as $key){
			array_push($data['show'],$this->Home_model->get($key));
		}
		return $this->load->view('backend_user/my_list',$data);
	}
	public function show_signle_service($id){
		$data['service']=$this->Home_model->get($id);
		return $this->load->view('backend_user/show_service',$data);
	}
}
