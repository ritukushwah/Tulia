<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Common_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->form_validation->CI =& $this;
        $this->name_exists_msg = 'Event name already exist';
        $this->validation_rules = array(
                                array(
                                    'field' => 'event_name',
                                    'label' => 'Event Name',
                                    'rules' => 'required|trim|min_length[2]|max_length[200]|strip_tags'
                                    )
        );  
    }

    /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index() {
        
        $data['title'] = "Event category";
        $data['parent'] = "events";
        $this->load->admin_render('event_list', $data, '');
    }

    function open_model() {
        $data['title'] = 'Add event';
        
        $this->load->view('add_event', $data);
    }

    //validation callback fn to check unique event name
    function _check_unique($str, $tb_data){
        $tb_arr = explode(".",$tb_data);
        $where = array($tb_arr[1]=>$str);
        $result = $this->common_model->getsingle($tb_arr[0], $where);
       
        if(!empty($result)){
            $this->form_validation->set_message('_check_unique',$this->name_exists_msg);
            return FALSE;
        }
        else{
            return TRUE;
        }     
    }
    

    public function add_event(){
        $v_rules = $this->validation_rules;
        $v_rules[] = array( 
                        'field' => 'event_name',
                        'label' => 'Event Name',
                        'rules' => 'required|trim|min_length[2]|max_length[30]|strip_tags|callback__check_unique[event_type.event_name]'
                    );  //we have check unique category name so redefining event_name rule here
        $this->form_validation->set_rules($v_rules);
        if ($this->form_validation->run() == FALSE){
            $messages = (validation_errors()) ? validation_errors() : ''; //validation error
            $response = array('status' => 0, 'message' => $messages);
        }
        else{

            $event_name = $this->input->post('event_name');
            $alias = make_alias($event_name, EVENT_TYPE); //make an alias of name(make name lowercase and replace all spaces with underscore)

            $dataInsert = array(
                'event_name' => $event_name,
                'alias' => $alias,
                'created_on' => datetime()
            );
            $eve_id = $this->common_model->insertData(EVENT_TYPE, $dataInsert);  //insert event data

            if($eve_id){
                $response = array('status' => 1, 'message' => 'Successfully Added', 'url' => base_url('admin/events')); //success msg
            }
            else{
                $response = array('status' => 0, 'message' => 'Something went wrong'); //Eve ID not found- error msg
            }  
        }  
        echo json_encode($response);
    }
    
 
    //Event list ajax
    public function get_event_list_ajax(){
        $this->load->model('events_model');
        $list = $this->events_model->get_list();       
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $post) { 
            // print_r($data);die;
            $action ='';
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = display_placeholder_text($post->event_name); 
         
            //echo $this_post->currency_symbol.' '.$this_post->budget_from.' - '.$this_post->budget_to;
            $clk_event = "deleteFunc('".EVENT_TYPE."' ,'id','$post->id ','admin/events/','delete')" ;

            $clk_edit =  "editFn('admin/events','edit','$post->id ');" ;
            
            $action .= '<a href="javascript:void(0)" onclick="'.$clk_edit.'" class="on-default edit-row table_action" title="Edit Event">'.EDIT_ICON.'</a>';
            
            $action .= '<a href="javascript:void(0)"  onclick="'.$clk_event.'" class="on-default edit-row table_action" title="Delete Event">'.DELETE_ICON.'</a>';

            $row[] = $action;
            $data[] = $row;
            //$_POST['draw']='';
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->events_model->count_all(),
                "recordsFiltered" => $this->events_model->count_filtered(),
                "data" => $data,
        );
        //output to json format
       echo json_encode($output);
    }
    

      //event delete
    public function delete() {
        $id = $this->input->post('id');  // delete id
        $table = $this->input->post('table'); //table name
        $id_name = 'id';  // table field name
        if (!empty($table) && !empty($id) && !empty($id_name)) {
            $where = array($id_name => $id); 
            $delete = $this->common_model->deleteData($table, $where); 
            if ($delete) {
                $response = array('status'=>1,'message'=>'Record deleted successfully'); //success
            } 
            else{
                $response = array('status'=>0,'message'=>'Record not found. Please try again'); //record not found
            }
        }
        else {
            $response = array('status'=>0,'message'=>'Something went wrong. Unable to delete record. Please try again'); //post data missing
        }
        echo json_encode($response); die;
    }

    //Edit event modal load
    public function edit() { 
        $data['title'] = 'Edit Event';
        $id = $this->input->post('id');
        $where = array('id'=>$id);
        $event_data = $this->common_model->getsingle(EVENT_TYPE, $where); 
    
        if(!empty($event_data)){
            $data['results'] = $event_data;
            $this->load->view('edit_event', $data);
        }
    }

     //update event
    public function update(){
        $v_rules = $this->validation_rules; //event validation  rules
        $this->form_validation->set_rules($v_rules); //set rules
        $where_id = $this->input->post('id');
        if ($this->form_validation->run($v_rules) == FALSE){
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        }
        else{
            //check for unique name skipping current event name
            $event_name = $this->db->escape($this->input->post('event_name'));
            $where = 'id != '.$where_id.' AND event_name = '.$event_name; 
            $result = $this->common_model->getsingle(EVENT_TYPE, $where);
            if(!empty($result)){
                $response = array('status' => 0, 'message' => $this->name_exists_msg);  //event name already exists
                echo json_encode($response); die;
            }
            
            $event_name = $this->input->post('event_name');
            $event_alias = make_alias($event_name, EVENT_TYPE); //make an alias of name(make name lowercase and replace all spaces with underscore)

            $update_data = array(
                'event_name' => $event_name,
                'alias' => $event_alias,
            );
   
            $update_where = array('id'=>$where_id);
            $eve_id = $this->common_model->updateFields(EVENT_TYPE, $update_data, $update_where);  //update category data
            $response = array('status' => 1, 'message' => ResponseMessages::getStatusCodeMessage(135), 'url'=>base_url('admin/events')); //success msg
            
        }
        
        echo json_encode($response);
    }





} //End class
