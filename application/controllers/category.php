<?php

/**
 * Description of category
 *
 * @author addin
 */
class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('categories');
    }

    function index() {
        $viewbag['view_page'] = 'category/index';
        $viewbag['view_model']['categories'] = $this->categories->get_all();
        $viewbag['title'] = 'Category';
        $this->load->view('template/mainview', $viewbag);
    }

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
     * Action form digunakan untuk add data ,edit data
     * dan juga proses menyimpan data (post).
     * 
     * @param type $id 
     */
    function form($id = NULL) {
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $key = $this->input->post('id');
            if (isset($key) && $key === "") {
                //add new data
                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description')
                );
                $this->categories->add($data);

                //untuk notifikasi
                $res = array(
                    'operation' => 'insert',
                    'is_success' => TRUE,
                    'message' => 'Save success.'
                );
                if ($this->db->affected_rows() < 1) {
                    $res['is_success'] = FALSE;
                    $res['message'] = 'Save failed!';
                }
                $this->session->set_flashdata($res);
                //end notifikasi

                redirect('category');
            }
            if (isset($key) && is_numeric($key)) {
                //update data
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
        } else {
            if (isset($id) && is_numeric($id)) {
                $viewbag['view_model']['category'] = $this->categories->get($id);
                $viewbag['title'] = 'Edit Category';
            } else {
                $viewbag['title'] = 'Add Category';
            }
            $viewbag['view_page'] = 'category/form';
            $this->load->view('template/mainview', $viewbag);
        }
    }

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
            }else{
                redirect('category');
            }
        }
    }
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */