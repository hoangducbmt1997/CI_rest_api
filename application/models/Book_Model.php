<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_Model extends CI_Model {


    public function book_all_data()
    {
        return $this->db->select('id,title,author')->from('books')->order_by('id', 'desc')->get()->result();
    }

    public function book_detail_data($id)
    {
        return $this->db->select('id,title,author')->from('books')->where('id', $id)->order_by('id', 'desc')->get()->row();
    }

    public function book_create_data($data)
    {
        $this->db->insert('books', $data);
        return array('status' => 201, 'message' => 'Data has been created.');
    }

    public function book_update_data($id, $data)
    {
        $this->db->where('id', $id)->update('books', $data);
        return array('status' => 200, 'message' => 'Data has been updated.');
    }

    public function book_delete_data($id)
    {
        $this->db->where('id', $id)->delete('books');
        return array('status' => 200, 'message' => 'Data has been deleted.');
    }

}
