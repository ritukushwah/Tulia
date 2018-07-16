<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TableList extends CI_Model {

    //var $table , $column_order, $column_search , $order =  '';
    var $table = USERS;
    var $column_order = array(null, 'u.id', 'u.fullName','u.email','u.contactNumber','u.userType', 'u.image', 'u.status','cat.name'); //set column field database for datatable orderable
    var $column_search = array('u.fullName', 'u.email', 'u.contactNumber'); //set column field database for datatable searchable 
    var $order = array('u.id' => 'DESC');  // default order
    var $where = array();
    var $group_by = 'u.id'; 

    public function __construct(){
        parent::__construct();
    }
    
    public function set_data($where=''){
        $this->where = $where; 
    }

    private function _get_query()
    {
        $sel_fields = array_filter($this->column_order); 
        $this->db->select($sel_fields);
        $this->db->from(USERS .' as u');

        $this->db->join(USR_CAT_MAPPING. ' as usr', "usr.user_id = u.id","left"); //to get users category
        $this->db->join(CATEGORIES. ' as cat', "cat.id = usr.category_id ","left"); //to category details
       
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $emp) // loop column 
        {
			if(isset($_POST['search']['value']) && !empty($_POST['search']['value'])){
			$_POST['search']['value'] = $_POST['search']['value'];
		} else
			$_POST['search']['value'] = '';
		if($_POST['search']['value']) // if datatable send POST for search
		{
			if($i===0) // first loop
			{
				$this->db->group_start();
				$this->db->like(($emp), $_POST['search']['value']);
			}
			else
			{
				$this->db->or_like(($emp), $_POST['search']['value']);
			}

			if(count($this->column_search) - 1 == $i) //last loop
				$this->db->group_end(); //close bracket
		}
		$i++;
		}

        if(!empty($this->where))
            $this->db->where($this->where); 


        if(!empty($this->group_by)){
            $this->db->group_by($this->group_by);
        }
         

		if(isset($_POST['order'])) // here order processing
		{ 
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{ 
    		$order = $this->order; 
    		$this->db->order_by(key($order), $order[key($order)]);
		}
       
    }

    function get_list()
    {
        $this->_get_query();
		if(isset($_POST['length']) && $_POST['length'] < 1) {
			$_POST['length']= '10';
		} else
		$_POST['length']= $_POST['length'];
		
		if(isset($_POST['start']) && $_POST['start'] > 1) {
			$_POST['start']= $_POST['start'];
		}
        $this->db->limit($_POST['length'], $_POST['start']);
		//print_r($_POST);die;
        $query = $this->db->get(); //lq();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

}