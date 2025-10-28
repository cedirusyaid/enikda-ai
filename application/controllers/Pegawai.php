<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pegawai_model');
        $this->load->model('Unit_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $status = $this->input->get('status') ?: 'aktif';
        $unit_id = $this->input->get('unit_id');

        $data['pegawai'] = $this->Pegawai_model->get_all_pegawai($status, $unit_id);
        $data['judul'] = 'Data Pegawai';
        $data['units'] = $this->Unit_model->get_all();
        $data['selected_status'] = $status;
        $data['selected_unit'] = $unit_id;

        $this->load->view('template/header', $data);
        $this->load->view('pegawai/index', $data);
        $this->load->view('template/footer');
    }

    public function crud($action = 'tambah', $nip = null)
    {
        $data['judul'] = ucfirst($action) . ' Data Pegawai';
        $data['action'] = $action;

        if ($action == 'edit' && $nip === null) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
            $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
            
            if ($this->form_validation->run() == TRUE) {
                $post_data = [
                    'nip' => $this->input->post('nip'),
                    'nip_lama' => $this->input->post('nip_lama'),
                    'nama' => $this->input->post('nama'),
                    'nomor_hp' => $this->input->post('nomor_hp'),
                    'unit_id_' => $this->input->post('unit_id_'),
                    'pangkat_id' => $this->input->post('pangkat_id'),
                    'pangkat_tmt' => $this->input->post('pangkat_tmt'),
                    'pangkat_mk_thn' => $this->input->post('pangkat_mk_thn'),
                    'pangkat_mk_bln' => $this->input->post('pangkat_mk_bln'),
                    'npwp' => $this->input->post('npwp'),
                    'rekening' => $this->input->post('rekening'),
                    'status_pns' => $this->input->post('status_pns'),
                ];

                if (!empty($this->input->post('password'))) {
                    $post_data['password'] = md5($this->input->post('password'));
                }

                if ($action == 'tambah') {
                    $this->Pegawai_model->insert_pegawai($post_data);
                    $this->session->set_flashdata('success', 'Data pegawai berhasil ditambahkan.');
                } else {
                    $this->Pegawai_model->update_pegawai($nip, $post_data);
                    $this->session->set_flashdata('success', 'Data pegawai berhasil diperbarui.');
                }
                redirect('pegawai');
            }
        }

        $data['pegawai'] = ($action == 'edit') ? $this->Pegawai_model->get_pegawai_by_id($nip) : null;

        $this->load->view('template/header', $data);
        $this->load->view('pegawai/form', $data);
        $this->load->view('template/footer');
    }

    public function delete($nip)
    {
        $this->Pegawai_model->delete_pegawai($nip);
        $this->session->set_flashdata('success', 'Data pegawai berhasil dihapus.');
        redirect('pegawai');
    }
}
