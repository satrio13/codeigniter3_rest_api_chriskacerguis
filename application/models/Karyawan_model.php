<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model 
{
    function list_karyawan()
    {
        return $this->db->select('*')->from('tb_karyawan')->order_by('nama', 'asc')->get()->result();
    }

    function get_karyawan($id)
    {
        return $this->db->get_where('tb_karyawan', ['id' => $id])->row();
    }

    function cek_karyawan($id)
    {
        return $this->db->select('id')->from('tb_karyawan')->where('id', $id)->get()->row();
    }

    function tambah_karyawan($data)
    {
        $karyawan = [
            'nama' => $data['nama'],
            'jabatan' => $data['jabatan'],
            'bidang' => $data['bidang'],
            'alamat' => $data['alamat'],
            'email' => $data['email']
        ];

        $this->db->insert('tb_karyawan', $karyawan);
    }

    function edit_karyawan($data, $id)
    {
        $karyawan = [
            'nama' => $data['nama'],
            'jabatan' => $data['jabatan'],
            'bidang' => $data['bidang'],
            'alamat' => $data['alamat'],
            'email' => $data['email']
        ];

        $this->db->update('tb_karyawan', $karyawan, ['id' => $id]);
    }

    function hapus_karyawan($id)
    {
        $this->db->delete('tb_karyawan', ['id' => $id]);
    }

}