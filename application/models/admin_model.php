<?php

class Admin_model extends CI_Model {
    public $error       = array();
    public $error_count = 0;
    public $data        = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_mbr($start, $limit)
    {
        $sql = "SELECT *
                FROM tb_user
                WHERE level = 'member' ORDER BY username DESC LIMIT ".$start.", ".$limit;

        return $this->db->query($sql)->result();      
    }

    // edit level member 
    public function user_edit()
    {
        $row = $this->input->post('row');

        if (count($this->error) == 0) {

            $this->db->where('user_id', $row['user_id']);
            $this->db->update('tb_user', $row);
        } else {
            $this->error_count = count($this->error);
        }
    }
    // end

    public function n_aktif(){
        $id = $this->uri->segment(3);

        $row = "0";

        $this->db->set('aktif', $row, false);
        $this->db->where('user_id', $id);
        $this->db->update('tb_user');
    }

    public function aktif(){
        $id = $this->uri->segment(3);

        $row = "1";

        $this->db->set('aktif', $row, false);
        $this->db->where('user_id', $id);
        $this->db->update('tb_user');
    }

    

    public function admin_edit()
    {
        $row = array('user_id'=>$this->input->post('id'),                   
                    'username'=> $this->input->post('username'),
                    'name'=> $this->input->post('nama'),
                    'email'=> $this->input->post('email'),
                    'jenis_kelamin'=> $this->input->post('jenkel'));

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
            if (strlen($row['name']) == 0) {
                $this->error['name'] = 'Nama Kosong';
            }
            if (strlen($row['email']) == 0) {
                $this->error['email'] = 'Email Kosong';
            }
         }

