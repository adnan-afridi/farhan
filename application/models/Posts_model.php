<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts_model extends CI_Model {

    public function getComments($postId, $parentId) {
       
        $curUser = currentuser_session();
        $this->db->select('*');
        $this->db->from('comments');
//        $this->db->where('user_id', $curUser['user_id']);; 
        $this->db->where('post_id', $postId);
        $this->db->where('parent_id', $parentId);
        $this->db->order_by('created', 'ASC');
        $result = $this->db->get()->result_array();
//            if($parentId != 0){
//                print_r($result);exit;
//    }
        return $result;
    }

    public function getSubComments($postId, $parentId) {
        $curUser = currentuser_session();
        $this->db->select('*');
        $this->db->from('comments');
        $this->db->where('user_id', $curUser['user_id']);
        $this->db->where('post_id', $postId);
        $this->db->where('parent_id', $parentId);
        $this->db->order_by('created', 'ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getPosts($userId) {
        
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('user_id', $userId);
        $this->db->order_by('created', 'ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getPost($post_id) {
        $curUser = currentuser_session();
        $this->db->select('*');
        $this->db->from('posts');
//        $this->db->where('user_id', $curUser['user_id']);
        $this->db->where('post_id', $post_id);
        $result = $this->db->get()->result_array();
        return $result;
    }

}
