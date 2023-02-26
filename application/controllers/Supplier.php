<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
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
        $data['title'] = "Supplier";
        $data['supplier'] = $this->admin->get('supplier');
        $this->template->load('templates/dashboard', 'supplier/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('supplier', 'Supplier', 'required|trim');
        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    }
      private function _config()
    {
        $config['upload_path']      = "./assets/img/avatar";
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
            $data['title'] = "Supplier";
            $this->template->load('templates/dashboard', 'supplier/add', $data);
        } else {
            $input = $this->input->post(null, true);
             if (@$_FILES['foto']['name'] != null) {
                         if ($this->upload->do_upload('foto')) {
                            $input['foto'] = $this->upload->data('file_name');
                            $save = $this->admin->insert('supplier', $input);
                             if ($this->db->affected_rows() > 0) {
                             $this->session->set_flashdata('Succes','Data Berhasil Disimpan');
                            } 
                             redirect('supplier');
                            }else{
                               $error = $this->upload->display_errors();
                               $this->session->set_flashdata('error', $error);
                                redirect('supplier/add');
                            }

                      
                    }else{
                           $input['foto'] = null;
                            $save = $this->admin->insert('supplier', $input);
                             if ($this->db->affected_rows() > 0) {
                             $this->session->set_flashdata('Succes','Data Berhasil Disimpan');
                             redirect('supplier');
                            }else{
                               $error = $this->upload->display_errors();
                               $this->session->set_flashdata('error', $error);
                                redirect('supplier/add');
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
            $data['title'] = "Supplier";
            $data['supplier'] = $this->admin->get('supplier', ['id_supplier' => $id]);
            $this->template->load('templates/dashboard', 'supplier/edit', $data);
        } else {
            $input = $this->input->post(null, true);
        if (empty($_FILES['foto']['name'])) {
                    $update = $this->admin->update('supplier', 'id_supplier', $id, $input);
                    if ($update) {
                        set_pesan('perubahan berhasil disimpan.');
                        redirect('supplier');
                    }else{
                        set_pesan('perubahan tidak disimpan.');
                    }
                    redirect('supplier/edit'.$id);
                } else {
                    if ($this->upload->do_upload('foto') == false) {
                        echo $this->upload->display_errors();
                        die;
                    } else {
                        if ($data['foto'] != null) {
                            $old_image = 'assets/img/avatar/' . $data['foto'];
                           unlink($old_image);
                        }

                        $input['foto'] = $this->upload->data('file_name');
                       $update = $this->admin->update('supplier', 'id_supplier', $id, $input);
                        if ($update) {
                            set_pesan('perubahan berhasil disimpan.');
                            redirect('supplier');
                        } 
                        else {
                            set_pesan('gagal menyimpan perubahan');
                        }
                        redirect('supplier/edit'.$id);
                    }
                }
            }
        }
    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('supplier', 'id_supplier', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('supplier');
    }
}
