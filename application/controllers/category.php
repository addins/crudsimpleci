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
        $limit = $this->input->post('item_per_page');
        if (!is_numeric($limit)) {
            $limit = $this->session->userdata('item_per_page');
            if (!is_numeric($limit)) {
                $limit = 5;
            }
        }

        $limit = (int) $limit;
        $this->session->set_userdata(array('item_per_page' => $limit));

        $config['base_url'] = base_url() . 'category/index/';
        $config['total_rows'] = $this->categories->count();
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uri_seg = 3;

        $offset = $this->uri->segment($uri_seg);
        if (!is_numeric($offset)) {
            $offset = 0;
        }

        $config['full_tag_open'] = '<div class="pagination-centered"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = '&inodot;&blacktriangleleft;';
        $config['first_tag_open'] = '<li class="arrow">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '&blacktriangleright;&inodot;';
        $config['last_tag_open'] = '<li class="arrow">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&blacktriangleright;';
        $config['next_tag_open'] = '<li class="arrow">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&blacktriangleleft;';
        $config['prev_tag_open'] = '<li class="arrow">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $paging = $this->pagination->create_links();

        $viewbag['view_page'] = 'category/index';
        $viewbag['view_model']['categories'] = $this->categories->get_all($limit, $offset);
        $viewbag['view_model']['paging'] = $paging;
        $viewbag['view_model']['page_num'] = $offset;
        $viewbag['view_model']['item_per_page'] = $limit;
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
        $validation = NULL;
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            if (!isset($id) && !is_numeric($id))
                $id = $key = $this->input->post('id');
            $this->form_validation->set_rules('name', 'Category Name', 'trim|required|max_length[32]|alpha_dash|xss_clean');
            $this->form_validation->set_rules('description', 'Category Description', 'trim|max_length[255]|htmlspecialchars|xss_clean');
            $validation = $this->form_validation->run();
            if ($validation === TRUE) {

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
            }
        }
        if (isset($id) && is_numeric($id)) {
            if (!isset($validation))
                $viewbag['view_model']['category'] = $this->categories->get($id);
            $viewbag['id'] = $id;
            $viewbag['title'] = 'Edit Category';
        } else {
            $viewbag['title'] = 'Add Category';
        }
        $viewbag['view_page'] = 'category/form';
        $this->load->view('template/mainview', $viewbag);
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
            } else {
                redirect('category');
            }
        }
    }

}

/* End of file category.php */
/* Location: ./application/controllers/category.php */