<?php

/**
 * Description of category
 *
 * @author addin
 */
class Category extends CI_Controller {

    //the constructor
    public function __construct() {
        parent::__construct();
        $this->load->model('categories');
    }

    /**
     * index()
     * 
     * list view (tabular) to view the items as a list.
     * 
     */
    function index() {
        //start pagination with item_per_page feature. :D
        //item_per_page is limit of per page item.
        $limit = $this->input->post('item_per_page');
        if (!is_numeric($limit)) {
            //get item_per_page that maybe already saved in session.
            $limit = $this->session->userdata('item_per_page');
            if (!is_numeric($limit)) {
                //set default item_per_page if no saved item_per_page.
                $limit = 5;
            }
        }
        //make sure it is integer. 
        $limit = (int) $limit;
        //save the limit to session for future use.
        $this->session->set_userdata(array('item_per_page' => $limit));
        //some configuration to make pagination. Some other configuration are in
        //application/config/pagination.php
        $config['base_url'] = base_url() . 'category/index/';
        $config['total_rows'] = $this->categories->count();
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri_seg = 3;
        //offset is a number that represent a page. As configured, the number is
        //in uri_segment.
        $offset = $this->uri->segment($uri_seg);
        if (!is_numeric($offset)) {
            //it means, first page
            $offset = 0;
        }
        //initializing pagination
        $this->pagination->initialize($config);
        //creating pagination and ready to output
        $paging = $this->pagination->create_links();
        //end pagination with item_per_page feature
        
        //just for my own sake, i determine how things packed and sent to view.
        //the keys used here is my own standard.
        $viewbag['view_page'] = 'category/index';
        $viewbag['view_model']['categories'] = $this->categories->get_all($limit, $offset);
        $viewbag['view_model']['paging'] = $paging;
        $viewbag['view_model']['page_num'] = $offset;
        $viewbag['view_model']['item_per_page'] = $limit;
        $viewbag['title'] = 'Category';
        $this->load->view('template/mainview', $viewbag);
    }

    /**
     * view($id)
     * 
     * per item view or in other words, detailed view.
     * 
     * @param   int $id  id of the item to be viewed
     */
    function view($id) {
        if (isset($id) && is_numeric($id)) {
            $viewbag['view_model']['category'] = $this->categories->get($id);
            $viewbag['view_page'] = 'category/view';
            $viewbag['title'] = 'Category';
            $this->load->view('template/mainview', $viewbag);
        } else {
            redirect('category');
        }
    }

    /**
     * form($id)
     * 
     * method to handle all things that related to form, like add item form,
     * edit form. It handle the data posted from the form too. And the validation too.
     * That is why this method become so complicated. >__<"
     * 
     * @param int $id 
     */
    function form($id = NULL) {
        //a variable to keep the state of the validation. if it is true, there is
        //no validation error and state of the form to be sent back. if it is false,
        // so the error message and state of the form sent back.
        $validation = NULL;
        
        //check whether it is post request. if true, so it must be post data from
        //the form. it may be adding new item data or editing item data.
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            if (!isset($id) && !is_numeric($id)){
                //this $id is used to distinguish adding new item or editing
                //already exist item.
                $id = $key = $this->input->post('id');
            }
            
            //the validation configuration for each field in the form
            $this->form_validation->set_rules('name', 'Category Name', 'trim|required|max_length[32]|alpha_dash|xss_clean');
            $this->form_validation->set_rules('description', 'Category Description', 'trim|max_length[255]|htmlspecialchars|xss_clean');
            //executing the validation
            $validation = $this->form_validation->run();
            
            if ($validation === TRUE) {
                
                //add new data.
                if (isset($key) && $key === "") {
                    
                    $data = array(
                        'name' => $this->input->post('name'),
                        'description' => $this->input->post('description')
                    );
                    //insert the data to db.
                    $this->categories->add($data);

                    //just for my own sake, i determine such a mechanism to
                    //create notification data through session.
                    $res = array(
                        'operation' => 'insert',
                        'is_success' => TRUE,
                        'message' => 'Save success.'
                    );
                    //check if any rows are affected in db, that means the query success.
                    if ($this->db->affected_rows() < 1) {
                        $res['is_success'] = FALSE;
                        $res['message'] = 'Save failed!';
                    }
                    $this->session->set_flashdata($res);
                    //end notification

                    redirect('category');
                }
                
                //update data
                if (isset($key) && is_numeric($key)) {
                    
                    $data = array(
                        'name' => $this->input->post('name'),
                        'description' => $this->input->post('description')
                    );
                    $this->categories->update($key, $data);

                    //untuk notifikasi
                    $res = array(
                        'operation' => 'update',
                        'is_success' => TRUE,
                        'message' => 'Update success.'
                    );
                    if ($this->db->affected_rows() < 1) {
                        $res['is_success'] = FALSE;
                        $res['message'] = 'Update failed!';
                    }
                    $this->session->set_flashdata($res);
                    //end notifikasi

                    redirect('category');
                }
            }
        }
        
        if (isset($id) && is_numeric($id)) {
            //if these line executed, it must be edit mode but not yes posted.
            if (!isset($validation)){
                //if this line executed, it must be edit mode but not yes posted.
                //just showing the form with the data in each field.
                $viewbag['view_model']['category'] = $this->categories->get($id);
            }
            $viewbag['id'] = $id;
            $viewbag['title'] = 'Edit Category';
        } else {
            //if this line executed, it must be add new mode but not yes posted.
            $viewbag['title'] = 'Add Category';
        }
        
        $viewbag['view_page'] = 'category/form';
        $this->load->view('template/mainview', $viewbag);
    }

    /**
     * delete($id)
     * 
     * method to handle all things that related to deleton, like deletion confirmation
     * and actual deletion.
     * 
     * @param int $id 
     */
    function delete($id) {
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $key = $this->input->post('id');
            if (isset($key) && is_numeric($key)) {
                //delete data
                $this->categories->delete($key);

                //untuk notifikasi
                $res = array(
                    'operation' => 'delete',
                    'is_success' => TRUE,
                    'message' => 'Delete success.'
                );
                if ($this->db->affected_rows() < 1) {
                    $res['is_success'] = FALSE;
                    $res['message'] = 'Delete failed!';
                }
                $this->session->set_flashdata($res);
                //end notifikasi

                redirect('category');
            }
        } else {
            if (isset($id) && is_numeric($id)) {
                $viewbag['view_model']['category'] = $this->categories->get($id);
                $viewbag['view_page'] = 'category/delete_confirm';
                $viewbag['title'] = 'Delete Category';
                $this->load->view('template/mainview', $viewbag);
            } else {
                redirect('category');
            }
        }
    }

}

/* End of file category.php */
/* Location: ./application/controllers/category.php */