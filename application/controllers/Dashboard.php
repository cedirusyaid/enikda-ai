<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Berkas_model');
    }

    public function index()
    {
        $data['judul'] = 'Dashboard';
        
        $tahun = $this->input->get('tahun') ?: date('Y');
        $unit_id = $this->input->get('unit_id');
        
        if ($this->session->userdata('admin_kabupaten') == 1) {
            $data['stats'] = $this->Berkas_model->get_dashboard_stats();
            $data['recent_submissions'] = $this->Berkas_model->get_recent_submissions(10);
            $data['unit_stats'] = $this->Berkas_model->get_unit_stats();
            $data['monthly_progress'] = $this->Berkas_model->get_monthly_progress($tahun);
            $data['yearly_data'] = $this->Berkas_model->get_yearly_submissions($tahun);
            $data['chart_data'] = $this->prepare_chart_data($data['yearly_data']);
        } else {
            $unit_id = $this->session->userdata('unit_id');
            $data['stats'] = $this->Berkas_model->get_unit_dashboard_stats($unit_id);
            $data['recent_submissions'] = $this->Berkas_model->get_recent_submissions_by_unit($unit_id, 5);
            $data['monthly_progress'] = $this->Berkas_model->get_monthly_progress($tahun);
            $data['yearly_data'] = $this->Berkas_model->get_yearly_submissions($tahun);
            $data['chart_data'] = $this->prepare_chart_data($data['yearly_data']);
        }
        
        $data['units'] = $this->Berkas_model->get_units();
        $data['selected_year'] = $tahun;
        $data['selected_unit'] = $unit_id;
        
        $this->load->view('template/header', $data);
        $this->load->view('berkas/dashboard', $data);
        $this->load->view('template/footer');
    }

    private function prepare_chart_data($yearly_data)
    {
        $labels = [];
        $approved_data = [];
        $total_data = [];
        $progress_data = [];
        
        foreach ($yearly_data as $data) {
            $labels[] = substr($data['bulan'], 0, 3);
            $approved_data[] = $data['approved'];
            $total_data[] = $data['total'];
            $progress_data[] = $data['progress'];
        }
        
        return [
            'labels' => $labels,
            'approved' => $approved_data,
            'total' => $total_data,
            'progress' => $progress_data
        ];
    }
}
