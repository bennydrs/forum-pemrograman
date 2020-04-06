<?php

class Topic_model extends CI_Model {
    public $error       = array();
    public $error_count = 0;
    public $data        = array();
    public $fields      = array();

    public function __construct()
    {
        parent::__construct();
    }

    // ngambil data topic utk home
    public function get_all($start, $limit)
    {
        $sql = "SELECT a.*, c.username, c.foto, c.user_id as user_id, b.name as category_name, b.slug as category_slug
                FROM ".'tb_topic'." a, ".'tb_kategori'." b , ".'tb_user'." c
                WHERE a.category_id = b.category_id AND a.user_id = c.user_id ORDER BY a.date_add DESC LIMIT ".$start.", ".$limit;

        return $this->db->query($sql)->result();      
    }
    //end

    public function get_by_category($start, $limit, $cat_id)
    {
        $cat_string = "(";
        foreach ($cat_id as $key => $id) {
            if ($key == 0) {
                $cat_string .= " a.category_id = ".$id;
            } else {
                $cat_string .= " OR a.category_id = ".$id;
            }
        }
        $cat_string .= ")";

        $sql = "SELECT a.*,c.username, c.foto, c.user_id as user_id, b.name as category_name, b.slug as category_slug
                FROM ".'tb_topic'." a, ".'tb_kategori'." b, ".'tb_user'." c
                WHERE a. category_id = b.category_id AND a.user_id = c.user_id AND ".$cat_string."
                ORDER BY a.date_add DESC LIMIT ".$start.", ".$limit;

        return $this->db->query($sql)->result();
    }

    public function get_total_by_category($cat_id)
    {
        $cat_string = "(";
        foreach ($cat_id as $key => $id) {
            if ($key == 0) {
                $cat_string .= " a.category_id = ".$id;
            } else {
                $cat_string .= " OR a.category_id = ".$id;
            }
        }
        $cat_string .= ")";

        $sql = "SELECT a.* FROM ".'tb_topic'." a WHERE ".$cat_string;
        return $this->db->query($sql)->num_rows();
    }


    public function create()
    {
        $topic = array('title' => $this->input->post('title'),
                        'th_slug'=> $this->input->post('th_slug'),
                        'category_id'=> $this->input->post('category_id'),
                        'jenis_topic'=> $this->input->post('jenis_topic'),
                        'f_post' =>$this->input->post('f_post')
                        );

        $this->fields = $topic;
        // cek slug
        if (strlen($topic['th_slug']) == 0) {
            $this->error['th_slug'] = 'Slug Tidak boleh kosong';
        } else {
            $slug_check = $this->db->get_where('tb_topic', array('th_slug' => $topic['th_slug']));
            if ($slug_check->num_rows() > 0) {
                $this->error['th_slug'] = 'Slug "'.$topic['th_slug'].'" sudah digunakan';
            }
        }

        if (count($this->error) == 0) {
            // insert into topic
            $topic['user_id'] = $this->session->userdata('bds_user_id');
            $topic['date_add']       = date("Y-m-d H:i:s");
            $topic['date_last_post'] = date("Y-m-d H:i:s");
            $this->db->insert('tb_topic', $topic);
        } else {
            $this->error_count = count($this->error);
        }
    }


    // ngambil topic untuk talk / post pertama
    public function get_f_posts($topic_id)
    {
        $sql = "SELECT a.*, b.username, b.foto, b.level, b.user_id as user_id FROM ".'tb_topic'." a, ".'tb_user'." b
                WHERE a.topic_id = ".$topic_id." AND a.user_id = b.user_id
                ORDER BY a.date_add ASC";

        return $this->db->query($sql)->result();
    }
    //end

    //ngambil post untuk talk
    public function get_posts($topic_id, $start, $limit)
    {
        $sql = "SELECT a.*, b.username, b.foto, b.level, b.user_id as user_id FROM ".'tb_post'." a, ".'tb_user'." b
                WHERE a.topic_id = ".$topic_id." AND a.user_id = b.user_id
                ORDER BY a.date_add ASC LIMIT ".$start.", ".$limit;

        return $this->db->query($sql)->result();
    }
    //end

    public function top_post($topic_id)
    {
        $sql = "SELECT a.*, b.username, b.foto, b.level, b.user_id as user_id FROM ".'tb_post'." a, ".'tb_user'." b
                WHERE a.topic_id = ".$topic_id." AND a.user_id = b.user_id
                ORDER BY a.likes DESC LIMIT 3";
        
        return $this->db->query($sql)->result();   
    }

