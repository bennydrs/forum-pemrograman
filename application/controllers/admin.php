<?php

class Admin extends CI_Controller {
    public $data         = array();
    public $page_config  = array();

    public function __construct()
    {
        parent::__construct();
            $this->load->model('admin_model');
		    $this->load->model('user_model');
            $this->load->model('topic_model');
            $this->data['categories'] = $this->admin_model->category_get_all();
            $this->load->helper(array('form', 'url'));
        
        if ($this->session->userdata('bds_logged_in')!= 1) {
            redirect('user/login');
        }  

    }

    public function index()
    {
        $this->data['title']   = 'Halaman Admin | Forum Pemrograman';
        $this->load->model('admin_model');
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['jumlah']  = $this->db->get('tb_topic')->num_rows();
        $this->data['jlh_post']  = $this->db->get('tb_post')->num_rows();
        $this->data['jlh_member']  = $this->admin_model->jlh_member();
        $this->data['jlh_admin']  = $this->admin_model->jlh_admin();
        $this->template->load('admin/sidebar','admin/index',$this->data);

    }

    // semua user
    public function user_view($start = 0)
    {
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/user_view/');
        $this->page_config['uri_segment'] = 3;
        $this->db->from('tb_user');
        $this->db->order_by('username', 'asc');
        $this->db->where('level', 'member');
        $this->page_config['total_rows']  = $this->db->count_all_results();
        $this->page_config['per_page']    = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);

        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // user updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }

        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // user deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }

        $this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        
    

