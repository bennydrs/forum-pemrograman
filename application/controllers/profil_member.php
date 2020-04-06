<?php

class Profil_member extends CI_Controller
{
    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        
        $this->load->library('user_agent');
        $this->load->model('user_model');
        $this->load->model('topic_model');
        $this->load->model('admin_model');

        if ($this->session->userdata('bds_logged_in')) {
            $this->user = $this->db->get_where('tb_user', array('user_id' => $this->session->userdata['bds_user_id']), 1)->row();
        }else{
            echo "";
        }
    }

    public function profil($id, $start=0)
    {
        //edit post
        if ($this->input->post('btn-edit-post')) {
            $this->topic_model->post_edit();
            if ($this->topic_model->error_count != 0) {
                $this->data['error']    = $this->topic_model->error;
            } else {
                $this->session->set_userdata('tmp_success_edit', 1);
                redirect('profil_member/profil/'.$id);
            }
        }

        $tmp_success_edit = $this->session->userdata('tmp_success_edit');
        if ($tmp_success_edit != NULL) {
            // pesan berhasil
            $this->session->unset_userdata('tmp_success_edit');
            $this->data['tmp_success_edit'] = 1;
        }
        //end edit post

        //edit topic
        if ($this->input->post('btn-edit-th')) {
            $this->topic_model->topic_edit();
            if ($this->topic_model->error_count != 0) {
                $this->data['error']    = $this->topic_model->error;
            } else {
                $this->session->set_userdata('tmp_success_edit_th', 1);
                redirect('profil_member/profil/'.$id);
            }
        }

        $tmp_success_edit_th = $this->session->userdata('tmp_success_edit_th');
        if ($tmp_success_edit_th != NULL) {
            $this->session->unset_userdata('tmp_success_edit_th');
            $this->data['tmp_success_edit_th'] = 1;
        }
        //end edit topic

        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('profil_member/profil/'.$id);
        $this->page_config['uri_segment'] = 4;
        
        $this->db->from('tb_topic');
        $this->db->where('user_id', $id);
        $this->page_config['total_rows']  = $this->db->count_all_results();

        $this->page_config['per_page']    = 2;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);

        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // topic deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        $tmp_success_edit = $this->session->userdata('tmp_success');
            if ($tmp_success_edit != NULL) {
                $this->session->unset_userdata('tmp_success');
                $this->data['tmp_success'] = 1;
        }

        $tmp_success_pass = $this->session->userdata('tmp_success_pass');
        if ($tmp_success_pass != NULL) {
            // pesan berhasil
            $this->session->unset_userdata('tmp_success_pass');
            $this->data['tmp_success_pass'] = 1;
        }

        $this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['topics'] = $this->user_model->topic_get_all($start, $this->page_config['per_page']); 
        
        $this->data['posts']   = $this->user_model->post_get_all($start, $this->page_config['per_page']);

        $categories =$this->data['categories'] = $this->admin_model->category_get_all();
        $this->db->order_by('username', 'asc');
        
        $this->data['users'] = $this->user_model->profil_member();
        $this->data['jlh_topik'] = $this->user_model->jlh_topic();
        $this->data['jlh_post'] = $this->user_model->jlh_post();
        $this->data['jlh_love'] = $this->user_model->jlh_love();
        
        $this->data['title'] = 'Profil | Forum BDS';
        $id = $this->uri->segment(3);
        
        $this->data['teman'] = $this->db->where('user_id =', $id)->get('tb_user');
        $this->template->load('template','user/profil',$this->data);
    }

    public function pesan()
    {
        $this->load->model('user_model');
        $this->data['teman'] = $this->user_model->getchatting();
        $this->data['title']   = 'Pesan | Forum BDS';
        $this->data['users'] = $this->user_model->profil_member();
        $this->data['categories'] = $this->admin_model->category_get_all();

        $this->template->load('template','user/pesan',$this->data);
        
        // $this->template->load('template','user/pesan',$this->data);
   
    }

    public function getChats()
    {
        header('Content-Type: application/json');
        if ($this->input->is_ajax_request()) {
            
            // Find friend
            $friend = $this->db->get_where('tb_user', array('user_id' => $this->input->post('chatWith')), 1)->row();

            // Get Chats
           
            $chats = $this->db
                ->select('tb_chat.*, tb_user.name')
                ->from('tb_chat')
                ->join('tb_user', 'tb_chat.send_by = tb_user.user_id')
                ->where('(send_by = '. $this->user->user_id .' AND send_to = '. $friend->user_id .')')
                ->or_where('(send_to = '. $this->user->user_id .' AND send_by = '. $friend->user_id .')')
                ->order_by('tb_chat.time', 'desc')
                ->limit(100)
                ->get()
                ->result();

            $result = array(
                'name' => $friend->username,
                'chats' => $chats
            );
            echo json_encode($result);
        }
    }

    public function sendMessage()
    {
        if (htmlentities($this->input->post('message')) == null) {
            $this->error['message'] = 'message kosong';
        } else{
            $this->error_count = count($this->error);
            $this->db->insert('tb_chat', array(
                'message' => htmlentities($this->input->post('message', true)),
                'send_to' => $this->input->post('chatWith'),
                'send_by' => $this->user->user_id
            ));
        }
        
    }


    public function tambah_pesan($start=0) {
        $cari = $this->input->get ('cari');

        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('user/tambah_pesan/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all('tb_user');
        $limit   = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);
        
        $this->data['type']    = 'cari';
        $this->data['page']    = $this->pagination->create_links();
        // $this->data['teman']   = $this->user_model->tm();
        $this->data['cari']    = $this->admin_model->cari_user($start, $limit, $cari);
        $this->data['title']   = 'Cari User | Forum BDS';
 
        $this->template->load('template','user/tambah_pesan',$this->data);
 
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
}