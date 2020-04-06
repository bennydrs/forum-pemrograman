<?php

class User_model extends CI_Model {
    public $error       = array();
    public $error_count = 0;

    public function __construct()
    {
        parent::__construct();
        
        
    }

    // public function check_login($username, $password)
    // {
        
    //     $this->db->where('username', $username);
    //     $this->db->where('password', $password);
    //     return $this->db->get('tb_user')->row();
        
    //     //
    // }

    public function register()
    {
        $password1 = $this->input->post('password');
        $passwordhash = password_hash($password1, PASSWORD_DEFAULT);
        $row = array('level' => 'member',
                      'username'=> $this->input->post('username'),
                      'name'=> $this->input->post('nama'),
                      'email'=> $this->input->post('email'),
                      'jenis_kelamin' =>$this->input->post('jenkel'),
                      'password'=> $passwordhash,
                      'tgl_join' =>  $this->input->post('date_join'),
                      'aktif' => '1');
        // check username
        $is_exist_username = $this->db->get_where('tb_user',
                              array('username' => $row['username']))->num_rows();

        if ($is_exist_username > 0) {
            $this->error['username'] = 'Username sudah digunakan';
        }

        if (strlen($row['username']) < 5) {
            $this->error['username'] = 'Username minimum 5 karakter';
        }


        // cek password
        if ($password1 != $this->input->post('password2')) {
            $this->error['password'] = 'Password tidak cocok';
        } else if (strlen($this->input->post('password')) < 5) {
            $this->error['password'] = 'Password minimum 5 karakter';
        }

        if (strlen($row['password']) == null) {
            $this->error['password'] = 'password tidak boleh Kosong';
        }

        if (strlen($row['email']) == null) {
            $this->error['email'] = 'email tidak boleh Kosong';
        }

        if (count($this->error) == 0) {
            //$key = $this->config->item('encryption_key');
            //$row['password'] = $this->encrypt->encode($row['password'], $key);
            $this->db->insert('tb_user', $row);

        } else {
            $this->error_count = count($this->error);
        }
    }

    public function password_edit()
    {
        //$row = $this->input->post('row');
        $user_id = $this->input->post('user_id');
        //$old_password = md5($this->input->post('old'));
        $password = md5($this->input->post('password'));
        //$password2 = md5($this->input->post('password2'));

        $row = array('password'=> $password);
                      
        //$cek_old = $this->db->where('password',$old_password);
                    //$query = $this->db->get('tb_user');
                    //return $query->result();
                
        
        
        //if (strlen($password) == 0) {
            //$this->error['password'] = 'password tidak boleh kosong';
            //$this->session->set_flashdata('error','Old password not match!' );
        //}
        //if (strlen($password2) == 0) {
            //$this->error['password2'] = 'konfirmasi password tidak boleh kosong';
        //}
        //if ($password != "" || $password2 != "") {
            //if ($password != $password2) {
                //$this->error['password'] = 'Password tidak cocok';
                //$this->session->set_flashdata('error','Password tidak cocok!' );
            //} else if (strlen($password) < 5) {
                //$this->error['password'] = 'Password minimal 5 karakter';
                //$this->session->set_flashdata('error','Password minimal 5 karakter!' );
            //}
       // }
    
    
        //else if ($cek_old == False){
               //$this->error['old_password'] = 'password lama salah';
               //$this->session->set_flashdata('error','Old password not match!' );
        //}else
      //if (count($this->error) == 0) 
      //{

      //if ($row['password'] != "" && $row['password2'] != "") {
        //$key = $this->config->item('encryption_key');
        //$row['password'] = $this->encrypt->encode($row['password'], $key);
      //} else {
        //unset($row['password']);
      //}

      //unset($row['password2']);

            $this->db->where('user_id', $user_id);
            $this->db->update('tb_user', $row);
            
            
        //} else {
            //$this->error_count = count($this->error);
        //}
    }
    //cek password lama
    public function cek_old(){
        $old = md5($this->input->post('old'));    
        $this->db->where('password',$old);
        $query = $this->db->get('tb_user');
        return $query->result();;
    }

