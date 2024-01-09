<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pegawai extends RestController
{
    function index_get()
    {
        $id = $this->get('id');

        if($id != null)
        {   
            $data = $this->db->get_where('tb_pegawai', ['id' => $id])->row();
            if(!$data)
            {
                $this->response(['status' => 'false', 'message' => 'Data tidak ditemukan'], 404);
            }else
            { 
                $this->response(['status' => 'true', 'data' => $data]);
            }   
        }else
        {
            $data = $this->db->select('*')->from('tb_pegawai')->order_by('nama', 'asc')->get()->result();
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
            $data = [
                'nama' => $this->post('nama'),
                'jabatan' => $this->post('jabatan'),
                'bidang' => $this->post('bidang'),
                'alamat' => $this->post('alamat'),
                'email' => $this->post('email')
            ];

            $this->db->insert('tb_pegawai', $data);
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
        $cek = $this->db->select('id')->from('tb_pegawai')->where('id', $id)->get()->row();
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
                $data = [
                    'nama' => $this->put('nama'),
                    'jabatan' => $this->put('jabatan'),
                    'bidang' => $this->put('bidang'),
                    'alamat' => $this->put('alamat'),
                    'email' => $this->put('email')
                ];

                $this->db->update('tb_pegawai', $data, ['id' => $id]);
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
        $cek = $this->db->select('id')->from('tb_pegawai')->where('id', $id)->get()->row();
        if(!$cek)
        {
            return $this->response(['status' => false, 'message' => 'Data tidak ditemukan!'], 400);
        }else
        {
            $this->db->delete('tb_pegawai', ['id' => $id]);
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