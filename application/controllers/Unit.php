<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Unit_model');
        $this->load->library('form_validation');
    }

    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            header('Location: ' . (base_url("/user/login/")));
        }
    }

    public function index()
    {
        $this->is_logged_in();
        $data['judul'] = 'Daftar Unit';
        $data['units'] = $this->Unit_model->get_all_with_employee_count();

        $this->load->view('template/header', $data);
        $this->load->view('unit/index', $data);
        $this->load->view('template/footer');
    }

    public function create()
    {
        $this->load->view('template/header');
        $this->load->view('unit/form');
        $this->load->view('template/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('unit_id', 'ID Unit', 'required');
        $this->form_validation->set_rules('unit_kode', 'Kode Unit', 'required');
        $this->form_validation->set_rules('unit_nama', 'Nama Unit', 'required');
        $this->form_validation->set_rules('unit_alamat', 'Alamat Unit', 'required');

        if ($this->form_validation->run() == FALSE)
        {
        $this->load->view('template/header');
            $this->load->view('unit/form');
        $this->load->view('template/footer');
        }
        else
        {
            $data = [
                'unit_id' => $this->input->post('unit_id'),
                'kabupaten_id' => $this->input->post('kabupaten_id'),
                'unit_kode' => $this->input->post('unit_kode'),
                'unit_nama' => $this->input->post('unit_nama'),
                'unit_alamat' => $this->input->post('unit_alamat'),
                'unit_telepon' => $this->input->post('unit_telepon'),
                'unit_fax' => $this->input->post('unit_fax'),
                'unit_email' => $this->input->post('unit_email'),
                'unit_web' => $this->input->post('unit_web'),
                'unit_facebook' => $this->input->post('unit_facebook'),
                'unit_instagram' => $this->input->post('unit_instagram'),
                'unit_twitter' => $this->input->post('unit_twitter'),
            ];

            $this->Unit_model->insert($data);
            redirect('unit');
        }
    }

    public function edit($id)
    {
        $data['unit'] = $this->Unit_model->get_by_id($id);
        $this->load->view('template/header');
        $this->load->view('unit/form', $data);
        $this->load->view('template/footer');
    }

    public function update($id)
    {
        $this->form_validation->set_rules('unit_kode', 'Kode Unit', 'required');
        $this->form_validation->set_rules('unit_nama', 'Nama Unit', 'required');
        $this->form_validation->set_rules('unit_alamat', 'Alamat Unit', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $data['unit'] = $this->Unit_model->get_by_id($id);
            $this->load->view('unit/form', $data);
        }
        else
        {
            $data = [
                'kabupaten_id' => $this->input->post('kabupaten_id'),
                'unit_kode' => $this->input->post('unit_kode'),
                'unit_nama' => $this->input->post('unit_nama'),
                'unit_alamat' => $this->input->post('unit_alamat'),
                'unit_telepon' => $this->input->post('unit_telepon'),
                'unit_fax' => $this->input->post('unit_fax'),
                'unit_email' => $this->input->post('unit_email'),
                'unit_web' => $this->input->post('unit_web'),
                'unit_facebook' => $this->input->post('unit_facebook'),
                'unit_instagram' => $this->input->post('unit_instagram'),
                'unit_twitter' => $this->input->post('unit_twitter'),
            ];

            $this->Unit_model->update($id, $data);
            redirect('unit');
        }
    }

    public function delete($id)
    {
        $this->Unit_model->delete($id);
        redirect('unit');
    }
}
