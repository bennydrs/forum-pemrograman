<?php

class User extends CI_Controller {
    public $data = array();
    public $user;

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper(array('form', 'url'));
        $this->load->model('admin_model');
        $this->load->model('topic_model');
        $this->load->library('user_agent');
        $this->data['categories'] = $this->admin_model->category_get_all();      
    }

    public function join()
    {
        // event register button
        if ($this->input->post('btn-reg'))
        {
            $this->user_model->register();
            if ($this->user_model->error_count != 0) {
                $this->data['error']    = $this->user_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('user/join');
            }
        }

        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new user created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        $this->data['title']   = 'Daftar Member | Forum BDS';
        $this->load->model('admin_model');
        $this->template->load('template','user/join',$this->data);
      }

    public function login()
    {
        // event login button
        if ($this->input->post('btn-login'))
        {
            $this->load->model('user_model');
            $this->user_model->check_login();

            if ($this->input->post('username')){}
            
            if ($this->user_model->error_count != 0) {
                $this->data['error_login']    = $this->user_model->error;
            } else if($this->session->userdata('bds_user_level')== 'admin') {
                redirect('admin/index');
            }else {
                redirect('topic');
            }
        }

        $this->data['title']   = 'Halaman Login | Forum BDS';
        $this->template->load('template','user/login',$this->data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('user/login');
    }

    public function index()
    {
        $this->data = array("container" => "user/index" );
        $this->data['title']   = 'User Index | Forum BDS';
        $this->template->load('template','user/index',$this->data);
    }

    public function profil_edit($user_id)
    {
        if ($this->input->post('btn-save')) {

            $this->user_model->profil_edit();
            if ($this->user_model->error_count != 0) {
                $this->data['error']    = $this->user_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                
                redirect('profil_member/profil/'.$this->session->userdata('bds_user_id'));
                
            }
        }
        $this->data['user']    = $this->db->get_where('tb_user', array('user_id' => $user_id))->row();
        $this->load->model('admin_model');
        $this->data['title']   = 'Profil Edit | Forum BDS ';
        if($this->session->userdata('bds_user_roleid')==2){
            $this->template->load('admin/sidebar','user/profil_edit',$this->data);
        }else{
            $this->template->load('template','user/profil_edit',$this->data);
        }

    }

    public function foto_edit($user_id)
    {
        if ($this->input->post('btn-ganti')) {

            $this->user_model->foto_edit();
            if ($this->user_model->error_count != 0) {
                $this->data['error']    = $this->user_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                
                    redirect('profil_member/profil/'.$this->session->userdata('bds_user_id'));
                
            }
        }
        $this->data['user']    = $this->db->get_where('tb_user', array('user_id' => $user_id))->row();
    }

    public function password_edit($user_id)
    {

        if ($this->input->post('btn-save')) {
          $this->load->model('admin_model');
            $this->user_model->password_edit();
            if ($this->user_model->error_count != 0) {
                $this->data['error']    = $this->user_model->error;
            } else {
                $this->session->set_userdata('tmp_success_pass', 1);
                redirect('profil_member/profil/'.$this->session->userdata('bds_user_id'));
                
            }
        }

        

        $this->data['user']    = $this->db->get_where('tb_user', array('user_id' => $user_id))->row();
        $this->data['title']   = 'Ganti Password | Forum BDS ';
        if($this->session->userdata('bds_user_roleid')==2){
            $this->template->load('admin/sidebar','user/password_edit',$this->data);
        }else{
            $this->template->load('template','user/password_edit',$this->data);
        }       
    }

    public function set_pagination()
    {
        $this->page_config['first_link']       = 'First';
        $this->page_config['last_link']        = 'Last';
        $this->page_config['next_link']        = 'Next';
        $this->page_config['prev_link']        = 'Prev';
        $this->page_config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $this->page_config['full_tag_close']   = '</ul></nav></div>';
        $this->page_config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $this->page_config['num_tag_close']    = '</span></li>';
        $this->page_config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $this->page_config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $this->page_config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $this->page_config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $this->page_config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $this->page_config['prev_tagl_close']  = '</span>Next</li>';
        $this->page_config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $this->page_config['first_tagl_close'] = '</span></li>';
        $this->page_config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $this->page_config['last_tagl_close']  = '</span></li>';
    }


    public function post_delete($post_id)
    {
        $this->db->delete('tb_post', array('post_id' => $post_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('user/post_saya/'.$this->session->userdata('bds_user_id'));
    }

    // hapus topic di profil
    public function topic_delete($topic_id)
    {
        // delete topic
        $this->db->delete('tb_topic', array('topic_id' => $topic_id));

        // delete all posts on this topic
        $this->db->delete('tb_post', array('topic_id' => $topic_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('profil_member/profil/'.$this->session->userdata('bds_user_id'));

    }  
    //end

    // public function profil_view()
    // {

    //     $tmp_success = $this->session->userdata('tmp_success');
    //     if ($tmp_success != NULL) {
    //         // user updated
    //         $this->session->unset_userdata('tmp_success');
    //         $this->data['tmp_success'] = 1;
    //     }

    //     $tmp_success_del = $this->session->userdata('tmp_success_del');
    //     if ($tmp_success_del != NULL) {
    //         // user deleted
    //         $this->session->unset_userdata('tmp_success_del');
    //         $this->data['tmp_success_del'] = 1;
    //     }

    //     $this->db->order_by('username', 'asc');
    //     $this->data['title']   = 'Profil View | Forum BDS';
    //     $this->template->load('template','user/profil_view',$this->data);   
    // }
}
