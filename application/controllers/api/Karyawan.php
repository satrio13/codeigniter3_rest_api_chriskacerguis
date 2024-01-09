<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Karyawan extends RestController
{
    function __construct()
    {
        parent::__construct(); 
        $this->load->model('karyawan_model');
    }

    function index_get()
    {
        $id = $this->get('id');

        if($id != null)
        {   
            $data = $this->karyawan_model->get_karyawan($id);
            if(!$data)
            {
                $this->response(['status' => 'false', 'message' => 'Data tidak ditemukan'], 404);
            }else
            { 
                $this->response(['status' => 'true', 'data' => $data]);
            }   
        }else
        {
            $data = $this->karyawan_model->list_karyawan();
            $this->response(['status' => 'true', 'data' => $data]);
        }
    }

    function index_post()
    {
		$this->form_validation->set_data($this->post());
		$this->form_validation->set_rules('nama', 'Nama', 'required|max_length[100]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|max_length[50]');
		$this->form_validation->set_rules('bidang', 'Bidang', 'required|max_length[50]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[120]|valid_email');
        if($this->form_validation->run() == false)
        {
            $message = $this->form_validation->error_array();
            return $this->response(['status' => false, 'message' => $message], 400);
        }else
        {
            $data = $this->post();
            $this->karyawan_model->tambah_karyawan($data);
            if($this->db->affected_rows() > 0)
            {
                return $this->response(['status' => true, 'message' => 'Data Berhasil Disimpan']);
            }else
            {
                return $this->response(['status' => false, 'message' => 'Data Gagal Disimpan!'], 400);
            }
        }
    }

    function index_put()
    {
        $id = $this->put('id');
        $cek = $this->karyawan_model->cek_karyawan($id);
        if(!$cek)
        {
            return $this->response(['status' => false, 'message' => 'Data tidak ditemukan!'], 400);
        }else
        {
            $this->form_validation->set_data($this->put());
            $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[100]');
            $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|max_length[50]');
            $this->form_validation->set_rules('bidang', 'Bidang', 'required|max_length[50]');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[120]|valid_email');
            if($this->form_validation->run() == false)
            {
                $message = $this->form_validation->error_array();
                return $this->response(['status' => false, 'message' => $message], 400);
            }else
            {
                $data = $this->put();
                $this->karyawan_model->edit_karyawan($data, $id);
                if($this->db->affected_rows() > 0)
                {
                    return $this->response(['status' => true, 'message' => 'Data Berhasil Diupdate']);
                }else
                {
                    return $this->response(['status' => false, 'message' => 'Data Gagal Diupdate!'], 400);
                }
            }
        }
    }

    function index_delete()
    {
        $id = $this->delete('id');
        $cek = $this->karyawan_model->cek_karyawan($id);
        if(!$cek)
        {
            return $this->response(['status' => false, 'message' => 'Data tidak ditemukan!'], 400);
        }else
        {
            $this->karyawan_model->hapus_karyawan($id);
            if($this->db->affected_rows() > 0)
            {
                return $this->response(['status' => true, 'message' => 'Data Berhasil Dihapus']);
            }else
            {
                return $this->response(['status' => false, 'message' => 'Data Gagal Dihapus!'], 400);
            }
        }
    }

}