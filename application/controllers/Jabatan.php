<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jabatan_model');
        // $this->load->model('Pegawai_model');
    }

    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            header('Location: ' . (base_url("/user/login/")));
        }
    }

    public function index($unit_id = 0)
    {
        $this->is_logged_in();
        // print_r($this->session->userdata()); die();
        $data['judul'] = 'Daftar Jabatan';
        $data['user_data'] = $user_data = $this->session->userdata();
        if ($unit_id == 0) {
            $unit_id = $user_data['unit_id'];
        }
        $data['unit_id'] = $unit_id;
        $data["unit_all"] = $this->Jabatan_model->unit_all();
        $data["jabatan_all"] = $this->Jabatan_model->get_jabatan_by_unit($unit_id); // Menggunakan fungsi yang sudah ada

        $this->load->view("template/header", $data);
        $this->load->view("jabatan/index", $data);
        $this->load->view("template/footer", $data);
    }

    /**
     * Menggabungkan fungsi create dan edit menjadi satu fungsi form (CRUD).
     * Membutuhkan view baru di application/views/jabatan/form.php
     */
  public function crud($act = 'tambah', $unit_id = 0, $jabatan_id = 0) 
    {
        $this->is_logged_in();
        $data['user_data'] = $this->session->userdata();
        $data['judul'] = 'Form Jabatan';
        $data['act'] = $act;
        $dataform = [];

        // 1. PENANGANAN SUBMIT DATA (METHOD POST)
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $post_data = $this->input->post();
            $unit_id_redirect = $post_data['unit_id'];

            // Ambil data dari POST
            $dataform['jabatan_id'] = $post_data['jabatan_id'];
            $dataform['jabatan_nama'] = $post_data['jabatan_nama'];
            $dataform['jabatan_grup'] = $post_data['jabatan_grup'];
            $dataform['jabatan_nilai'] = $post_data['jabatan_nilai'];
            $dataform['jabatan_nip'] = (!empty($post_data['plt_nip'])) ? $post_data['plt_nip'] : $post_data['jabatan_nip'];
            $dataform['unit_id'] = $post_data['unit_id'];
            $dataform['jabatan_atasan_id'] = $post_data['jabatan_atasan_id'];
            $dataform['jabatan_jenis_id'] = $post_data['jabatan_jenis_id'];
            $dataform['tpp'] = $post_data['tpp'] ?? 1;
            // ... tambahkan field lain jika ada ...

            // Proses ke database
            if ($act == 'edit') {
                $this->Jabatan_model->edit($dataform['jabatan_id'], $dataform, 'jabatan_data', 'jabatan_id');
            } else { // 'tambah'
                unset($dataform['jabatan_id']); // Hapus ID untuk data baru
                $this->Jabatan_model->tambah($dataform, 'jabatan_data');
            }
            redirect('jabatan/index/' . $unit_id_redirect);
        
        // 2. PENANGANAN TAMPILAN FORM (METHOD GET)
        } else {
            if ($act == 'edit' && $jabatan_id > 0) {
                // Ambil data yang ada dari DB untuk ditampilkan di form
                $jabatan_data = $this->Jabatan_model->get_jabatan_by_id($jabatan_id);
                if ($jabatan_data) {
                    // Konversi object ke array
                    $dataform = (array) $jabatan_data;
                }
            } else { // 'tambah'
                // Siapkan data default untuk form tambah
                $dataform['jabatan_id'] = '';
                $dataform['jabatan_nama'] = '';
                $dataform['jabatan_grup'] = '';
                $dataform['jabatan_nilai'] = '';
                $dataform['jabatan_nip'] = '';
                $dataform['unit_id'] = $unit_id;
                $dataform['jabatan_atasan_id'] = '';
                $dataform['jabatan_jenis_id'] = '';
                $dataform['tpp'] = 1;
                $dataform['admin_unit'] = 0;
                $dataform['admin_kabupaten'] = 0;
            }
        }

        // 3. MEMUAT DATA UNTUK DROPDOWN & TAMPILAN
        $current_unit_id = ($act == 'edit' && isset($dataform['unit_id'])) ? $dataform['unit_id'] : $unit_id;
        $data['dataform'] = $dataform;
        $data['unit_all'] = $this->Jabatan_model->unit_all();
        $data['pegawai_all'] = $this->Jabatan_model->pegawai_all($current_unit_id);
        $data['jabatan_all'] = $this->Jabatan_model->jabatan_all($current_unit_id);
        $data['kode_jabatan_all'] = $this->Jabatan_model->kode_jabatan_all();
        $data['unit_info'] = $this->Jabatan_model->unit_info($current_unit_id);
        $data['pegawai_tanpa_jabatan'] = $this->Jabatan_model->pegawai_tanpa_jabatan();

        // 4. MENAMPILKAN VIEW
        $this->load->view("template/header", $data);
        $this->load->view("jabatan/form", $data);
        $this->load->view("template/footer", $data);
    }


    public function delete($jabatan_id)
    {
        $this->is_logged_in();
        $jabatan = $this->Jabatan_model->get_jabatan_by_id($jabatan_id);
        $this->Jabatan_model->delete_jabatan($jabatan_id);
        redirect('jabatan/index/' . $jabatan->unit_id);
    }

    public function detail($jabatan_id)
    {
        $this->is_logged_in();
        $data['title'] = 'Detail Jabatan';
        $data['jabatan'] = $this->Jabatan_model->get_jabatan_detail_by_id($jabatan_id);

        $this->load->view("template/header", $data);
        $this->load->view("jabatan/detail", $data);
        $this->load->view("template/footer", $data);
    }
}