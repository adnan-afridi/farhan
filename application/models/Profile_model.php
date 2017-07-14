<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile_model extends CI_Model {

    public function getUserInfo($user_id = '') {
        $this->db->select('*');
        $this->db->from('users u');
        $this->db->join('profile p','p.user_id = u.user_id','LEFT');
        $this->db->where('u.user_id',$user_id);
        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();exit;
        return $result[0];
    }

  
    public function getStates() {
        $this->db->select('*');
        $this->db->from('states');
        $this->db->where('country_id',231);//231 for united states
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getCities($stateId) {
        $this->db->select('*');
        $this->db->from('cities');
        $this->db->where('state_id',$stateId);
        $result = $this->db->get()->result_array();
        return $result;
    }

	function select_where($select,$table,$where)
	{
		$this->db->select( $select );
		$this->db->from( $table );
		$this->db->where( $where );
		return $this->db->get();
}
	
	
	
	public function get_signle_value($where,$find,$table){
		$this->db->select($find);
		$this->db->from($table);
		$this->db->where($where);
		$result = $this->db->get();
		if($result->num_rows()>0)
		{
			$row	=	$result->row();
			return $row->$find;
		}
		else
		{
			return '';
		}
	}
	
	function common_update($table,$field,$val,$array){
		$this->db->where($field, $val);
		$this->db->update($table, $array);
	}

}
