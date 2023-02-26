<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Werehouse";
        $data['gudang'] = $this->admin->get('gudang');
        $this->template->load('templates/dashboard', 'gudang/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_gudang', 'Nama Gudang', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Werehouse";
            $this->template->load('templates/dashboard', 'gudang/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('gudang', $input);
            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('gudang');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('gudang/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Werehouse";
            $data['gudang'] = $this->admin->get('gudang', ['id_gudang' => $id]);
            $this->template->load('templates/dashboard', 'gudang/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('gudang', 'id_gudang', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('gudang');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('gudang/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('gudang', 'id_gudang', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('gudang');
    }
}
