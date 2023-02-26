<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
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
        $data['title'] = "Inventory";
        $data['barang'] = $this->admin->getBarang();
        $this->template->load('templates/dashboard', 'barang/data', $data);
    }
    public function detail($id)
    {
        $data['title'] = 'Barang';

        //menampilkan data berdasarkan id
        $data['data'] = $this->barang_model->detail_join($id, 'barang')->result();

        $this->template->load('templates/dashboard', 'barang/data', $data);
    }
    private function _validasi()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jenis_id', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('satuan_id', 'Satuan Barang', 'required');
        $this->form_validation->set_rules('harga_barang', 'Harga Barang','required|trim|numeric');
        $this->form_validation->set_rules('gudang_id', 'Gudang', 'required');
    }
     private function _config()
    {
        $config['upload_path']      = "./assets/upload";
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['max_size']         = '2048';
        $config['file_name']         = 'item-'.date('ymd').'-'.substr(md5(rand()),0,10);
        $this->load->library('upload', $config);
    }
    public function add()
    {
        $this->_validasi();
        $this->_config();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Inventory";
            $data['jenis'] = $this->admin->get('jenis');
            $data['satuan'] = $this->admin->get('satuan');
            $data['gudang'] = $this->admin->get('gudang');
            $data['harga_barang'] = "harga_barang";
            // Mengenerate ID Barang
            $kode_terakhir = $this->admin->getMax('barang', 'id_barang');
            $kode_tambah = substr($kode_terakhir, -6, 6);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
            $data['id_barang'] = 'B' . $number;

            $this->template->load('templates/dashboard', 'barang/add', $data);
        } else {
            $input = $this->input->post(null, true);
            if (@$_FILES['image']['name'] != null) {
                 if ($this->upload->do_upload('image')) {
                    $input['image'] = $this->upload->data('file_name');
                    $insert = $this->admin->insert('barang', $input);
                     if ($this->db->affected_rows() > 0) {
                     $this->session->set_flashdata('Succes','Data Berhasil Disimpan');
                    } 
                     redirect('barang');
                    }else{
                       $error = $this->upload->display_errors();
                       $this->session->set_flashdata('error', $error);
                        redirect('barang/add');
                    }

              
            }else{
                   $input['image'] = null;
                    $insert = $this->admin->insert('barang', $input);
                     if ($this->db->affected_rows() > 0) {
                     $this->session->set_flashdata('Succes','Data Berhasil Disimpan');
                     redirect('barang');
                    }else{
                       $error = $this->upload->display_errors();
                       $this->session->set_flashdata('error', $error);
                        redirect('barang/add');
                    }
            }
           
        }
    }


    public function edit($getId)
    {  
        $id = encode_php_tags($getId);
        $this->_validasi();
        $this->_config();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Inventory";
            $data['jenis'] = $this->admin->get('jenis');
            $data['satuan'] = $this->admin->get('satuan');
            $data['gudang'] = $this->admin->get('gudang');
            $data['harga_barang'] = "harga_barang";
            $data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);
            $this->template->load('templates/dashboard', 'barang/edit', $data);
        } else {
            $input = $this->input->post(null, true);
             if (empty($_FILES['image']['name'])) {
                $insert = $this->admin->update('barang', 'id_barang', $id, $input);
                if ($insert) {
                    set_pesan('perubahan berhasil disimpan.');
                    redirect('barang');
                }else{
                    set_pesan('perubahan tidak disimpan.');
                }
                redirect('barang/edit'.$id);
            } else {
                if ($this->upload->do_upload('image') == false) {
                    echo $this->upload->display_errors();
                    die;
                } else {
                    if ($data['image'] != null) {
                        $old_image = 'assets/upload/' . $data['image'];
                       unlink($old_image);
                    }

                    $input['image'] = $this->upload->data('file_name');
                   $update = $this->admin->update('barang', 'id_barang', $id, $input);
                    if ($update) {
                        set_pesan('perubahan berhasil disimpan.');
                        redirect('barang');
                    } 
                    else {
                        set_pesan('gagal menyimpan perubahan');
                    }
                    redirect('barang/edit'.$id);
                }
            }
        }
    }
    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang', 'id_barang', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->admin->cekStok($id);
        output_json($query);
    }
}
