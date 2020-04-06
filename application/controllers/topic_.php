<?php

class Topic extends CI_Controller {
    public $data         = array();
    public $page_config  = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('topic_model');
        $this->load->model('user_model');
        $this->load->model('admin_model');
        
        $this->load->library('pagination');
    }

    public function index($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('topic/index/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all('tb_topic');;
        $this->page_config['per_page']    = 4;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);
        $this->data['type']    = 'index';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['topics'] = $this->topic_model->get_all($start, $this->page_config['per_page']);
        $this->data['title']   = 'Forum Pemrograman';        
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->template->load('template','topic/index',$this->data);

    }

    public function create()
    {
        $this->data = array('container' => 'topic/create' );
        if (!$this->session->userdata('bds_user_id')) {
            redirect('user/login');
        } else if ($this->session->userdata('topic_create') == 0) {

        }
        if ($this->input->post('btn-create')) {
            $this->topic_model->create();
            if ($this->topic_model->error_count != 0) {
                $this->data['error']    = $this->topic_model->error;
            } else {
                $this->session->set_userdata('tmp_success_new', 1);
                redirect('topic/talk/'.$this->topic_model->fields['th_slug']);
            }
        }

        $this->load->model('admin_model');
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']  = 'Buat topic | Forum BDS';
        $this->template->load('template','topic/create',$this->data);

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

    public function talk($slug, $start = 0)
    {
        // balas
        if ($this->input->post('btn-post')) {
            if (!$this->session->userdata('bds_user_id')) {
                redirect('user/join');
            } else if ($this->session->userdata('topic_create') == 0) {

            }

            $this->topic_model->reply();
            if ($this->topic_model->error_count != 0) {
                $this->data['error']    = $this->topic_model->error;
            } else {
                $this->session->set_userdata('tmp_success_bls', 1);
                redirect('topic/talk/'.$slug.'/'.$start);
            }
        }

        $tmp_success_bls = $this->session->userdata('tmp_success_bls');
        if ($tmp_success_bls != NULL) {
            // new post on a topic created
            $this->session->unset_userdata('tmp_success_bls');
            $this->data['tmp_success_bls'] = 1;
        }
        // akhir balas

        //edit post
        if ($this->input->post('btn-edit')) {
            $this->topic_model->post_edit();
            if ($this->topic_model->error_count != 0) {
                $this->data['error']    = $this->topic_model->error;
            } else {
                $this->session->set_userdata('tmp_success_edit', 1);
                redirect('topic/talk/'.$slug.'/'.$start);
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
                redirect('topic/talk/'.$slug.'/'.$start);
            }
        }

        $tmp_success_edit_th = $this->session->userdata('tmp_success_edit_th');
        if ($tmp_success_edit_th != NULL) {
            $this->session->unset_userdata('tmp_success_edit_th');
            $this->data['tmp_success_edit_th'] = 1;
        }
        //end edit topic

        //love
        $love = $this->input->post('btn-cek');
        if ($love =='save')
        {
            $this->topic_model->love();
            if ($this->topic_model->error_count != 0) {
                $this->data['error']    = $this->topic_model->error;
            } else {
                $this->session->set_userdata('tmp_success_ck', 1);
                redirect('topic/talk/'.$slug.'/'.$start);
            }
        }

        $love = $this->input->post('btn-hps');
        if ($love =='save')
        {
            $this->topic_model->love_delete();
            if ($this->topic_model->error_count != 0) {
                $this->data['error']    = $this->topic_model->error;
            } else {
                $this->session->set_userdata('tmp_success_ck', 1);
                redirect('topic/talk/'.$slug.'/'.$start);
            }
        }
        
        $tmp_success_ck = $this->session->userdata('tmp_success_ck');
        if ($tmp_success_ck != NULL) {
            // new role created
            $this->session->unset_userdata('tmp_success_ck');
            $this->data['tmp_success_ck'] = 1;
        }

        $topic = $this->db->get_where('tb_topic', array('th_slug' => $slug))->row();
        
        // set pagination
        $this->load->library('pagination');

        $this->page_config['base_url']    = site_url('topic/talk/'.$slug);
        $this->page_config['uri_segment'] = 4;
        $this->page_config['total_rows']  = $this->db->get_where('tb_post', array('topic_id' => $topic->topic_id))->num_rows();
        $this->page_config['per_page']    = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);

        $posts  = $this->topic_model->get_posts($topic->topic_id, $start, $this->page_config['per_page']);
        $fposts  = $this->topic_model->get_f_posts($topic->topic_id, $start, $this->page_config['per_page']);
        $top  = $this->topic_model->top_post($topic->topic_id);
        
        $this->data['cat']           = $this->admin_model->category_get_all_parent($topic->category_id, 0);
        $this->data['categories']    = $this->admin_model->category_get_all();
        $this->data['title']         = $topic->title.' topic | Forum BDS';
        $this->data['page']          = $this->pagination->create_links();
        $this->data['topic']        = $topic;
        $this->data['fposts']        = $fposts;
        $this->data['posts']         = $posts;
        $this->data['top_post']      = $top;
        
        $this->template->load('template','topic/talk',$this->data);
    }

    //hapus post di talk
    public function post_delete()
    {
        // hapus
        $post_id = $this->input->post('post_id');
        $this->db->delete('tb_post', array('post_id' => $post_id));
        $this->session->set_userdata('tmp_success_del', 1);       
    }
    //end 

    public function category($slug, $start = 0)
    {
        $category = $this->db->get_where('tb_kategori', array('slug' => $slug))->row();
        $this->load->model('admin_model');
        $this->data['cat']           = $this->admin_model->category_get_all_parent($category->category_id, 0);
        $this->data['topic']        = $category;
        $this->data['categories']    = $this->admin_model->category_get_all();

        $cat_id = array();
        $child_cat = $this->admin_model->category_get_all($category->category_id);
        $cat_id[0] = $category->category_id;
        foreach ($child_cat as $cat) {
            $cat_id[] = $cat['id'];
        }

        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('topic/category/'.$slug);
        $this->page_config['uri_segment'] = 4;
        $this->page_config['total_rows']  = $this->topic_model->get_total_by_category($cat_id);
        $this->page_config['per_page']    = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);

        $this->data['page']    = $this->pagination->create_links();

        $this->data['topics'] = $this->topic_model->get_by_category($start, $this->page_config['per_page'], $cat_id);

        $this->data['type']    = 'category';
        $this->data['title']   = 'Kategori '.$category->name;
        $this->template->load('template','topic/index',$this->data);
    }


    //cari topic 
    public function cari($start=0) {
       $cari = $this->input->GET ('cari');

       $this->load->library('pagination');
       $this->page_config['base_url']    = site_url('topic/cari/');
       $this->page_config['uri_segment'] = 3;
       $this->page_config['total_rows']  = $this->db->count_all('tb_topic');
       $limit   = 10;

       $this->set_pagination();

       $this->pagination->initialize($this->page_config);

       $this->data['type']    = 'cari';
       $this->data['page']    = $this->pagination->create_links();
       $this->data['cari']    = $this->topic_model->caridata($start, $limit, $cari);

       $this->data['title']   = 'Cari | Forum BDS';
       $this->load->model('admin_model');
       $this->data['categories'] = $this->admin_model->category_get_all();

       $this->template->load('template','topic/cari',$this->data);

      }

    public function savelikes()
	{
        $ipaddress=$_SERVER['REMOTE_ADDR'];
        $postid=$this->input->post('Post_id');


        $fetchlikes=$this->db->query('select likes from tb_post where post_id="'.$postid.'"');
        $result=$fetchlikes->result();

        $checklikes = $this->db->query('select * from tb_postlikes 
                                        where post_id="'.$postid.'" 
                                        and ipaddress = "'.$ipaddress.'"');
        $resultchecklikes = $checklikes->num_rows();

        if($resultchecklikes == '0' ){
        if($result[0]->likes=="" || $result[0]->likes=="NULL")
        {
            $this->db->query('update tb_post set likes=1 where post_id="'.$postid.'"');
        }
        else
        {
            $this->db->query('update tb_post set likes=likes+1 where post_id="'.$postid.'"');
        }

        $data=array('post_id'=>$postid,'ipaddress'=>$ipaddress);
        $this->db->insert('tb_postlikes',$data);
        }else{
        $this->db->delete('tb_postlikes', array('post_id'=>$postid,
                                            'ipaddress'=>$ipaddress));
        $this->db->query('update tb_post set likes=likes-1 where post_id="'.$postid.'"');
        }

        $this->db->select('likes');
        $this->db->from('tb_post');
        $this->db->where('post_id',$postid);
        $query=$this->db->get();
        $result=$query->result();

        echo $result[0]->likes;
    }
    
    public function about()
    {
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']  = 'About | Forum BDS';
        $this->template->load('template','about',$this->data);      
    }

}