        // $this->db->order_by('username', 'asc');
        // $this->db->where('level', 'member');
        $this->data['users'] = $this->admin_model->get_user_mbr($start, $this->page_config['per_page']);
        // $this->data['users'] = $this->db->get('tb_user')->result();
        $this->data['title']   = 'Kelola Member | Admin';
        $this->template->load('admin/sidebar','admin/user_view',$this->data);

    }
    //end

    //hapus member
    public function user_delete($user_id)
    {
        $this->db->delete('tb_chat', array('send_by' => $user_id));
        $this->db->delete('tb_chat', array('send_to' => $user_id));
        $this->db->delete('tb_topic', array('user_id' => $user_id));
        $this->db->delete('tb_post', array('user_id' => $user_id));
        $this->db->delete('tb_user', array('user_id' => $user_id));

        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/user_view');
    }
    //end

    //hapus admin
    public function admin_delete($user_id)
    {
        $this->db->delete('tb_chat', array('send_by' => $user_id));
        $this->db->delete('tb_chat', array('send_to' => $user_id));
        $this->db->delete('tb_topic', array('user_id' => $user_id));
        $this->db->delete('tb_post', array('user_id' => $user_id));
        $this->db->delete('tb_user', array('user_id' => $user_id));

        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/admin_view');
    }
    //end

    //edit level member
    public function user_edit($user_id)
    {
        if ($this->input->post('btn-save')) {
            $this->admin_model->user_edit();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/user_view');
            }
        }
        
        $this->data['user']    = $this->db->get_where('tb_user', array('user_id' => $user_id))->row();
        $this->data['title']   = 'Admin Member Edit Level';
        $this->template->load('admin/sidebar','admin/user_edit',$this->data);

    }
    // end
    
    //aktif/nonaktif
    public function n_aktif(){
        $this->admin_model->n_aktif();
        $this->session->set_flashdata('msg','Akun Member berhasil di Non-Aktifkan.');
        redirect('admin/user_view');
    }

    public function aktif(){
        $this->admin_model->aktif();
        $this->session->set_flashdata('msg','Akun Member berhasil di Aktifkan.');
        redirect('admin/user_view');
    }
    //end

    //super admin aktif/nonaktif
    public function n_aktif_ad(){
        $this->admin_model->n_aktif();
        redirect('admin/admin_view');
    }

    public function aktif_ad(){
        $this->admin_model->aktif();
        redirect('admin/admin_view');
    }
    //end

    public function admin_view()
    {
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // user updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }

        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // user deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        $tmp_success_edit = $this->session->userdata('tmp_success_edit');
        if ($tmp_success_edit != NULL) {
            // pesan berhasil
            $this->session->unset_userdata('tmp_success_edit');
            $this->data['tmp_success_edit'] = 1;
        }

        $this->db->order_by('username', 'asc');
        $this->db->where('level', 'admin');
        $this->data['users'] = $this->db->get('tb_user')->result();
        $this->data['title']   = 'Sumua Admin | Admin';
        $this->template->load('admin/sidebar','admin/admin_view',$this->data);

    }

    public function admin_create(){
        if ($this->input->post('btn-admin')) {
            $this->admin_model->admin_create();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/admin_view');
            }
        }

        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // pesan berhasil
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }

        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']   = 'Admin Tambah Admin ';
        $this->template->load('admin/sidebar','admin/admin_create',$this->data);
    }

    public function admin_edit($user_id)
    {
        if ($this->input->post('btn-editadmin')) {
            $this->admin_model->admin_edit();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success_edit', 1);
                redirect('admin/admin_view');
            }
        }
        
        
        $this->data['user']    = $this->db->get_where('tb_user', array('user_id' => $user_id))->row();
        $this->data['title']   = 'Admin Edit';
        $this->template->load('admin/sidebar','admin/admin_edit',$this->data);

    }

    // buat kategori
    public function category_create()
    {
        if ($this->input->post('btn-create')) {
            $this->admin_model->category_create();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/category_create');
            }
        }

        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // pesan berhasil
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }

        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']   = 'Admin Buat Kategori ';
        $this->template->load('admin/sidebar','admin/category_create',$this->data);

    }

    //kelola kategori
    public function category_view()
    {
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // role deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new category created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }

        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']   = 'Admin Kelola Kategori ';
        $this->template->load('admin/sidebar','admin/category_view',$this->data);
    }
   

    public function category_edit($category_id)
    {
        if ($this->input->post('btn-edit')) {
            $this->admin_model->category_edit();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/category_view/'.$category_id);
            }
        }
        
        $this->data['category']   = $this->db->get_where('tb_kategori', array('category_id' => $category_id))->row();
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']   = 'Admin Category Edit ';
        $this->template->load('admin/sidebar','admin/category_edit',$this->data);

    }

    public function category_delete($category_id)
    {
        $this->db->delete('tb_kategori', array('category_id' => $category_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/category_view');
    }
     //end kelola kategori
  
    //kelola topic
    public function topic_view($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/topic_view/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all_results('tb_topic');
        $this->page_config['per_page']    = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);

        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // topic deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }

        $this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['topics'] = $this->topic_model->get_all($start, $this->page_config['per_page']);
        $this->data['jumlah']  = $this->db->get('tb_topic')->num_rows();
        $this->data['title']   = 'Admin Kelola topic ';
        $this->template->load('admin/sidebar','admin/topic_view',$this->data);

    }

    public function topic_delete($topic_id)
    {
        // delete topic
        $this->db->delete('tb_topic', array('topic_id' => $topic_id));

        // delete all posts on this topic
        $this->db->delete('tb_post', array('topic_id' => $topic_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/topic_view');
  
    }
    // end kelola topic

    //kelola post
    public function post_view($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/post_view/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all_results('tb_post');
        $this->page_config['per_page']    = 20;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);

        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // topic updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }

        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // topic deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }

        $this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['topics'] = $this->admin_model->post_get_all($start, $this->page_config['per_page']);
        $this->data['jumlah']  = $this->db->get('tb_post')->num_rows();
        $this->data['title']   = 'Admin post View ';
        $this->template->load('admin/sidebar','admin/post_view',$this->data);

    }

    public function post_delete($post_id)
    {
        // delete
        $this->db->delete('tb_post', array('post_id' => $post_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/post_view');
    }
    //end kelola post

    public function cari_member($start=0) {
        $cari = $this->input->get ('cari');

        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/user_cari/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all('tb_user');
        $limit   = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);
        
        $this->data['type']    = 'cari';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['cari']    = $this->admin_model->cari_user($start, $limit, $cari);
        $this->data['title']   = 'Cari User | Forum BDS';
 
        $this->template->load('admin/sidebar','admin/user_cari',$this->data);
 
    }

    public function cari_admin($start=0) {
        $cari = $this->input->get ('cari');

        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/admin_cari/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all('tb_user');
        $limit   = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);
        
        $this->data['type']    = 'cari';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['cari']    = $this->admin_model->cari_admin($start, $limit, $cari);
        $this->data['title']   = 'Cari User | Forum BDS';
 
        $this->template->load('admin/sidebar','admin/admin_cari',$this->data);
 
    }

    public function cari_topic($start=0) {
        $cari = $this->input->GET ('cari');

        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/topic_cari/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all('tb_topic');
        $limit   = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);

        $this->data['type']    = 'cari';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['cari']    = $this->topic_model->caridata($start, $limit, $cari);
    //    $this->data['cari']    =   $this->topic_model->caridata($cari);

        $this->data['title']   = 'Cari User | Forum BDS';
 
        $this->template->load('admin/sidebar','admin/topic_cari',$this->data);
    }

    public function cari_post($start=0) {
        $cari = $this->input->POST ('cari_post');

        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/cari_post/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all('tb_post');
        $limit   = 10;

        $this->set_pagination();

        $this->pagination->initialize($this->page_config);

        $this->data['type']    = 'cari';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['cari']    = $this->admin_model->cari_post($start, $limit, $cari);
        $this->data['title']   = 'Cari Post | Forum BDS';
    
        $this->template->load('admin/sidebar','admin/post_cari',$this->data);
    }   

    public function set_pagination()
    {
        $this->page_config['first_link']         = '&lsaquo; First';
        $this->page_config['first_tag_open']     = '<li>';
        $this->page_config['first_tag_close']    = '</li>';
        $this->page_config['last_link']          = 'Last &raquo;';
        $this->page_config['last_tag_open']      = '<li>';
        $this->page_config['last_tag_close']     = '</li>';
        $this->page_config['next_link']          = 'Next &rsaquo;';
        $this->page_config['next_tag_open']      = '<li>';
        $this->page_config['next_tag_close']     = '</li>';
        $this->page_config['prev_link']          = '&lsaquo; Prev';
        $this->page_config['prev_tag_open']      = '<li>';
        $this->page_config['prev_tag_close']     = '</li>';
        $this->page_config['cur_tag_open']       = '<li class="active"><a href="javascript://">';
        $this->page_config['cur_tag_close']      = '</a></li>';
        $this->page_config['num_tag_open']       = '<li>';
        $this->page_config['num_tag_close']      = '</li>';
    }
}


