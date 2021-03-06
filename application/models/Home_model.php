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
	public function show_service($service_use_id=""){
	    if(!empty($service_use_id)){
	        $this->db->where('id' , $service_use_id);
        }else{
            $this->db->where('user_id' , $_SESSION['user'][0]['id']);
        }
		$login=$this->db->get('service_use');
		return $login->result();
	}
    public function update_user_service($service_use_id,$access_token,$user_id,$app_id){
        if($app_id==1) {
            $data = array(
                'app1_c' => 1,
                'app_1_id' => $user_id,
                'app_1_token' => $access_token
            );
        }elseif($app_id==2){
            $data = array(
                'app2_c' => 1,
                'app_2_id' => $user_id,
                'app_2_token' => $access_token
            );
        }
        $this->db->where('id', $service_use_id);
        $result=$this->db->update('service_use', $data);
        return $result;
    }
}
