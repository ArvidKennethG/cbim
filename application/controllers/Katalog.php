<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Katalog extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Buku_model');
        $this->load->library('cart');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['buku'] = $this->Buku_model->get_all();
        $this->load->view('katalog_view', $data);
    }

public function detail_buku($id) {
    $buku = $this->Buku_model->get_by_id($id);

    if (!$buku) {
        show_404(); // tampilkan halaman 404 jika buku tidak ditemukan
    }

    $data['buku'] = $buku;
    $this->load->view('detail_buku_view', $data);
}

    public function add_to_cart($id) {
        $buku = $this->Buku_model->get_by_id($id);
        $data = [
            'id'      => $buku->id,
            'qty'     => 1,
            'price'   => $buku->harga,
            'name'    => $buku->judul
        ];
        $this->cart->insert($data);
        redirect('katalog');
    }

    public function cart() {
        $this->load->view('keranjang_view');
    }

    public function checkout() {
        $this->load->view('checkout_view');
    }

    public function proses_checkout() {
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');

        $data_pesanan = [
            'nama_pembeli' => $nama,
            'alamat' => $alamat,
            'total_harga' => $this->cart->total(),
            'tanggal' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('pesanan', $data_pesanan);
        $pesanan_id = $this->db->insert_id();

        foreach ($this->cart->contents() as $item) {
            $this->db->insert('pesanan_detail', [
                'pesanan_id' => $pesanan_id,
                'buku_id' => $item['id'],
                'jumlah' => $item['qty'],
                'subtotal' => $item['subtotal']
            ]);
        }

        $this->cart->destroy();
        $this->load->view('sukses_view');
    }
public function update_cart()
{
    $rowid = $this->input->post('rowid');
    $qty = (int) $this->input->post('qty');
    $action = $this->input->post('action');

    if ($action == 'tambah') {
        $qty++;
    } elseif ($action == 'kurang' && $qty > 1) {
        $qty--;
    }

    $data = [
        'rowid' => $rowid,
        'qty'   => $qty
    ];

    $this->cart->update($data);
    redirect('katalog/cart');
}



public function remove_from_cart()
{
    $rowid = $this->input->post('rowid');

    if ($rowid) {
        $this->cart->update([
            'rowid' => $rowid,
            'qty'   => 0
        ]);
    }

    redirect('katalog/cart');
}


    public function tambah_buku() {
          if (!$this->session->userdata('role')) {
            redirect(base_url('auth'));
        }
        if ($_POST) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('cover')) {
                echo $this->upload->display_errors();
                return;
            }

            $upload_data = $this->upload->data();
            $data = [
                'judul' => $this->input->post('judul'),
                'penulis' => $this->input->post('penulis'),
                'isbn' => $this->input->post('isbn'),
                'tahun' => $this->input->post('tahun'),
                'deskripsi' => $this->input->post('deskripsi'),
                'harga' => $this->input->post('harga'),
                'kategori' => $this->input->post('kategori'),
                'cover' => $upload_data['file_name']
            ];

            $this->Buku_model->insert($data);
            redirect('katalog');
        } else {
            $this->load->view('form_buku_view');
        }
    }
    public function edit_buku($id) {
          if (!$this->session->userdata('role')) {
            redirect(base_url('auth'));
        }
    $buku = $this->Buku_model->get_by_id($id);

    if ($_POST) {
        $data = [
            'judul' => $this->input->post('judul'),
            'penulis' => $this->input->post('penulis'),
            'isbn' => $this->input->post('isbn'),
            'tahun' => $this->input->post('tahun'),
            'deskripsi' => $this->input->post('deskripsi'),
            'harga' => $this->input->post('harga'),
            'kategori' => $this->input->post('kategori'),
        ];

        // jika cover baru diupload
        if (!empty($_FILES['cover']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('cover')) {
                $upload_data = $this->upload->data();
                $data['cover'] = $upload_data['file_name'];
            } else {
                echo $this->upload->display_errors();
                return;
            }
        }

        $this->db->where('id', $id)->update('buku', $data);
        redirect('katalog');
    } else {
        $data['buku'] = $buku;
        $this->load->view('form_edit_view', $data);
    }
}

public function hapus_buku($id) {
      if (!$this->session->userdata('role')) {
            redirect(base_url('auth'));
        }
    $buku = $this->Buku_model->get_by_id($id);

    // hapus file cover jika ada
    if ($buku && file_exists('./uploads/' . $buku->cover)) {
        unlink('./uploads/' . $buku->cover);
    }

    $this->db->delete('buku', ['id' => $id]);
    redirect('katalog');
}

}
