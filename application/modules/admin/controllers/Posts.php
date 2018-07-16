<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends Common_Controller {

    public function __construct() {
        parent::__construct();   
    }

    /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index() {
        
        $data['title'] = "Posts";
        $data['parent'] = "posts";
        $user_data = $this->common_model->getAllwhere(CATEGORIES, '', 'cat_order', $order_type = 'ASC', $select = 'all',$limit = '50', $offset = '0'); 
      
        $data['catList'] = $user_data['result'];
        $this->load->admin_render('post_list', $data, '');
    }
    
    //post detail
    public function detail($post_id) {
        if(empty($post_id)){
            //redirect to 404
        }
        
        //check if post ID exist
        
        $data['title'] = "Post Detail";
        $data['parent'] = "post_detail";
        $data['current_post_id'] = $post_id;
         
        $data['this_post'] = $this->common_model->get_post_detail(array('p.id'=>$post_id), false);
        $this->load->admin_render('post_detail', $data, '');
    }
    
    /**
     * @method open_model
     * @description load model box
     * @return array
     */
    function open_model() {
        $this->data['title'] = lang("add_user");
        $option = array('table' => ORGANIZATION,
            'select' => 'name,id'
        );
        $this->data['organization'] = $this->common_model->customGet($option);
        $this->load->view('add', $this->data);
    }

      //post list ajax
    public function get_post_list_ajax(){
        $this->load->model('posts_model'); 
       
        $list = $this->posts_model->get_list();       
        $data = array();
        $no = !empty($_POST['start']) ? $_POST['start'] : 0;
        foreach ($list as $post) { 
            // print_r($data);die;
            $action ='';
            $no++;
            $row = array();
            $row[] = $no;
            //$row[] = display_placeholder_text($post->cat_id); 
            $row[] = display_placeholder_text($post->event_name); 
            $row[] = display_placeholder_text($post->name); 
            $row[] = display_placeholder_text($post->event_date); 
            $row[] = display_placeholder_text($post->guest_number);
            if(!empty($post->budget_to)){
                $row[] = display_placeholder_text($post->budget_from.'-'.$post->budget_to); 
            }else{
                $row[] = display_placeholder_text($post->budget_from);
            }

            $link = base_url('admin/posts/detail/'.$post->id);
            $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View detail">'.VIEW_ICON.'</a>';
            $row[] = $action;
            $data[] = $row;
            $_POST['draw']='';
        }

        $output = array(
                "draw" => $_POST['draw'], 
                "recordsTotal" => $this->posts_model->count_all(),
                "recordsFiltered" => $this->posts_model->count_filtered(),
                "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }
    
    //Doing users list ajax
    public function get_doing_users_list_ajax(){
        $post_id = $_POST['post_id'];
        $table = POSTS;
        $key = 'id';
        $value = $post_id;
        $is_exist = $this->common_model->is_id_exist($table,$key,$value); //for checking the post_id whether it exist or not
        if($is_exist){
            $this->load->model('doing_users_list_model');
            $this->doing_users_list_model->set_data(array('doi.post_id'=>$post_id));
            $list = $this->doing_users_list_model->get_list();
            //lq(); pr($list);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $user) {
                // print_r($data);die;
                $action ='';
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = display_placeholder_text($user->fullName); 
                $row[] = display_placeholder_text($user->email); 
                $user_image = make_user_img_url($user->image); //make url from image name
                
                $row[] = '<img src="'.$user_image.'" class="img-circle" height="60">';
                $link  = base_url('admin/users/profile/'.$user->id);
                $action .= '<a href="'.$link.'"  class="on-default edit-row table_action" title="View user">'.VIEW_ICON.'</a>';
                $row[] = $action;
                $data[] = $row;
                //$_POST['draw']='';
            }

            $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->doing_users_list_model->count_all(),
                        "recordsFiltered" => $this->doing_users_list_model->count_filtered(),
                        "data" => $data,
            );
            //output to json format
           echo json_encode($output);
        }else{
            //redirect to 404
        }
    }


  
    

} //End class
