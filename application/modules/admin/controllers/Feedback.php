<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends Common_Controller {

    public function __construct() {
        parent::__construct();   
    }

    /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index() {
        
        $data['title'] = "Feedback";
        $data['parent'] = "feedback";
        
        $this->load->admin_render('feedback_list', $data, '');
    }
    
    /**
     * @method open_model
     * @description load model box
     * @return array
     */
   /* function open_model() {
        $data['title'] = 'Message';
        $this->load->view('show_message', $data);
    }*/
    

    //Edit category modal load
    public function show() {
        $data['title'] = 'Message';
        $id = $this->input->post('id');
        $where = array('id'=>$id);
        $feedback_data = $this->common_model->getsingle(FEEDBACK, $where);
        if(!empty($feedback_data)){
            $data['result'] = $feedback_data;
            $this->load->view('show_message', $data);
        }
    }



    //feedback list ajax
    public function get_feedback_list_ajax(){
        $this->load->model('feedback_model'); 
       
        $list = $this->feedback_model->get_list();  
        $data = array();
        $no = !empty($_POST['start']) ? $_POST['start'] : 0;
        foreach ($list as $post) { 
           
            $action ='';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = display_placeholder_text($post->name); 
            $row[] = display_placeholder_text($post->email); 
            $row[] = display_placeholder_text($post->subject); 
    

            $clk =  "showFn('admin/feedback','show','$post->id ');" ;
            
            $action .= '<a href="javascript:void(0)" onclick="'.$clk.'" class="on-default edit-row table_action" title="View Message">'.VIEW_ICON.'</a>';

            $row[] = $action;

            $data[] = $row;
            $_POST['draw']='';
        }

        $output = array(
                "draw" => $_POST['draw'], 
                "recordsTotal" => $this->feedback_model->count_all(),
                "recordsFiltered" => $this->feedback_model->count_filtered(),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    
  
    

} //End class
