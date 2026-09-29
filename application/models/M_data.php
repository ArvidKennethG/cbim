<?php
defined('BASEPATH') or exit('no direct script access allowed');

class M_data extends CI_Model
{
    //fungsi untuk mengambil data dari database
    public function get_data($table)
    {
        if ($table == 'video_kegiatan') {
            $this->db->order_by('id_video', 'DESC');
        } else if ($table == 'berita') {
            $this->db->order_by('id_berita', 'DESC');
        } else if ($table == 'pendaftaran_sd' || $table == 'pendaftaran_tk') {
            $this->db->order_by('id_pendaftaran', 'DESC');
        }
        return $this->db->get($table);
    }

    public function get_data_where($where, $table)
    {
        return $this->db->get_where($table, $where);
    }

    public function get_data_limit($orderField, $table)
    {
        return $this->db->select('*')
            ->from($table)
            ->order_by($orderField, 'DESC')
            ->limit(1)
            ->get();
    }

    //fungsi untuk insert data ke database
    public function insert_data($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return $this->session->set_flashdata('success', 'Data berhasil disimpan.');
        } else {
            return $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }
    }

    //fungsi untuk mengambil data untuk di edit
    public function edit_data($where, $table)
    {
        return $this->db->get_where($table, $where);
    }


    //fungsi untuk mengupdate data di database
    public function update_data($where, $data, $table)
    {
        $this->db->where($where);
        if ($this->db->update($table, $data)) {
            return $this->session->set_flashdata('success', 'Data berhasil diupdate.');
        } else {
            return $this->session->set_flashdata('error', 'Data gagal diupdate.');
        }
    }

    //fungsi untuk menghapus data
    public function delete_data_wfoto($where, $table, $foto)
    {
        if ($this->db->delete($table, $where)) {
            $old_photo_path = FCPATH . '/assets/templates/media/avatars/' . $foto;
            if (file_exists($old_photo_path)) {
                unlink($old_photo_path);
            }
            return $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        } else {
            return $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }
    }

    public function delete_data_gfoto($where, $table, $foto)
    {
        if ($this->db->delete($table, $where)) {
            $old_photo_path = FCPATH . '/assets/templates/media/avatars/' . $foto;
            if (file_exists($old_photo_path)) {
                unlink($old_photo_path);
            }
            return $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        } else {
            return $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }
    }

    public function delete_data($where, $table)
    {
        if ($this->db->delete($table, $where)) {
            return $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        } else {
            return $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }
    }
}
