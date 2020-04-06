<?php

class User_model extends CI_Model {
    public $error       = array();
    public $error_count = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function check_login()
    {
        $row = $this->input->post('row');

        $key = $this->config->item('encryption_key');

        $data = array('username' => $row['username']);

        $query = $this->db->get_where('tb_user', $data);
        // $user = $this->input->post('row[username]');    
 
        $this->db->where('username',$row['username']);
        $this->db->update('tb_user',array('last_login'=>date("Y-m-d H:i:s")));
        // $plain_password = '';

        if ( ($query->num_rows() == 1) ) {
            $user = $query->row();
            $plain_password = $this->encrypt->decode($user->password, $key);
        }

        // jika ketemu
        if ( ($query->num_rows() == 1) && ($plain_password == $row['password'])) {
            $row = $query->row();
            
            $this->session->set_userdata('bds_logged_in', 1);
            $this->session->set_userdata('bds_user_id'  , $row->user_id);
            $this->session->set_userdata('bds_username' , $row->username);
            $this->session->set_userdata('bds_user_level' , $row->level);
        } else {
            $this->error['login'] = 'Username/password Anda salah';
            $this->error_count = 1;

            if (strlen($row['username']) == null) {
                $this->error['username'] = 'Username Kosong';
            }
    
            if (strlen($row['password']) == null) {
                $this->error['password'] = 'Password Kosong';
            }
        }  
    }

    public function register()
    {
        $row = array('level' => 'member',
                      'username'=> $this->input->post('username'),
                      'name'=> $this->input->post('nama'),
                      'email'=> $this->input->post('email'),
                      'jenis_kelamin' =>$this->input->post('jenkel'),
                      'password'=> $this->input->post('password'),
                      'tgl_join' =>  $this->input->post('date_join'));
        // check username
        $is_exist_username = $this->db->get_where('tb_user',
                              array('username' => $row['username']))->num_rows();

        if ($is_exist_username > 0) {
            $this->error['username'] = 'Username sudah digunakan';
        }

        if (strlen($row['username']) < 5) {
            $this->error['username'] = 'Username minimum 5 karakter';
        }

        if (strlen($row['username']) == null) {
            $this->error['username'] = 'Username tidak boleh Kosong';
        }

        if (strlen($row['name']) == null) {
            $this->error['nama'] = 'Nama tidak boleh Kosong';
        }

        // cek password
        if ($row['password'] != $this->input->post('password2')) {
            $this->error['password'] = 'Password tidak cocok';
        } else if (strlen($row['password']) < 5) {
            $this->error['password'] = 'Password minimum 5 karakter';
        }

        if (strlen($row['password']) == null) {
            $this->error['password'] = 'password tidak boleh Kosong';
        }

        if (strlen($row['email']) == null) {
            $this->error['email'] = 'email tidak boleh Kosong';
        }

        if (count($this->error) == 0) {
            $key = $this->config->item('encryption_key');
            $row['password'] = $this->encrypt->encode($row['password'], $key);
            $this->db->insert(tb_user, $row);

        } else {
            $this->error_count = count($this->error);
        }
    }

    public function password_edit()
    {
        $row = $this->input->post('row');
        if (strlen($row['password']) == 0) {
            $this->error['password'] = 'password tidak boleh kosong';
        }
        if (strlen($row['password2']) == 0) {
            $this->error['password2'] = 'konfirmasi password tidak boleh kosong';
        }
        if ($row['password'] != "" || $row['password2'] != "") {
            if ($row['password'] != $row['password2']) {
                $this->error['password'] = 'Password tidak cocok';
            } else if (strlen($row['password']) < 5) {
                $this->error['password'] = 'Password minimal 5 karakter';
            }
        }

      if (count($this->error) == 0) {

      if ($row['password'] != "" && $row['password2'] != "") {
        $key = $this->config->item('encryption_key');
        $row['password'] = $this->encrypt->encode($row['password'], $key);
      } else {
        unset($row['password']);
      }

      unset($row['password2']);

            $this->db->where('user_id', $row['user_id']);
            $this->db->update('tb_user', $row);
        } else {
            $this->error_count = count($this->error);
        }
    }

    public function profil_edit()
    {
        $row = array('user_id'=>$this->input->post('id'),                   
                    'username'=> $this->input->post('username'),
                    'name'=> $this->input->post('nama'),
                    'email'=> $this->input->post('email'),
                    'jenis_kelamin'=> $this->input->post('jenkel'),
                    'bio'=> $this->input->post('bio'));

        if (strlen($row['username']) == 0) {
            $this->error['username'] = 'Username tidak boleh kosong';
        } else {
            if ($row['username'] != $row['username']) {
                $role_check = $this->db->get_where('tb_user', array('username' => $row['username']));
                if ($role_check->num_rows() > 0) {
                    $this->error['username'] = 'Username "'.$row['username'].'" Sudah digunakan';
                }
            }
            if (strlen($row['username']) < 5) {
                $this->error['username'] = 'Username minimum 5 karakter';
            }
            // if (strlen($row['name']) == 0) {
            //     $this->error['name'] = 'Nama Kosong';
            // }
            // if (strlen($row['email']) == 0) {
            //     $this->error['email'] = 'Email Kosong';
            // }
         }

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

        $row = array('user_id'=>$this->input->post('id'),                  
                        'foto'=>$data);

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
    }

    
    // ngambil pesan
    public function getchatting()
    {
        // $ids = $this->uri->segment(3);
        $id = $this->session->userdata('bds_user_id');
        $sql = "SELECT a.*,b.username, b.name, b.foto, a.message, b.user_id as user_id FROM ".'tb_chat'." a, ".'tb_user'." b
                WHERE a.send_to = ".$id." AND a.send_by = b.user_id OR a.send_to = ".'b.user_id'." AND a.send_by = $id GROUP BY b.user_id, b.name
                ORDER BY a.time DESC, a.message";

        return $this->db->query($sql)->result();
    }
    //end
}