    public function reply()
    {
        $row = $this->input->post('row');

        // check post
        if (strlen($row['post']) == 0) {
            $this->error['post'] = 'Balasan tidak boleh kosong';
        }

        if (count($this->error) == 0) {
            $this->db->insert('tb_post', $row);
            
            // $topic['topic_id'] = $this->db->insert_id();
            // $topic['user_id'] = $this->session->userdata('bds_user_id');
            $tgl['date_last_post']       = date("Y-m-d H:i:s");
            // $this->db->where('topic_id', $topic['topic_id']);
            // $this->db->update('tb_topic', $topic);

            $this->db->where('topic_id', $row['topic_id']);
            $this->db->update('tb_topic', $tgl);
        } else {
            $this->error_count = count($this->error);
        }
    }

    //edit topic 
    public function topic_edit()
    {
        
        $topic = array( 'topic_id' => $this->input->post('topic_id'),
                        'title' => $this->input->post('title'),
                        'th_slug'=> $this->input->post('th_slug'),
                        'category_id'=> $this->input->post('category_id'),
                        'jenis_topic'=> $this->input->post('jenis_topic'),
                        'f_post' =>$this->input->post('f_post')
                        );

        $th_slug_old= $this->input->post('th_slug_old');

        $this->fields = $topic;

        // $ori = $this->db->query("select th_slug from tb_topic where topic_id = ".$topic['topic_id']."")->row()->th_slug;
        // if($topic['th_slug'] != $ori){
        //     $this->error['th_slug'] = 'Slug "'.$topic['th_slug'].'" sudah digunakan';
        // }

        // $this->db->where('topic_id', $topic['topic_id']);
        // $query = $this->db->get('tb_topic');
        // $count = $query->num_rows();
        

        // $slug_check = $this->db->get_where('tb_topic', array('topic_id' => $topic['topic_id'], 'th_slug' => $topic['th_slug']));
        //     if ($topic['topic_id'] =! $slug_check->num_rows() > 0) {
        //         $this->error['th_slug'] = 'Slug "'.$topic['th_slug'].'" sudah digunakan';
        //     } 

            if ($topic['th_slug'] != $th_slug_old) {
                $slug_check = $this->db->get_where('tb_topic', array('th_slug' => $topic['th_slug']));
                if ($slug_check->num_rows() > 0) {
                    $this->error['th_slug'] = 'Slug "'.$topic['th_slug'].'" sudah digunakan';
                }
            }
        
            if (count($this->error) == 0) {
                // update topic
                unset($th_slug_old);
                $topic['date_edit']       = date("Y-m-d H:i:s");
                $this->db->where('topic_id', $topic['topic_id']);
                $this->db->update('tb_topic', $topic);
            } else {
                $this->error_count = count($this->error);
            }
        
    }
    //end

    //edit post 
    public function post_edit()
    {
        $row = $this->input->post('row');

        if (strlen($row['post']) == 0) {
            $this->error['post'] = 'post Tidak boleh kosong';
        }

        if (count($this->error) == 0) {
            // update post
            $row['date_edit']       = date("Y-m-d H:i:s");
            $this->db->where('post_id', $row['post_id']);
            $this->db->update('tb_post', $row);
        } else {
            $this->error_count = count($this->error);
        }
    }
    //end post di talk

    //cari topic untuk home
    public function caridata($start, $limit, $cari)
    {
        $query = "SELECT a.*, b.category_id, b.name as category_name, b.parent_id, b.slug as category_slug,
                    c.user_id, c.username, c.foto FROM tb_topic a
                    INNER JOIN tb_kategori b ON a.category_id = b.category_id INNER JOIN tb_user c ON a.user_id = c.user_id 
                    WHERE title LIKE '%".$cari."%' ORDER BY a.date_add DESC LIMIT ".$start.",".$limit."";
     
        return $this->db->query($query)->result();
    }

    public function love()
    {
        $row = $this->input->post('row');

        // if (strlen($row['cek']) == 0) {
        //     $this->error['cek'] = 'cek Tidak boleh kosong';
        // }

        if (count($this->error) == 0) {
            // $row['cek'] = 1;

            // "UPDATE 'tb_post' SET 'check'= $row['cek'] WHERE 'post_id' = $row['post_id']";
            
            $this->db->set('love', $row['cek'], false);
            $this->db->where('post_id', $row['post_id']);
            $this->db->update('tb_post');
        } else {
            $this->error_count = count($this->error);
        }
    }

    public function love_delete()
    {
        $row = $this->input->post('row');

        if (count($this->error) == 0) {
            // $row['cek'] = 1;

            // "UPDATE 'tb_post' SET 'check'= $row['cek'] WHERE 'post_id' = $row['post_id']";
            
            $this->db->set('love', $row['cek'], false);
            $this->db->where('post_id', $row['post_id']);
            $this->db->update('tb_post');
        } else {
            $this->error_count = count($this->error);
        }
    
    }

    

}
