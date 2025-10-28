<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kinerja extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kinerja_model');
        $this->load->model('Unit_model'); // To get unit data for dropdown
        $this->load->library('session');
    }

    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            header('Location: ' . (base_url("/user/login/")));
        }
    }

    public function index($unit_id = null, $tahun = null, $bulan = null)
    {
        $this->is_logged_in();
        $data['judul'] = 'Rekap Kinerja';
        $data['user_data'] = $this->session->userdata();

        // Default values for unit, year, month
        if ($unit_id === null || $unit_id === '') {
            $unit_id = $data['user_data']['unit_id'] ?? ''; // Use user's unit_id if available
        }
        if ($tahun === null) {
            $tahun = date('Y');
        }
        if ($bulan === null) {
            $bulan = date('m');
        }

        $data['selected_unit_id'] = $unit_id;
        $data['selected_tahun'] = $tahun;
        $data['selected_bulan'] = $bulan;

        // Fetch data for dropdowns
        $data['unit_all'] = $this->Unit_model->get_all(); // Assuming Unit_model has get_all()
        $data['tahun_options'] = $this->Kinerja_model->get_tahun_options();
        $data['bulan_options'] = $this->Kinerja_model->get_bulan_options();

        // Fetch rekap kinerja data
        $data['rekap_kinerja'] = $this->Kinerja_model->get_rekap_kinerja($unit_id, $tahun, $bulan);

        $this->load->view('template/header', $data);
        $this->load->view('kinerja/index', $data);
        $this->load->view('template/footer', $data);
    }
}
