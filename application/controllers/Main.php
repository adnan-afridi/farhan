<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

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

        $this->model = load_basic_model('profile');
        $this->curUser = currentuser_session();
    }

    public function index() {

        $curUser = currentuser_session();
        $userId = $curUser['user_id'];

        $data['relation'] = "";
        if ($this->input->get('id')) {
            $userId = $this->input->get('id');

//		VISITING USER ID
            $data['v_userID'] = $userId;
            $data['curUserId'] = $curUser['user_id'];

//            check relation
            $curUserId = $curUser['user_id'];
            $userModel = model_load_model('User_model');
            $relation = $userModel->check_relation($curUserId, $userId);
            $data['relation'] = $relation['confirm'];
        }


        $model = model_load_model('Profile_model');
        $data['profileData'] = $model->getUserInfo($userId);

        //POSTS
        $postsModel = model_load_model('Posts_model');
        $data['posts'] = $postsModel->getPosts($userId);

//        CONNECTIONS
        $userModel = model_load_model('User_model');
        $data['users'] = $userModel->get_users($userId);

//        RECENT ACTIVITY
        $userModel = model_load_model('User_model');
        $data['recentActivities'] = $userModel->recent_activity($userId);

//        FEELING
        $data['feeling'] = $curUser['feeling'];

        render_view('profile', $data);
    }

    public function get_connected() {


        $curUser = currentuser_session();
        $userId = $curUser['user_id'];
        $userModel = model_load_model('User_model');
        $data['users'] = $userModel->get_users($userId);

        render_view('get-connected.php', $data);
    }

    public function inspiration_board() {
        check_session();
        render_view('inspiration-board');
    }

    public function process_login() {
//     echo '<pre>';
//     print_r($this->db);exit;
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $where_user = array(
            'user_email' => $email,
            'password' => md5($password),
            'user_status' => '1'
        );
        $basicModal = load_basic_model('users');

        $result = $basicModal->get($where_user, 1);

        $loggedIn = FALSE;
        if (array_filter($result)) {
            $currentUserData = array(
                'user_id' => $result['user_id'],
                'first_name' => $result['first_name'],
                'last_name' => $result['last_name'],
                'user_email' => $result['user_email'],
                'user_role' => $result['user_role'],
                'feeling' => '2'
            );
            $loggedIn = true;
            $session_data = array(
                "currentUser" => $currentUserData,
                'loggedIn' => $loggedIn
            );
            $this->session->set_userdata($session_data);
//CHECK ASSESMENT
            $userModel = model_load_model('User_model');
            $userAssesment = $userModel->getUserAssesment();
//            print_r($userAssesment);exit;
            if ($userAssesment['assesment'] == 1) {
                redirect(base_url('Profile/timeline'));
            }
            else {
                $this->session->set_flashdata('error', 'Complete assesment first to activate your account.');
                $model = model_load_model('profile_model');
                $data['states'] = $model->getStates();
                $data['assesment'] = 0;
                $data['assesmentData'] = array(
                    'state' => "",
                    'city' => "",
                    'zip' => "",
                    'interest' => "",
                    'dob' => "",
                    'profession' => "",
                    'looking_to' => ""
                );
                render_view('assesment.php', $data);
            }
        }
        else {
            $this->session->set_flashdata('error', 'Username/password incorrect or inactive user.');
            redirect(base_url('Login'));
        }
    }

    public function register() {

        $allPost = $this->input->post(NULL, TRUE);
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($allPost) {
            $data['first_name'] = $allPost['first_name'];
            $data['last_name'] = $allPost['last_name'];
            $data['user_email'] = $allPost['user_email'];
            $data['password'] = $allPost['password'];
            $data['passconf'] = $allPost['passconf'];
        }
        else {
            $data['first_name'] = '';
            $data['last_name'] = '';
            $data['user_email'] = '';
            $data['password'] = '';
            $data['passconf'] = '';
        }
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {

            render_view('login', $data);
            return;
        }
        else {

            $password = $allPost['password'];
            $allPost['password'] = md5($allPost['password']);
            unset($allPost['passconf']);
            $basicModel = load_basic_model('users');
            $result = $basicModel->insert($allPost);
            $userId = $this->db->insert_id();


// email section

            $email_title = config_item('registration');

            $emailModel = load_basic_model('email_templates');
            $where_template = array(
                'template_title' => $email_title
            );

            $templateData = $emailModel->get($where_template, 1);

            $search = array(
                'LINK'
            );
            $email = $allPost['user_email'];
            $link = base_url('Users/activate/?id='.$userId);

            $replace = array(
                $link
            );
            $templateBody = str_replace($search, $replace, $templateData['template_body']);
            $email_data = array(
                'from' => config_item('email_from'),
                'username' => config_item('mailer_name'),
                'subject' => $templateData['template_title'],
                'message' => $templateBody,
                'to' => $email
            );


// end email section
            $email_result = email_send($email_data);

            if ($result > 0 && $email_result == TRUE)
                $this->session->set_flashdata('success', 'Follow email sent to activate your account.');
            else if ($result > 0 && $email_result == FALSE)
                $this->session->set_flashdata('success', 'Email sending failed, ask admin to activate your account.');
            else if ($result < 1 && $email_result == FALSE)
                $this->session->set_flashdata('error', 'Operation Failed try again.');

            redirect(base_url('Login'));
        }
    }

    public function left_menu_notifications() {

//        $CI = get_instance();
        $curUser = currentuser_session();
        $userId = $curUser['user_id'];
        //get new notifications
        $model = model_load_model('User_model');
        $notifications = $model->get_notifications($userId);

//TAGING
        $tagNotification = $model->get_tag_notifications();
        $tagCommentsNotification = $model->get_comments_tag_notifications();

//MESSAGES
        $pmModel = model_load_model('Pm_model');
        $msgNotification = $pmModel->get_messages_notifications();
//echo $this->db->last_query();exit;
//        print_r($msgNotification);
//        exit;

        if ($notifications) {
            ?>
            <!--notifications-->
            <div class="notification-detail">
                <ul>
                    <?php foreach ($notifications as $n) { ?>
                        <li>
                            <div class="user-thumbnail">
                                <a href="#"><img src="<?php echo $img = (!empty($n['profile_image'])) ? base_url()."assets/images/profile_images/".$n['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="" ></a>
                            </div>
                            <div class="user-detail">
                                <a href="#" class="username"><?php echo $n['first_name'].'&nbsp;'.$n['last_name']; ?></a>
                                <ul>
                                    <li><a href="javascript:void(0)" class="reply-request" con="<?php echo $n['ID']; ?>" action="confirm">Confirm</a></li>
                                    <li><a href="javascript:void(0)" class="reply-request" con="<?php echo $n['ID']; ?>" action="reject">Cancel Request</a></li>
                                </ul>
                            </div>
                        </li>
                    <?php } ?> 
                </ul>
            </div>
            <?php
        }
        else {
            ?>
            <div class="notification-detail no-notification">
                <ul>
                    <li>No pending requests</li>
                </ul>
            </div>
        <?php } ?>
        <!--end notifications-->

        <!--TAG notifications-->
        <?php if ($tagNotification || $tagCommentsNotification) { ?>
            <div class="tag-notification-detail">
                <ul>
                    <?php foreach ($tagNotification as $tn) { ?>
                        <li>
                            <a href="<?php echo base_url('Posts/view_post?id='.$tn['post_id']); ?>"><?php echo $tn['title']; ?></a>
                        </li>
                        <?php
                    }
                    foreach ($tagCommentsNotification as $tcn) {
                        ?>
                        <li>
                            <a href="<?php echo base_url('Posts/view_post?id='.$tcn['post_id']); ?>"><?php echo substr($tcn['comment_body'], 0, 50); ?></a>
                        </li>
                    <?php } ?> 
                </ul>
            </div>
            <?php
        }
        else {
            ?>
            <div class="tag-notification-detail no-notification">
                <ul>
                    <li>No notifications</li>
                </ul>
            </div>
        <?php } ?>

        <!--messages notifications-->
        <?php if ($msgNotification) { ?>
            <div class="msg-notification-detail">
                <ul>
                    <?php foreach ($msgNotification as $mn) {    ?>
                        <li>
                            <div class="user-thumbnail">
                                <img src="<?php echo $img = (!empty($mn['profile_image'])) ? base_url()."assets/images/profile_images/".$mn['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="" >
                            </div>
                            <div class="msg-body"><a href="<?php echo base_url('Pm/thread?i='.$mn['privmsg_author']); ?>"><?php echo substr($mn['privmsg_body'],0,20); ?></a></div>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url('Pm'); ?>" >All Messages</a>
                    </li>
                </ul>
            </div>
            <?php
        }
        else {
            ?>
            <div class="msg-notification-detail no-notification">
                <ul>
                    <li>No notifications</li>
                    <li>
                        <a href="<?php echo base_url('Pm'); ?>" >All Messages</a>
                    </li>
                </ul>
            </div>
        <?php } ?>
        <!--end TAG notifications-->
        <div class="user-action">
            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>assets/images/users-icon.png" class="tagNotification" alt="" title="You are tagged by">
                <?php if ($notifications) { ?>
                    <span></span>
                <?php } ?>
            </a>
            <a href="javascript:void(0)" class="msg-notification"><img src="<?php echo base_url(); ?>assets/images/message-icon.png" alt="" title="">
            <?php if ($msgNotification) { ?>
                    <span></span>
                <?php } ?>
            </a>
            <a href="javascript:void(0)" class="settings"><img src="<?php echo base_url(); ?>assets/images/setting-icon.png" alt="" title=""></a>
            <a href="javascript:void(0)" class="notification">
                <img src="<?php echo base_url(); ?>assets/images/notification-icon.png" alt="" title="">
                <?php if ($tagNotification || $tagCommentsNotification) { ?>
                    <span></span>
                <?php } ?>
            </a>
        </div>
        <?php
    }

}
