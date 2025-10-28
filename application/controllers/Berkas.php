<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Berkas_model');
        $this->load->library('upload');
        $this->load->helper('form');
        
    }
    
    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            header('Location: ' . (base_url("/user/login/")));
        }
    }
    
    public function index() {
        $this->is_logged_in();
        $data['judul'] = 'Management Berkas TPP';
        
        $this->load->library('pagination');

        $selected_unit_id = $this->input->get('unit_id');
        $selected_status = $this->input->get('status') ?: 'all';
        $selected_tahun = $this->input->get('tahun') ?: date('Y'); // Default to current year
        $selected_bulan = $this->input->get('bulan') ?: 'all'; // Default to all months
        $page = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

        $config['base_url'] = base_url('berkas/index');
        $config['total_rows'] = $this->Berkas_model->count_submissions($selected_status, $selected_unit_id, $selected_tahun, $selected_bulan);
        $config['per_page'] = 10; // Number of items per page
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        // Customizing pagination links
        $config['full_tag_open'] = '<ul class="pagination justify-content-center mt-4">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $data['pagination_links'] = $this->pagination->create_links();

        // Cek role user
        if ($this->session->userdata('admin_kabupaten') > 0) {
            $data['units'] = $this->Berkas_model->get_units();
            $data['selected_unit_id'] = $selected_unit_id;
            $data['selected_status'] = $selected_status;
            $data['selected_tahun'] = $selected_tahun;
            $data['selected_bulan'] = $selected_bulan;

            $data['submissions'] = $this->Berkas_model->get_submissions_with_filter($selected_status, $selected_bulan, $selected_tahun, $selected_unit_id, $config['per_page'], $page);
        } else {
            // Admin OPD/unit hanya melihat data unitnya sendiri
            $unit_id = $this->session->userdata('unit_id');
            $data['submissions'] = $this->Berkas_model->get_submissions_with_filter($selected_status, $selected_bulan, $selected_tahun, $unit_id, $config['per_page'], $page);
            $data['selected_status'] = $selected_status;
            $data['selected_tahun'] = $selected_tahun;
            $data['selected_bulan'] = $selected_bulan;
        }

        $this->load->view('template/header', $data);
        $this->load->view('berkas/index', $data);
        $this->load->view('template/footer');
    }

    public function create() {
        $data['judul'] = 'Unggah Berkas TPP';
        $data['document_types'] = $this->Berkas_model->get_document_types();
        $data['units'] = $this->Berkas_model->get_units();
        
        $this->load->view('template/header', $data);
        $this->load->view('berkas/create', $data);
        $this->load->view('template/footer');
    }

    public function store() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('unit_id', 'Unit Kerja', 'required');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            // Check if submission already exists
            $existing = $this->Berkas_model->check_existing_submission(
                $this->input->post('unit_id'),
                $this->input->post('bulan'),
                $this->input->post('tahun')
            );
            
            if ($existing) {
                $this->session->set_flashdata('error', 'Berkas untuk bulan dan tahun tersebut sudah ada!');
                redirect('berkas/create');
            }
            
            // Create submission record
            $submission_id = $this->Berkas_model->create_submission([
                'unit_id' => $this->input->post('unit_id'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'status' => 'draft',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            // Upload files dan tangkap hasilnya
            $upload_errors = $this->upload_files($submission_id);
            
            // Jika ada error upload, hapus submission dan tampilkan error
            if (!empty($upload_errors)) {
                // Hapus submission yang sudah dibuat
                $this->Berkas_model->delete_submission($submission_id);
                
                // Tampilkan error
                $error_message = 'Gagal mengupload beberapa file:<br>' . implode('<br>', $upload_errors);
                $this->session->set_flashdata('error', $error_message);
                redirect('berkas/create');
            }
            
            // Create history record
            $this->Berkas_model->create_history([
                'submission_id' => $submission_id,
                'status' => 'draft',
                'catatan' => 'Berkas awal diunggah',
                'nip' => $this->session->userdata('nip'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->session->set_flashdata('success', 'Berkas berhasil diunggah!');
            redirect('berkas');
        }
    }

    private function upload_files($submission_id) {
        $document_types = $this->Berkas_model->get_document_types();
        $upload_errors = [];
        
        foreach ($document_types as $type) {
            $field_name = 'document_' . $type->id;
            
            if (isset($_FILES[$field_name]) && $_FILES[$field_name]['name'] != '') {
                $config['upload_path'] = './uploads/berkas/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['max_size'] = $type->id == 1 ? 1024 : 10240; // 1MB or 10MB
                $config['file_name'] = 'doc_' . $submission_id . '_' . $type->id . '_' . time();
                $config['overwrite'] = false;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload($field_name)) {
                    $file_data = $this->upload->data();
                    
                    $this->Berkas_model->create_file([
                        'submission_id' => $submission_id,
                        'type_id' => $type->id,
                        'nama_file' => $file_data['file_name'],
                        'path_file' => $file_data['full_path'],
                        'size' => $file_data['file_size'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    // Kumpulkan error message
                    $error_msg = $this->upload->display_errors();
                    $upload_errors[] = "File {$type->nama}: " . strip_tags($error_msg);
                }
            }
        }
        
        return $upload_errors;
    }    
    public function edit($id) {
        $data['judul'] = 'Edit Berkas TPP';
        $data['submission'] = $this->Berkas_model->get_submission($id);
        
        // Check ownership and permissions
        if (!$this->can_edit_submission($data['submission'])) {
            redirect('berkas');
        }
        
        $data['files'] = $this->Berkas_model->get_files_with_validation($id);
        $data['document_types'] = $this->Berkas_model->get_document_types();
        $data['units'] = $this->Berkas_model->get_units();
        $data['history'] = $this->Berkas_model->get_history($id);
        
        $this->load->view('template/header', $data);
        $this->load->view('berkas/edit', $data);
        $this->load->view('template/footer');
    }

    public function update($id) {
        $submission = $this->Berkas_model->get_submission($id);
        
        // Check ownership and permissions
        if (!$this->can_edit_submission($submission)) {
            redirect('berkas');
        }
        
        $this->load->library('form_validation');
        
        // Jika admin kabupaten, bisa edit unit dan periode
        if ($this->session->userdata('admin_kabupaten') > 0) {
            $this->form_validation->set_rules('unit_id', 'Unit Kerja', 'required');
            $this->form_validation->set_rules('bulan', 'Bulan', 'required');
            $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        }
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('berkas/edit/' . $id);
        }
        
        // Prepare update data
        $update_data = [
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Hanya admin kabupaten yang bisa edit unit dan periode
        if ($this->session->userdata('admin_kabupaten') > 0) {
            $update_data['unit_id'] = $this->input->post('unit_id');
            $update_data['bulan'] = $this->input->post('bulan');
            $update_data['tahun'] = $this->input->post('tahun');
            
            // Check for duplicate submission
            $existing = $this->Berkas_model->check_existing_submission(
                $update_data['unit_id'],
                $update_data['bulan'],
                $update_data['tahun']
            );
            
            if ($existing && $existing->id != $id) {
                $this->session->set_flashdata('error', 
                    'Berkas untuk unit, bulan, dan tahun tersebut sudah ada!');
                redirect('berkas/edit/' . $id);
            }
        }
        
        // Update submission data
        $this->Berkas_model->update_submission($id, $update_data);
        
        // Handle file uploads dan tangkap error
        $upload_errors = $this->handle_file_uploads($id);
        
        // Handle file deletions
        $this->handle_file_deletions($id);
        
        // Debug: Tampilkan error upload jika ada
        if (!empty($upload_errors)) {
            error_log('Upload Errors: ' . implode(', ', $upload_errors));
            $error_message = 'Gagal mengupload beberapa file:<br>' . implode('<br>', $upload_errors);
            $this->session->set_flashdata('error', $error_message);
            redirect('berkas/edit/' . $id);
        }
        
        // Create edit history
        $this->Berkas_model->create_history([
            'submission_id' => $id,
            'status' => $submission->status,
            'catatan' => 'Berkas diperbarui',
            'nip' => $this->session->userdata('nip'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 'Berkas berhasil diperbarui!');
        redirect('berkas');
    }
    public function upload_single_file($submission_id, $type_id) {
        $submission = $this->Berkas_model->get_submission($submission_id);

        // Check ownership and permissions
        if (!$this->can_edit_submission($submission)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengunggah file ini.');
            redirect('berkas/detail/' . $submission_id);
        }

        $document_type = $this->Berkas_model->get_document_type_by_id($type_id);
        if (!$document_type) {
            $this->session->set_flashdata('error', 'Jenis dokumen tidak ditemukan.');
            redirect('berkas/detail/' . $submission_id);
        }

        $field_name = 'document_file'; // Name of the file input in the form

        if (isset($_FILES[$field_name]) && $_FILES[$field_name]['name'] != '') {
            $upload_path = './uploads/berkas/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = $type_id == 1 ? 1024 : 10240; // 1MB or 10MB
            $config['file_name'] = 'doc_' . $submission_id . '_' . $type_id . '_' . time();
            $config['overwrite'] = false;

            $this->upload->initialize($config);

            if ($this->upload->do_upload($field_name)) {
                $file_data = $this->upload->data();

                $existing_file = $this->Berkas_model->get_file_by_type($submission_id, $type_id);

                if ($existing_file) {
                    // ### START PERBAIKAN ###
                    // Buat path absolut ke file lama untuk dihapus
                    $old_file_path = FCPATH . 'uploads/berkas/' . $existing_file->nama_file;
                    if (file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                    // ### END PERBAIKAN ###

                    // Update existing record
                    $this->Berkas_model->update_file($existing_file->id, [
                        'nama_file' => $file_data['file_name'],
                        'path_file' => $upload_path . $file_data['file_name'],
                        'size' => $file_data['file_size'],
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $history_note = 'File ' . $document_type->nama . ' diganti.';
                } else {
                    // Create new record
                    $this->Berkas_model->create_file([
                        'submission_id' => $submission_id,
                        'type_id' => $type_id,
                        'nama_file' => $file_data['file_name'],
                        'path_file' => $upload_path . $file_data['file_name'],
                        'size' => $file_data['file_size'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $history_note = 'File ' . $document_type->nama . ' diunggah.';
                }

                // Create history record
                $this->Berkas_model->create_history([
                    'submission_id' => $submission_id,
                    'status' => $submission->status, // Keep current status
                    'catatan' => $history_note,
                    'nip' => $this->session->userdata('nip'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $this->session->set_flashdata('success', 'File ' . $document_type->nama . ' berhasil diunggah/diganti!');
            } else {
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata('error', 'Gagal mengunggah file ' . $document_type->nama . ': ' . strip_tags($error_msg));
            }
        } else {
            $this->session->set_flashdata('error', 'Tidak ada file yang dipilih untuk diunggah.');
        }

        redirect('berkas/detail/' . $submission_id);
    }

    public function delete_file($submission_id, $file_id) {
        $submission = $this->Berkas_model->get_submission($submission_id);
        
        if (!$this->can_edit_submission($submission)) {
            redirect('berkas');
        }
        
        $file = $this->Berkas_model->get_file($file_id);
        
        if ($file && $file->submission_id == $submission_id) {
            // ### START PERBAIKAN ###
            // Buat path absolut ke file yang akan dihapus
            $file_path_to_delete = FCPATH . 'uploads/berkas/' . $file->nama_file;
            if (file_exists($file_path_to_delete)) {
                unlink($file_path_to_delete);
            }
            // ### END PERBAIKAN ###
            
            // Delete from database
            $this->Berkas_model->delete_file($file_id);
            
            // Create history
            $this->Berkas_model->create_history([
                'submission_id' => $submission_id,
                'status' => $submission->status,
                'catatan' => 'File dihapus: ' . $file->nama_file,
                'nip' => $this->session->userdata('nip'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->session->set_flashdata('success', 'File berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'File tidak ditemukan!');
        }
        
        // Redirect kembali ke halaman detail
        redirect('berkas/detail/' . $submission_id);
    }

    public function reset_to_draft($id) {
        $submission = $this->Berkas_model->get_submission($id);
        
        if (!$this->can_edit_submission($submission)) {
            redirect('berkas');
        }
        
        if (!in_array($submission->status, ['rejected', 'submitted'])) {
            $this->session->set_flashdata('error', 'Tidak dapat mereset status berkas!');
            redirect('berkas/edit/' . $id);
        }
        
        $this->Berkas_model->update_submission($id, [
            'status' => 'draft',
            'catatan' => 'Direset untuk revisi',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->Berkas_model->create_history([
            'submission_id' => $id,
            'status' => 'draft',
            'catatan' => 'Berkas direset ke draft untuk revisi',
            'nip' => $this->session->userdata('nip'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 'Berkas berhasil direset ke draft!');
        redirect('berkas/edit/' . $id);
    }

    private function can_edit_submission($submission) {
        if (!$submission) {
            return false;
        }
        
        if ($this->session->userdata('admin_kabupaten') > 0) {
            return true;
        }
        
        if ($this->session->userdata('admin_unit') > 0) {
            return $submission->unit_id == $this->session->userdata('unit_id');
        }
        
        return false;
    }

    private function handle_file_uploads($submission_id) {
        $document_types = $this->Berkas_model->get_document_types();
        $upload_errors = [];
        
        $upload_path = './uploads/berkas/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }
        
        foreach ($document_types as $type) {
            $field_name = 'document_' . $type->id;
            
            if (isset($_FILES[$field_name]) && $_FILES[$field_name]['name'] != '') {
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['max_size'] = $type->id == 1 ? 1024 : 10240;
                $config['file_name'] = 'doc_' . $submission_id . '_' . $type->id . '_' . time();
                $config['overwrite'] = false;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload($field_name)) {
                    $file_data = $this->upload->data();
                    
                    $existing_file = $this->Berkas_model->get_file_by_type($submission_id, $type->id);
                    
                    if ($existing_file) {
                        // ### START PERBAIKAN ###
                        $old_file_path = FCPATH . 'uploads/berkas/' . $existing_file->nama_file;
                        if (file_exists($old_file_path)) {
                            unlink($old_file_path);
                        }
                        // ### END PERBAIKAN ###
                        
                        $this->Berkas_model->update_file($existing_file->id, [
                            'nama_file' => $file_data['file_name'],
                            'path_file' => $upload_path . $file_data['file_name'],
                            'size' => $file_data['file_size'],
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        $this->Berkas_model->create_file([
                            'submission_id' => $submission_id,
                            'type_id' => $type->id,
                            'nama_file' => $file_data['file_name'],
                            'path_file' => $upload_path . $file_data['file_name'],
                            'size' => $file_data['file_size'],
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                } else {
                    $error_msg = $this->upload->display_errors();
                    $upload_errors[] = "File {$type->nama}: " . strip_tags($error_msg);
                }
            }
        }
        
        return $upload_errors;
    }
    
    private function handle_file_deletions($submission_id) {
        $document_types = $this->Berkas_model->get_document_types();
        
        foreach ($document_types as $type) {
            $delete_field = 'delete_document_' . $type->id;
            
            if ($this->input->post($delete_field) == '1') {
                $file = $this->Berkas_model->get_file_by_type($submission_id, $type->id);
                
                if ($file) {
                    $file_path_to_delete = FCPATH . 'uploads/berkas/' . $file->nama_file;
                    if (file_exists($file_path_to_delete)) {
                        unlink($file_path_to_delete);
                    }
                    $this->Berkas_model->delete_file($file->id);
                }
            }
        }
    }

    public function preview_file($file_id) {
        $file = $this->Berkas_model->get_file($file_id);
        
        if (!$file) {
            show_404();
        }
        
        $submission = $this->Berkas_model->get_submission($file->submission_id);
        if (!$this->can_edit_submission($submission) && !$this->session->userdata('admin_kabupaten')) {
            show_error('Anda tidak memiliki akses ke file ini.');
        }
        
        $file_path = FCPATH . 'uploads/berkas/' . $file->nama_file;
        
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $file->nama_file . '"');
            readfile($file_path);
        } else {
            show_error('File tidak ditemukan.');
        }
    }

    public function submit($id) {
        $submission = $this->Berkas_model->get_submission($id);
        
        if ($submission->unit_id != $this->session->userdata('unit_id') && $this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $this->Berkas_model->update_submission($id, ['status' => 'submitted']);
        
        $this->Berkas_model->create_history([
            'submission_id' => $id,
            'status' => 'submitted',
            'catatan' => 'Berkas diajukan untuk review',
            'nip' => $this->session->userdata('nip'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 'Berkas berhasil diajukan!');
        redirect('berkas');
    }

    public function delete($id) {
        $submission = $this->Berkas_model->get_submission($id);
        
        if ($submission->unit_id != $this->session->userdata('unit_id') && $this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $files = $this->Berkas_model->get_files($id);
        foreach ($files as $file) {
            $file_path_to_delete = FCPATH . 'uploads/berkas/' . $file->nama_file;
            if (file_exists($file_path_to_delete)) {
                unlink($file_path_to_delete);
            }
        }
        
        $this->Berkas_model->delete_submission($id);
        
        $this->session->set_flashdata('success', 'Berkas berhasil dihapus!');
        redirect('berkas');
    }

    public function approve($id) {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $this->Berkas_model->update_submission($id, [
            'status' => 'approved',
            'catatan' => $this->input->post('catatan')
        ]);
        
        $this->Berkas_model->create_history([
            'submission_id' => $id,
            'status' => 'approved',
            'catatan' => $this->input->post('catatan'),
            'nip' => $this->session->userdata('nip'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 'Berkas disetujui!');
        redirect('berkas/review');
    }

    public function reject($id) {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $this->Berkas_model->update_submission($id, [
            'status' => 'rejected',
            'catatan' => $this->input->post('catatan')
        ]);
        
        $this->Berkas_model->create_history([
            'submission_id' => $id,
            'status' => 'rejected',
            'catatan' => $this->input->post('catatan'),
            'nip' => $this->session->userdata('nip'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 'Berkas ditolak!');
        redirect('berkas/review');
    }

    public function management() {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $data['judul'] = 'Management Status Berkas TPP';
        
        $status = $this->input->get('status');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $unit_id = $this->input->get('unit_id');
        
        $data['submissions'] = $this->Berkas_model->get_submissions_with_filter($status, $bulan, $tahun, $unit_id);
        $data['units'] = $this->Berkas_model->get_units();
        $data['status_count'] = $this->Berkas_model->get_status_count();
        
        $this->load->view('template/header', $data);
        $this->load->view('berkas/management', $data);
        $this->load->view('template/footer');
    }

    public function detail($id) {
        $data['judul'] = 'Detail Berkas TPP';
        $data['submission'] = $this->Berkas_model->get_submission_detail($id);
        $data['files'] = $this->Berkas_model->get_files($id);
        $data['history'] = $this->Berkas_model->get_history($id);
        $data['document_types'] = $this->Berkas_model->get_document_types();
        
        $this->load->view('template/header', $data);
        $this->load->view('berkas/detail', $data);
        $this->load->view('template/footer');
    }

    public function update_status($id) {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('catatan', 'Catatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Semua field harus diisi!');
            redirect('berkas/detail/' . $id);
        }
        
        $submission = $this->Berkas_model->get_submission($id);
        $new_status = $this->input->post('status');
        $catatan = $this->input->post('catatan');
        
        $this->Berkas_model->update_submission($id, [
            'status' => $new_status,
            'catatan' => $catatan,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->Berkas_model->create_history([
            'submission_id' => $id,
            'status' => $new_status,
            'catatan' => $catatan,
            'nip' => $this->session->userdata('nip'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $status_text = [
            'draft' => 'draft',
            'submitted' => 'diajukan',
            'approved' => 'disetujui',
            'rejected' => 'ditolak'
        ];
        
        $this->session->set_flashdata('success', 
            "Status berkas {$submission->unit_nama} {$submission->bulan} {$submission->tahun} berhasil diubah menjadi {$status_text[$new_status]}!");
        
        redirect('berkas/management');
    }

    public function bulk_action() {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $action = $this->input->post('action');
        $selected = $this->input->post('selected');
        
        if (empty($selected)) {
            $this->session->set_flashdata('error', 'Tidak ada berkas yang dipilih!');
            redirect('berkas/management');
        }
        
        $success_count = 0;
        $failed_count = 0;
        
        foreach ($selected as $submission_id) {
            if ($this->Berkas_model->update_submission($submission_id, [
                'status' => $action,
                'updated_at' => date('Y-m-d H:i:s')
            ])) {
                $this->Berkas_model->create_history([
                    'submission_id' => $submission_id,
                    'status' => $action,
                    'catatan' => 'Bulk action: ' . $action,
                    'nip' => $this->session->userdata('nip'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $success_count++;
            } else {
                $failed_count++;
            }
        }
        
        $status_text = [
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
            'submitted' => 'diajukan'
        ];
        
        $message = "{$success_count} berkas berhasil di{$status_text[$action]}";
        if ($failed_count > 0) {
            $message .= ", {$failed_count} gagal";
        }
        
        $this->session->set_flashdata('success', $message);
        redirect('berkas/management');
    }

    public function export() {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $status = $this->input->get('status');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        
        $data['submissions'] = $this->Berkas_model->get_submissions_with_filter($status, $bulan, $tahun);
        $data['filter'] = [
            'status' => $status,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        
        $this->load->view('berkas/export', $data);
    }

    public function review() {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $data['judul'] = 'Review Berkas TPP';
        
        $status = $this->input->get('status') ?: 'submitted';
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $unit_id = $this->input->get('unit_id');
        
        $data['submissions'] = $this->Berkas_model->get_submissions_for_review($status, $bulan, $tahun, $unit_id);
        $data['units'] = $this->Berkas_model->get_units();
        $data['review_stats'] = $this->Berkas_model->get_review_stats();
        
        $this->load->view('template/header', $data);
        $this->load->view('berkas/review', $data);
        $this->load->view('template/footer');
    }

    public function review_detail($id) {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $data['judul'] = 'Review Detail Berkas';
        $data['submission'] = $this->Berkas_model->get_submission_for_review($id);
        
        if (!$data['submission']) {
            show_404();
        }
        
        $data['files'] = $this->Berkas_model->get_files_with_validation($id);
        $data['history'] = $this->Berkas_model->get_review_history($id);
        $data['validation_rules'] = $this->Berkas_model->get_validation_rules();
        
        $this->load->view('template/header', $data);
        $this->load->view('berkas/review_detail', $data);
        $this->load->view('template/footer');
    }

    public function process_approve($id) {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('catatan', 'Catatan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Catatan review harus diisi!');
            redirect('berkas/review_detail/' . $id);
        }
        
        $submission = $this->Berkas_model->get_submission($id);
        
        $missing_required = $this->Berkas_model->check_missing_required_files($id);
        if (!empty($missing_required)) {
            $this->session->set_flashdata('error', 
                'Tidak dapat menyetujui. Dokumen wajib berikut belum diupload: ' . 
                implode(', ', $missing_required));
            redirect('berkas/review_detail/' . $id);
        }
        
        $this->Berkas_model->update_submission($id, [
            'status' => 'approved',
            'catatan' => $this->input->post('catatan'),
            'reviewed_at' => date('Y-m-d H:i:s'),
            'reviewed_by' => $this->session->userdata('nip'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->Berkas_model->create_review_history([
            'submission_id' => $id,
            'action' => 'approved',
            'catatan' => $this->input->post('catatan'),
            'reviewer_nip' => $this->session->userdata('nip'),
            'reviewer_nama' => $this->session->userdata('nama'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 
            "Berkas {$submission->unit_nama} {$submission->bulan} {$submission->tahun} berhasil disetujui!");
        
        redirect('berkas/review');
    }

    public function process_reject($id) {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('catatan', 'Catatan Penolakan', 'required');
        $this->form_validation->set_rules('alasan', 'Alasan Penolakan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Alasan dan catatan penolakan harus diisi!');
            redirect('berkas/review_detail/' . $id);
        }
        
        $submission = $this->Berkas_model->get_submission($id);
        
        $this->Berkas_model->update_submission($id, [
            'status' => 'rejected',
            'catatan' => $this->input->post('catatan'),
            'alasan_penolakan' => $this->input->post('alasan'),
            'reviewed_at' => date('Y-m-d H:i:s'),
            'reviewed_by' => $this->session->userdata('nip'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->Berkas_model->create_review_history([
            'submission_id' => $id,
            'action' => 'rejected',
            'catatan' => $this->input->post('catatan'),
            'alasan' => $this->input->post('alasan'),
            'reviewer_nip' => $this->session->userdata('nip'),
            'reviewer_nama' => $this->session->userdata('nama'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 
            "Berkas {$submission->unit_nama} {$submission->bulan} {$submission->tahun} telah ditolak.");
        
        redirect('berkas/review');
    }

    public function return_to_submitted($id) {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $submission = $this->Berkas_model->get_submission($id);
        
        $this->Berkas_model->update_submission($id, [
            'status' => 'submitted',
            'catatan' => 'Dikembalikan untuk revisi',
            'reviewed_at' => null,
            'reviewed_by' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->Berkas_model->create_review_history([
            'submission_id' => $id,
            'action' => 'returned',
            'catatan' => 'Berkas dikembalikan untuk revisi',
            'reviewer_nip' => $this->session->userdata('nip'),
            'reviewer_nama' => $this->session->userdata('nama'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 
            "Berkas {$submission->unit_nama} {$submission->bulan} {$submission->tahun} dikembalikan ke status submitted.");
        
        redirect('berkas/review');
    }

    public function quick_approve() {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $selected = $this->input->post('selected');
        $catatan = $this->input->post('catatan') ?: 'Berkas telah disetujui melalui quick approve';
        
        if (empty($selected)) {
            $this->session->set_flashdata('error', 'Tidak ada berkas yang dipilih!');
            redirect('berkas/review');
        }
        
        $success_count = 0;
        $failed_count = 0;
        
        foreach ($selected as $submission_id) {
            $missing_required = $this->Berkas_model->check_missing_required_files($submission_id);
            if (!empty($missing_required)) {
                $failed_count++;
                continue;
            }
            
            if ($this->Berkas_model->update_submission($submission_id, [
                'status' => 'approved',
                'catatan' => $catatan,
                'reviewed_at' => date('Y-m-d H:i:s'),
                'reviewed_by' => $this->session->userdata('nip'),
                'updated_at' => date('Y-m-d H:i:s')
            ])) {
                $this->Berkas_model->create_review_history([
                    'submission_id' => $submission_id,
                    'action' => 'approved',
                    'catatan' => $catatan,
                    'reviewer_nip' => $this->session->userdata('nip'),
                    'reviewer_nama' => $this->session->userdata('nama'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $success_count++;
            } else {
                $failed_count++;
            }
        }
        
        $message = "{$success_count} berkas berhasil disetujui";
        if ($failed_count > 0) {
            $message .= ", {$failed_count} berkas gagal (dokumen tidak lengkap)";
        }
        
        $this->session->set_flashdata('success', $message);
        redirect('berkas/review');
    }

    public function review_report() {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $data['judul'] = 'Laporan Review Berkas';
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');
        $unit_id = $this->input->get('unit_id');
        
        $data['report_data'] = $this->Berkas_model->get_review_report($start_date, $end_date, $unit_id);
        $data['units'] = $this->Berkas_model->get_units();
        $data['filters'] = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'unit_id' => $unit_id
        ];
        
        $this->load->view('template/header', $data);
        $this->load->view('berkas/review_report', $data);
        $this->load->view('template/footer');
    }

    public function export_review_report() {
        if ($this->session->userdata('admin_kabupaten') == 0) {
            redirect('berkas');
        }
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');
        $unit_id = $this->input->get('unit_id');
        
        $data['report_data'] = $this->Berkas_model->get_review_report($start_date, $end_date, $unit_id);
        $data['filters'] = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'unit_id' => $unit_id
        ];
        
        $this->load->view('berkas/export_review_report', $data);
    }

}