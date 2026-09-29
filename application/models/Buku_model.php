<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {
    public function get_all() {
        return $this->db->get('buku')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('buku', ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('buku', $data);
    }
}