        if (count($this->error) == 0) {

            $this->db->where('user_id', $row['user_id']);
            $this->db->update('tb_user', $row);
        } else {
            $this->error_count = count($this->error);
        }
    }

    // buat kategori
    public function category_create()
    {
        $row = $this->input->post('row');
        $row['date_added']       = date("Y-m-d H:i:s");

        // cek name
        $is_exist_name = $this->db->get_where('tb_kategori',
                array('name' => $row['name']))->num_rows();
        if ($is_exist_name > 0) {
            $this->error['name'] = 'Nama Kategori sudah digunakan';
        }
        if (strlen($row['name']) == 0) {
            $this->error['name'] = 'Nama tidak boleh kosong';
        }

        // cek slug
        $is_exist_slug = $this->db->get_where('tb_kategori',
                array('slug' => $row['slug']))->num_rows();
        if ($is_exist_slug > 0) {
            $this->error['slug'] = 'Slug sudah digunakan';
        }
        if (strlen($row['slug']) == 0) {
            $this->error['slug'] = 'Slug tidak boleh kosong';
        }

        if (count($this->error) == 0) {
            $this->db->insert('tb_kategori', $row);
        } else {
            $this->error_count = count($this->error);
        }
    }
    //end

    public function category_edit()
    {
        $row = $this->input->post('row');

        // cek name
        if (strlen($row['name']) == 0) {
            $this->error['name'] = 'Nama tidak boleh kosong';
        } else {
            if ($row['name'] != $row['name_c']) {
                $role_check = $this->db->get_where('tb_kategori', array('name' => $row['name']));
                if ($role_check->num_rows() > 0) {
                    $this->error['name'] = 'Nama Kategori "'.$row['name'].'" Sudah digunakan';
                }
            }
        }

        // cek slug
        if (strlen($row['slug']) == 0) {
            $this->error['slug'] = 'Slug tidak boleh Kosong';
        } else {
            if ($row['slug'] != $row['slug_c']) {
                $role_check = $this->db->get_where('tb_kategori', array('slug' => $row['slug']));
                if ($role_check->num_rows() > 0) {
                    $this->error['slug'] = 'Slug "'.$row['slug'].'" sudah digunakan';
                }
            }
        }

        if (count($this->error) == 0) {
            unset($row['name_c']);
            unset($row['slug_c']);
            $row['date_edit']       = date("Y-m-d H:i:s");
            $this->db->where('category_id', $row['category_id']);
            $this->db->update('tb_kategori', $row);
        } else {
            $this->error_count = count($this->error);
        }
    }

    //ngambil semua ketegori
    public function category_get_all($cat_id = 0)
    {
        $this->data = array();
        $this->db->order_by('name', 'asc');
        $query = $this->db->get_where('tb_kategori', array('parent_id' => $cat_id));
        $counter = 0;
        foreach ($query->result() as $row) {
            $this->data[$counter]['id'] = $row->category_id;
            $this->data[$counter]['parent_id'] = $row->parent_id;
            $this->data[$counter]['name'] = $row->name;
            $this->data[$counter]['slug'] = $row->slug;
            $this->data[$counter]['real_name'] = $row->name;
            $children = $this->category_get_children($row->category_id, ' - ', $counter);
			$counter = $counter + $children;
			$counter++;
        }
        return $this->data;
    }
    //end

    public function category_get_children($id, $separator, $counter)
	{
    $this->db->order_by('name', 'asc');
		$query = $this->db->get_where('tb_kategori', array('parent_id' => $id));
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			foreach($query->result() as $row)
			{
				$counter++;
				$this->data[$counter]['id'] = $row->category_id;
				$this->data[$counter]['parent_id'] = $row->parent_id;
                $this->data[$counter]['name'] = $separator.$row->name;
                $this->data[$counter]['slug'] = $row->slug;
                $this->data[$counter]['real_name'] = $row->name;
				$children = $this->category_get_children($row->category_id, $separator.' - ', $counter);

				if ($children != FALSE)
				{
					$counter = $counter + $children;
				}
			}
			return $counter;
		}
	}

    public function category_get_all_parent($id, $counter)
    {
        $row = $this->db->get_where( 'tb_kategori', array('category_id' => $id))->row_array();
        $this->data[$counter] = $row;
        if ($row['parent_id'] != 0) {
            $counter++;
            $this->category_get_all_parent($row['parent_id'], $counter);
        }
        return array_reverse($this->data);
    }


    public function post_get_all($start = 0, $limit = 20)
    {
        $sql = "SELECT a.*,b.topic_id, b.title, b.th_slug, c.*  FROM ".'tb_post'." a, ".'tb_topic'." b, ".'tb_user'." c
                WHERE a.topic_id = b.topic_id AND b.user_id = c.user_id ORDER BY a.date_add DESC LIMIT ".$start.", ".$limit;
        return $this->db->query($sql)->result();
    }

    public function cari_user($start, $limit, $cari){

        $data = $this->db->query("SELECT * from tb_user where level = 'member' and username like '%$cari%' ORDER BY username DESC LIMIT ".$start.",".$limit." ");
     
        return $data->result();
    }

    public function cari_admin($start, $limit, $cari){

        $data = $this->db->query("SELECT * from tb_user where level = 'admin' and username like '%$cari%' ORDER BY username DESC LIMIT ".$start.",".$limit." ");
     
        return $data->result();
    }

    public function cari_post($start, $limit, $cari){

        $query = "SELECT a.*, b.topic_id, b.title, b.th_slug,
                    c.user_id, c.username, c.foto FROM tb_post a
                    INNER JOIN tb_topic b ON a.topic_id = b.topic_id INNER JOIN tb_user c ON b.user_id = c.user_id 
                    WHERE post LIKE '%".$cari."%' ORDER BY a.date_add DESC LIMIT ".$start.",".$limit."";
     
        return $this->db->query($query)->result();
    }

    public function jlh_member(){
        $query = $this->db->query("SELECT * FROM tb_user WHERE level = 'member'");
        return $query->num_rows();
    }

    public function jlh_admin(){
        $query = $this->db->query("SELECT * FROM tb_user WHERE level = 'admin'");
        return $query->num_rows();
    }


    // public function admin_create()
    // {
    //     $password = md5($this->input->post('password'));
    //     $row = array('level' => 'admin',
    //                   'username'=> $this->input->post('username'),
    //                   'name'=> $this->input->post('nama'),
    //                   'email'=> $this->input->post('email'),
    //                   'jenis_kelamin' =>$this->input->post('jenkel'),
    //                   'password'=> $password,
    //                   'tgl_join' =>  $this->input->post('date_join'),
    //                   'aktif' => '1');
    //     // check username
    //     $is_exist_username = $this->db->get_where('tb_user',
    //                           array('username' => $row['username']))->num_rows();

    //     if ($is_exist_username > 0) {
    //         $this->error['username'] = 'Username sudah digunakan';
    //     }

    //     if (strlen($row['username']) < 5) {
    //         $this->error['username'] = 'Username minimum 5 karakter';
    //     }


    //     // cek password
    //     if ($password != md5($this->input->post('password2'))) {
    //         $this->error['password'] = 'Password tidak cocok';
    //     } else if (strlen($this->input->post('password')) < 5) {
    //         $this->error['password'] = 'Password minimum 5 karakter';
    //     }

    //     if (strlen($row['password']) == null) {
    //         $this->error['password'] = 'password tidak boleh Kosong';
    //     }

    //     if (strlen($row['email']) == null) {
    //         $this->error['email'] = 'email tidak boleh Kosong';
    //     }

    //     if (count($this->error) == 0) {
    //         //$key = $this->config->item('encryption_key');
    //         //$row['password'] = $this->encrypt->encode($row['password'], $key);
    //         $this->db->insert('tb_user', $row);

    //     } else {
    //         $this->error_count = count($this->error);
    //     }
    // }


}
