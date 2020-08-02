<?php


class Home_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function check_user($data){
		$this->db->where('username' , $data['username']);
		$this->db->where('password' , $data['password']);
		$login=$this->db->get('users');
		return $login->result_array();
	}
}
