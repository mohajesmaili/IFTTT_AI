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
}
