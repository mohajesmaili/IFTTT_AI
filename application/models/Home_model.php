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
	public function get($id=null){
		if(!empty($id))	{
				$this->db->where('id',$id);
		}
		$login=$this->db->get('service');
		return $login->result();

	}
	public function get_app($id=null){
        if(!empty($id))	{
            $this->db->where('id',$id);
        }
        $login=$this->db->get('application');
        return $login->result();
    }
	public function add_services($id){
		$data = array(
			'service_id' => $id,
			'user_id' =>$_SESSION['user'][0]['id'],
			'app1_c' => 0,
			'app1_c' => 0,
		);
		$this->db->insert('service_use', $data);
	}
	public function show_service(){
		$this->db->where('user_id' , $_SESSION['user'][0]['id']);
		$login=$this->db->get('service_use');
		return $login->result();
	}
}