    public function profil_edit()
    {
        $row = array('user_id'=>$this->input->post('id'),                   
                    
                    'name'=> $this->input->post('nama'),
                    'email'=> $this->input->post('email'),
                    'jenis_kelamin'=> $this->input->post('jenkel'),
                    'bio'=> $this->input->post('bio'));

        // if (strlen($row['username']) == 0) {
        //     $this->error['username'] = 'Username tidak boleh kosong';
        // } else {
        //     if ($row['username'] != $row['username']) {
        //         $role_check = $this->db->get_where('tb_user', array('username' => $row['username']));
        //         if ($role_check->num_rows() > 0) {
        //             $this->error['username'] = 'Username "'.$row['username'].'" Sudah digunakan';
        //         }
        //     }
        //     if (strlen($row['username']) < 5) {
        //         $this->error['username'] = 'Username minimum 5 karakter';
        //     }
        //     if (strlen($row['name']) == 0) {
        //         $this->error['name'] = 'Nama Kosong';
        //     }
        //     if (strlen($row['email']) == 0) {
        //         $this->error['email'] = 'Email Kosong';
        //     }
        //  }

        if (count($this->error) == 0) {

            $this->db->where('user_id', $row['user_id']);
            $this->db->update('tb_user', $row);
        } else {
            $this->error_count = count($this->error);
        }
    }

    public function foto_edit()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['max_size']	= '200'; // kb
        //$config['max_width']  = '1024';
        //$config['max_height']  = '768';
        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $data=$this->upload->file_name;

        $fotolama = $this->input->post('lama');

        $row = array('user_id'=>$this->input->post('user_id'),                  
                        'foto'=>$data);

        

        if(file_exists("./uploads/".$fotolama)){
            unlink("./uploads/".$fotolama);
        }

        if (count($this->error) == 0) {
            $this->db->where('user_id', $row['user_id']);
            $this->db->update('tb_user', $row);
        } else {
            $this->error_count = count($this->error);
        }
    }


    //topic di profil
    public function topic_get_all($start, $limit)
    {
        $id = $this->uri->segment(3);
        $sql = "SELECT a.*, b.name as cat_name FROM ".'tb_topic'." a, ".'tb_kategori'." b
                WHERE a.user_id = ".$id." AND  a.category_id = b.category_id ORDER BY a.date_add DESC LIMIT ".$start.", ".$limit;
    
        return $this->db->query($sql)->result();
    }
    //end 

    //post di profil
    public function post_get_all($start, $limit)
    {
        $id = $this->uri->segment(3);
        $sql = "SELECT a.*, b.title, b.th_slug FROM ".'tb_post'." a, ".'tb_topic'." b
                WHERE a.user_id = ".$id." AND  a.topic_id = b.topic_id ORDER BY date_add DESC LIMIT ".$start.", ".$limit;

        return $this->db->query($sql)->result();
    }
    //end

    public function profil_member()
    {
        $id = $this->uri->segment(3);
        $sql = "SELECT *FROM ".'tb_user'."
                WHERE user_id = ".$id." ";
        return $this->db->query($sql)->result();
        // $this->db->select('*');
        // $this->db->from('tb_user');
        // $this->db->join('tb_post', 'tb_post.user_id=tb_user.user_id');
        // $this->db->where('tb_user.user_id', $id);
        // $q = $this->db->get();
        // return $q->result();
        
    }
    
    public function jlh_topic(){
        $id = $this->uri->segment(3);
        $query = $this->db->query("SELECT * FROM tb_topic WHERE user_id = '$id'");
        return $query->num_rows();
    }

    public function jlh_post(){
        $id = $this->uri->segment(3);
        $query = $this->db->query("SELECT * FROM tb_post WHERE user_id = '$id'");
        return $query->num_rows();
    }

    public function jlh_love(){
        $id = $this->uri->segment(3);
        $query = $this->db->query("SELECT * FROM tb_post WHERE user_id = '$id' and love= '1'");
        return $query->num_rows();
    }

    
    // ngambil pesan
    public function getchatting()
    {
        // $ids = $this->uri->segment(3);
        $id = $this->session->userdata('bds_user_id');
        $sql = "SELECT a.*,b.username, b.name, b.foto, a.message, b.level, b.user_id as user_id 
                FROM ".'tb_chat'." a, ".'tb_user'." b
                WHERE a.send_to = ".$id." AND a.send_by = b.user_id OR a.send_to = ".'b.user_id'." AND a.send_by = $id 
                GROUP BY b.user_id, b.name
                ORDER BY a.time DESC, a.message";

        return $this->db->query($sql)->result();
    }


    //end

 
}
