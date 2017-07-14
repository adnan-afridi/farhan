<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public $model;
    public $curUser;

    function __construct() {
        parent::__construct();
        $this->model = load_basic_model('comments');
        $this->curUser = currentuser_session();
    }

    public function index() {
        $model = model_load_model('Profile_model');
        $data['profileData'] = $model->getUserInfo($this->curUser['user_id']);
        render_view('profile', $data);
    }

    public function delete_comment() {
        $commentId = $this->input->post('comment');

        $model = load_basic_model('comments');
        $result = $model->delete(array('comment_id' => $commentId));
        if ($result > 0) {
            $result = $model->delete(array('parent_id' => $commentId));
            $postBack = array('msg' => 1);
        } else {
            $postBack = array('msg' => 0);
        }
        echo json_encode($postBack);
        exit;
    }

    public function new_comment() {

        $allPosts = $this->input->post(NULL, TRUE);
        $userId = $this->curUser['user_id'];

//        taging
        $tagUsers = $allPosts['tagUser'];
//        remove duplicates
        $tagUsers = explode(',', $tagUsers);
        $tagUsers = array_unique($tagUsers);

        $data = array(
            'post_id' => $allPosts['postId'],
            'user_id' => $userId,
            'comment_body' => $allPosts['comment'],
            'parent_id' => $allPosts['parent']
        );
        $result = $this->model->insert($data);
        $commentId = $this->db->insert_id();
        if ($result > 0) {

//   TAGING
            foreach ($tagUsers as $i => $taguserId) {
                $dataTag[] = array(
                    'comment_id' => $commentId,
                    'user_id' => $taguserId,
                );
            }
//           print_r($dataTag);exit;
            $tagModel = load_basic_model('tag_comments');
            $tagModel->insert_batch($dataTag);


            $comment = "<li>".$this->curUser['first_name'].": ".$allPosts['comment']."</li>";
//            $postBack = array('msg' => '1', 'comment' => $comment);
            //
            $profileModel= model_load_model('Profile_model');
            $userInfo = $profileModel->getUserInfo($userId);
            $template = '';
            $template .= '<div class="row comment-row" id="'.$commentId.'">';
            $template .= '<a class="delete comment-del hidden" href="javascript:void(0)">x</a>';
            $template .= '<div class="profile-img">';
            $template .= '<img src="'.base_url().'assets/images/profile_images/'.$userInfo['profile_image'].'" alt="" title="">';
            $template .= '</div>';
            $template .= '<div class="block-content">';
            $template .= '<a href="javascript:void(0)">'.$userInfo['first_name'].':</a>';
            $template .= '<span>'.$allPosts['comment'].'</span>';
            $template .= '<ul>';
            $template .= '<li><img src="'.base_url().'assets/images/like-img2.png" alt="" title=""><a href="javascript:void(0)">Like</a></li>';
            $template .= '<li>';
            $template .= '<a href="javascript:void(0)" class="comment-reply">Reply</a>';

            $template .= '</li>';
            $template .= '<div style="clear:both"></div>';
            $template .= '</ul>';
            $template .= '</div>';
            $template .= '<div style="clear:both"></div>';
            $template .= '</div>';
            
            $postBack = array('msg' => '1', 'comment' => $template);
        } else {
            $postBack = array('msg' => '0');
        }
        echo json_encode($postBack);
        exit;
//        print_r($allPosts);exit;
//        $model = model_load_model('Profile_model');
//        $data['profileData'] = $model->getUserInfo($this->curUser['user_id']);
//        render_view('profile', $data);
    }

}
