<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas_model extends CI_Model {

    public function get_submissions_by_unit($unit_id, $status = null) {
        $this->db->select('ds.*, ud.unit_nama');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->where('ds.unit_id', $unit_id);
        if ($status && $status != 'all') {
            $this->db->where('ds.status', $status);
        }
        $this->db->order_by('ds.tahun DESC, ds.bulan DESC');
        return $this->db->get()->result();
    }

    public function count_submissions($status = null, $unit_id = null, $tahun = null, $bulan = null) {
        $this->db->from('document_submissions ds');
        if ($status && $status != 'all') {
            $this->db->where('ds.status', $status);
        }
        if ($unit_id) {
            $this->db->where('ds.unit_id', $unit_id);
        }
        if ($tahun && $tahun != 'all') {
            $this->db->where('ds.tahun', $tahun);
        }
        if ($bulan && $bulan != 'all') {
            $this->db->where('ds.bulan', $bulan);
        }
        return $this->db->count_all_results();
    }

    public function get_all_submissions() {
        $this->db->select('ds.*, ud.unit_nama');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->order_by('ds.tahun DESC, ds.bulan DESC');
        return $this->db->get()->result();
    }

    public function get_submission($id) {
        $this->db->select('ds.*, ud.unit_nama');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->where('ds.id', $id);
        return $this->db->get()->row();
    }

    public function get_document_types() {
        return $this->db->get('document_types')->result();
    }

    public function get_document_type_by_id($type_id) {
        return $this->db->get_where('document_types_', ['id' => $type_id])->row();
    }

    public function get_units() {
        return $this->db->get('unit_data')->result();
    }

    public function check_existing_submission($unit_id, $bulan, $tahun) {
        $this->db->where('unit_id', $unit_id);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->get('document_submissions')->row();
    }

    public function create_submission($data) {
        $this->db->insert('document_submissions', $data);
        return $this->db->insert_id();
    }

    public function update_submission($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('document_submissions', $data);
    }

    public function delete_submission($id) {
        // Delete related files first
        $this->db->where('submission_id', $id);
        $this->db->delete('document_files');
        
        // Delete history
        $this->db->where('submission_id', $id);
        $this->db->delete('document_history');
        
        // Delete submission
        $this->db->where('id', $id);
        $this->db->delete('document_submissions');
    }

    public function create_file($data) {
        $this->db->insert('document_files', $data);
    }

    public function get_files($submission_id) {
        $this->db->select('df.*, dt.nama as jenis_dokumen');
        $this->db->from('document_files df');
        $this->db->join('document_types dt', 'df.type_id = dt.id', 'left');
        $this->db->where('df.submission_id', $submission_id);
        return $this->db->get()->result();
    }

    // Get file by ID
    public function get_file($file_id) {
        return $this->db->get_where('document_files', ['id' => $file_id])->row();
    }

    // Get file by submission ID and type ID
    public function get_file_by_type($submission_id, $type_id) {
        return $this->db->get_where('document_files', [
            'submission_id' => $submission_id,
            'type_id' => $type_id
        ])->row();
    }

    // Update file
    public function update_file($file_id, $data) {
        $this->db->where('id', $file_id);
        return $this->db->update('document_files', $data);
    }
    // Get submission dengan informasi lengkap untuk edit
    public function get_submission_for_edit($id) {
        $this->db->select('ds.*, ud.unit_nama, ud.unit_alamat, 
                          pd.nama as last_editor, dh.created_at as last_edit_time');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->join('document_history dh', 'ds.id = dh.submission_id', 'left');
        $this->db->join('pegawai_data pd', 'dh.nip = pd.nip', 'left');
        $this->db->where('ds.id', $id);
        $this->db->order_by('dh.created_at', 'DESC');
        $this->db->limit(1);
        
        return $this->db->get()->row();
    }

    // Check if submission can be edited
    public function can_edit_submission($submission_id, $user_data) {
        $submission = $this->get_submission($submission_id);
        
        if (!$submission) {
            return false;
        }
        
        // Admin kabupaten can edit all
        if ($user_data['admin_kabupaten'] == 1) {
            return true;
        }
        
        // Admin unit can only edit their unit's submissions
        if ($user_data['admin_unit'] == 1) {
            return $submission->unit_id == $user_data['unit_id'];
        }
        
        return false;
    }

    // Get edit history
    public function get_edit_history($submission_id) {
        $this->db->select('dh.*, pd.nama, pd.nip');
        $this->db->from('document_history dh');
        $this->db->join('pegawai_data pd', 'dh.nip = pd.nip', 'left');
        $this->db->where('dh.submission_id', $submission_id);
        $this->db->where('dh.catatan LIKE', '%diperbarui%');
        $this->db->or_where('dh.catatan LIKE', '%diupload%');
        $this->db->or_where('dh.catatan LIKE', '%dihapus%');
        $this->db->order_by('dh.created_at', 'DESC');
        
        return $this->db->get()->result();
    }

    // Get file upload history
    public function get_file_history($submission_id) {
        $this->db->select('df.*, dt.nama as jenis_dokumen, 
                          pd.nama as uploaded_by, dh.created_at as upload_time');
        $this->db->from('document_files df');
        $this->db->join('document_types dt', 'df.type_id = dt.id', 'left');
        $this->db->join('document_history dh', 'df.submission_id = dh.submission_id', 'left');
        $this->db->join('pegawai_data pd', 'dh.nip = pd.nip', 'left');
        $this->db->where('df.submission_id', $submission_id);
        $this->db->where('dh.catatan LIKE', '%diupload%');
        $this->db->order_by('dh.created_at', 'DESC');
        
        return $this->db->get()->result();
    }



    public function create_history($data) {
        $this->db->insert('document_history', $data);
    }

    public function get_history($submission_id) {
        $this->db->select('dh.*, pd.nama');
        $this->db->from('document_history dh');
        $this->db->join('pegawai_data pd', 'dh.nip = pd.nip', 'left');
        $this->db->where('dh.submission_id', $submission_id);
        $this->db->order_by('dh.created_at', 'DESC');
        return $this->db->get()->result();
    }

 public function get_submissions_with_filter($status = null, $bulan = null, $tahun = null, $unit_id = null, $limit = null, $start = null) {
        $this->db->select('ds.*, ud.unit_nama, COUNT(df.id) as jumlah_file');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->join('document_files df', 'ds.id = df.submission_id', 'left');
        
        if ($status && $status != 'all') {
            $this->db->where('ds.status', $status);
        }
        
        if ($bulan && $bulan != 'all') {
            $this->db->where('ds.bulan', $bulan);
        }
        
        if ($tahun && $tahun != 'all') {
            $this->db->where('ds.tahun', $tahun);
        }
        
        if ($unit_id && $unit_id != 'all') {
            $this->db->where('ds.unit_id', $unit_id);
        }
        
        $this->db->group_by('ds.id');
        $this->db->order_by('ds.tahun DESC, ds.bulan DESC, ud.unit_nama ASC, ds.created_at DESC');

        if ($limit !== null && $start !== null) {
            $this->db->limit($limit, $start);
        }
        
        return $this->db->get()->result();
    }

    // Get submission detail lengkap
    public function get_submission_detail($id) {
        $this->db->select('ds.*, ud.unit_nama, ud.unit_alamat, pd.nama as uploader_nama');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->join('document_history dh', 'ds.id = dh.submission_id', 'left');
        $this->db->join('pegawai_data pd', 'dh.nip = pd.nip', 'left');
        $this->db->where('ds.id', $id);
        $this->db->group_by('ds.id');
        
        return $this->db->get()->row();
    }

    // Get status count untuk dashboard
    public function get_status_count() {
        $this->db->select('status, COUNT(*) as total');
        $this->db->from('document_submissions');
        $this->db->group_by('status');
        
        $result = $this->db->get()->result();
        
        $counts = [
            'draft' => 0,
            'submitted' => 0,
            'approved' => 0,
            'rejected' => 0,
            'total' => 0
        ];
        
        foreach ($result as $row) {
            $counts[$row->status] = $row->total;
            $counts['total'] += $row->total;
        }
        
        return $counts;
    }

    // Get dashboard statistics
    public function get_dashboard_stats() {
        $stats = [];
        
        // Total submissions bulan ini
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $stats['monthly_total'] = $this->db->count_all_results('document_submissions');
        
        // Pending reviews
        $this->db->where('status', 'submitted');
        $stats['pending_reviews'] = $this->db->count_all_results('document_submissions');
        
        // Approved this month
        $this->db->where('status', 'approved');
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $stats['monthly_approved'] = $this->db->count_all_results('document_submissions');
        
        // Units with incomplete submissions
        $this->db->select('COUNT(DISTINCT unit_id) as total');
        $this->db->where('status !=', 'approved');
        $this->db->where('MONTH(created_at)', date('m'));
        $stats['units_pending'] = $this->db->get('document_submissions')->row()->total;
        
        return $stats;
    }

    // Get unit dashboard statistics
    public function get_unit_dashboard_stats($unit_id) {
        $stats = [];
        
        $this->db->where('unit_id', $unit_id);
        
        // Total submissions
        $stats['total'] = $this->db->count_all_results('document_submissions');
        
        // Current month submissions
        $this->db->where('unit_id', $unit_id);
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $stats['current_month'] = $this->db->count_all_results('document_submissions');
        
        // Status counts
        $statuses = ['draft', 'submitted', 'approved', 'rejected'];
        foreach ($statuses as $status) {
            $this->db->where('unit_id', $unit_id);
            $this->db->where('status', $status);
            $stats[$status] = $this->db->count_all_results('document_submissions');
        }
        
        return $stats;
    }

    // Get recent submissions
    public function get_recent_submissions($limit = 5) {
        $this->db->select('ds.*, ud.unit_nama');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->order_by('ds.created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    // Get recent submissions by unit
    public function get_recent_submissions_by_unit($unit_id, $limit = 5) {
        $this->db->select('ds.*, ud.unit_nama');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->where('ds.unit_id', $unit_id);
        $this->db->order_by('ds.created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    // Get unit statistics
    public function get_unit_stats() {
        $this->db->select('ud.unit_id, ud.unit_nama, 
                          COUNT(ds.id) as total_submissions,
                          SUM(CASE WHEN ds.status = "approved" THEN 1 ELSE 0 END) as approved,
                          SUM(CASE WHEN ds.status = "submitted" THEN 1 ELSE 0 END) as pending');
        $this->db->from('unit_data ud');
        $this->db->join('document_submissions ds', 'ud.unit_id = ds.unit_id', 'left');
        $this->db->where('ud.unit_id !=', '7307'); // Exclude parent unit
        $this->db->group_by('ud.unit_id');
        $this->db->order_by('total_submissions', 'DESC');
        
        return $this->db->get()->result();
    }

    // Check if user can modify submission
    public function can_modify($submission_id, $user_unit_id, $is_admin_kabupaten) {
        if ($is_admin_kabupaten) {
            return true;
        }
        
        $submission = $this->get_submission($submission_id);
        return $submission && $submission->unit_id == $user_unit_id;
    }
    // Get submissions untuk review
    public function get_submissions_for_review($status = 'submitted', $bulan = null, $tahun = null, $unit_id = null) {
        $this->db->select('ds.*, ud.unit_nama, ud.unit_alamat, 
                          COUNT(df.id) as jumlah_file,
                          pd.nama as uploader_nama,
                          pd.nip as uploader_nip'); // Tambahkan ini
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->join('document_files df', 'ds.id = df.submission_id', 'left');
        $this->db->join('document_history dh', 'ds.id = dh.submission_id AND dh.status = "submitted"', 'left');
        $this->db->join('pegawai_data pd', 'dh.nip = pd.nip', 'left');
        
        if ($status && $status != 'all') {
            $this->db->where('ds.status', $status);
        }
        
        if ($bulan && $bulan != 'all') {
            $this->db->where('ds.bulan', $bulan);
        }
        
        if ($tahun && $tahun != 'all') {
            $this->db->where('ds.tahun', $tahun);
        }
        
        if ($unit_id && $unit_id != 'all') {
            $this->db->where('ds.unit_id', $unit_id);
        }
        
        $this->db->group_by('ds.id');
        $this->db->order_by('ds.created_at', 'ASC'); // Yang paling lama pertama
        
        return $this->db->get()->result();
    }

    // Get submission detail untuk review
    public function get_submission_for_review($id) {
        $this->db->select('ds.*, ud.unit_nama, ud.unit_alamat, ud.unit_telepon,
                          pd.nama as uploader_nama, pd.nip as uploader_nip');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->join('document_history dh', 'ds.id = dh.submission_id AND dh.status = "submitted"', 'left');
        $this->db->join('pegawai_data pd', 'dh.nip = pd.nip', 'left');
        $this->db->where('ds.id', $id);
        
        return $this->db->get()->row();
    }

    // Get files dengan informasi validasi
    // public function get_files_with_validation($submission_id) {
    //     $this->db->select('df.*, dt.nama as jenis_dokumen, dt.required, dt.deskripsi,
    //                       CASE WHEN df.id IS NOT NULL THEN 1 ELSE 0 END as is_uploaded');
    //     $this->db->from('document_types dt');
    //     $this->db->join('document_files df', 
    //         "dt.id = df.type_id AND df.submission_id = $submission_id", 'left');
    //     $this->db->order_by('dt.id', 'ASC');
        
    //     return $this->db->get()->result();
    // }

    // Get files dengan informasi validasi
    public function get_files_with_validation($submission_id) {
        $query = "
            SELECT 
                df.*, 
                dt.nama as jenis_dokumen, 
                dt.required, 
                dt.deskripsi,
                CASE WHEN df.id IS NOT NULL THEN 1 ELSE 0 END as is_uploaded
            FROM document_types dt
            LEFT JOIN document_files df ON dt.id = df.type_id AND df.submission_id = ?
            ORDER BY dt.id ASC
        ";
        
        return $this->db->query($query, [$submission_id])->result();
    }

    // Check missing required files
    public function check_missing_required_files($submission_id) {
        $this->db->select('dt.nama');
        $this->db->from('document_types dt');
        $this->db->join('document_files df', 
            "dt.id = df.type_id AND df.submission_id = $submission_id", 'left');
        $this->db->where('dt.required', 1);
        $this->db->where('df.id IS NULL');
        
        $result = $this->db->get()->result();
        $missing = [];
        
        foreach ($result as $row) {
            $missing[] = $row->nama;
        }
        
        return $missing;
    }

    // Get review statistics
    public function get_review_stats() {
        $stats = [];
        
        // Total waiting review
        $this->db->where('status', 'submitted');
        $stats['waiting_review'] = $this->db->count_all_results('document_submissions');
        
        // Reviewed today
        $this->db->where('DATE(reviewed_at)', date('Y-m-d'));
        $stats['reviewed_today'] = $this->db->count_all_results('document_submissions');
        
        // Monthly stats
        $this->db->select("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
        ");
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $this->db->where('status IN ("approved", "rejected")');
        $monthly = $this->db->get('document_submissions')->row();
        
        $stats['monthly_total'] = $monthly->total;
        $stats['monthly_approved'] = $monthly->approved;
        $stats['monthly_rejected'] = $monthly->rejected;
        
        return $stats;
    }

    // Get review history
    public function get_review_history($submission_id) {
        $this->db->select('rh.*, pd.nama as reviewer_nama');
        $this->db->from('document_review_history rh');
        $this->db->join('pegawai_data pd', 'rh.reviewer_nip = pd.nip', 'left');
        $this->db->where('rh.submission_id', $submission_id);
        $this->db->order_by('rh.created_at', 'DESC');
        
        return $this->db->get()->result();
    }

    // Create review history
    public function create_review_history($data) {
        return $this->db->insert('document_review_history', $data);
    }

    // Get validation rules
    public function get_validation_rules() {
        return [
            'file_size' => [
                'type_1' => 1, // MB
                'type_2' => 10,
                'type_3' => 10,
                'type_4' => 10,
                'type_5' => 10,
                'type_6' => 10,
                'type_7' => 10,
                'type_8' => 10,
                'type_9' => 10
            ],
            'file_types' => ['pdf', 'doc', 'docx'],
            'required_docs' => [2, 3, 4, 5, 6, 7, 8, 9] // ID dokumen wajib
        ];
    }

    // Get review report
    public function get_review_report($start_date, $end_date, $unit_id = null) {
        $this->db->select('ds.*, ud.unit_nama, 
                          pd_reviewer.nama as reviewer_nama,
                          pd_uploader.nama as uploader_nama,
                          COUNT(df.id) as file_count');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->join('pegawai_data pd_reviewer', 'ds.reviewed_by = pd_reviewer.nip', 'left');
        $this->db->join('document_history dh', 'ds.id = dh.submission_id AND dh.status = "submitted"', 'left');
        $this->db->join('pegawai_data pd_uploader', 'dh.nip = pd_uploader.nip', 'left');
        $this->db->join('document_files df', 'ds.id = df.submission_id', 'left');
        
        $this->db->where('ds.reviewed_at >=', $start_date . ' 00:00:00');
        $this->db->where('ds.reviewed_at <=', $end_date . ' 23:59:59');
        $this->db->where('ds.status IN ("approved", "rejected")');
        
        if ($unit_id && $unit_id != 'all') {
            $this->db->where('ds.unit_id', $unit_id);
        }
        
        $this->db->group_by('ds.id');
        $this->db->order_by('ds.reviewed_at', 'DESC');
        
        return $this->db->get()->result();
    }

    // Get reviewer performance
    public function get_reviewer_performance($start_date, $end_date) {
        $this->db->select('
            pd.nip,
            pd.nama,
            COUNT(ds.id) as total_reviewed,
            SUM(CASE WHEN ds.status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN ds.status = "rejected" THEN 1 ELSE 0 END) as rejected,
            AVG(TIMESTAMPDIFF(HOUR, ds.created_at, ds.reviewed_at)) as avg_review_time
        ');
        $this->db->from('document_submissions ds');
        $this->db->join('pegawai_data pd', 'ds.reviewed_by = pd.nip');
        $this->db->where('ds.reviewed_at >=', $start_date . ' 00:00:00');
        $this->db->where('ds.reviewed_at <=', $end_date . ' 23:59:59');
        $this->db->where('ds.status IN ("approved", "rejected")');
        $this->db->group_by('pd.nip');
        $this->db->order_by('total_reviewed', 'DESC');
        
        return $this->db->get()->result();
    }
    // Delete file
    public function delete_file($file_id) {
        $this->db->where('id', $file_id);
        return $this->db->delete('document_files');
    }

    // Get monthly progress statistics
    public function get_monthly_progress($tahun = null) {
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $this->db->select('
            bulan,
            COUNT(*) as total_submissions,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "submitted" THEN 1 ELSE 0 END) as submitted,
            SUM(CASE WHEN status = "draft" THEN 1 ELSE 0 END) as draft,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected
        ');
        $this->db->from('document_submissions');
        $this->db->where('tahun', $tahun);
        
        // Jika bukan admin kabupaten, filter by unit
        if ($this->session->userdata('admin_kabupaten') == 0) {
            $unit_id = $this->session->userdata('unit_id');
            $this->db->where('unit_id', $unit_id);
        }
        
        $this->db->group_by('bulan');
        $this->db->order_by('FIELD(bulan, 
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        )');
        
        return $this->db->get()->result();
    }

    // Get unit monthly progress
    public function get_unit_monthly_progress($unit_id = null, $tahun = null) {
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $this->db->select('
            ds.bulan,
            ud.unit_nama,
            COUNT(ds.id) as total_submissions,
            SUM(CASE WHEN ds.status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN ds.status = "submitted" THEN 1 ELSE 0 END) as submitted,
            SUM(CASE WHEN ds.status = "draft" THEN 1 ELSE 0 END) as draft,
            SUM(CASE WHEN ds.status = "rejected" THEN 1 ELSE 0 END) as rejected
        ');
        $this->db->from('document_submissions ds');
        $this->db->join('unit_data ud', 'ds.unit_id = ud.unit_id', 'left');
        $this->db->where('ds.tahun', $tahun);
        
        if ($unit_id && $unit_id != 'all') {
            $this->db->where('ds.unit_id', $unit_id);
        }
        
        $this->db->group_by('ds.bulan, ud.unit_id');
        $this->db->order_by('FIELD(ds.bulan, 
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        )');
        
        return $this->db->get()->result();
    }

    // Get current year submissions by month
    public function get_yearly_submissions($tahun = null) {
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $bulan_list = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $result = [];
        
        foreach ($bulan_list as $bulan) {
            $this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            
            // Jika bukan admin kabupaten, filter by unit
            if ($this->session->userdata('admin_kabupaten') == 0) {
                $unit_id = $this->session->userdata('unit_id');
                $this->db->where('unit_id', $unit_id);
            }
            
            $total = $this->db->count_all_results('document_submissions');
            
            $this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            $this->db->where('status', 'approved');
            
            if ($this->session->userdata('admin_kabupaten') == 0) {
                $unit_id = $this->session->userdata('unit_id');
                $this->db->where('unit_id', $unit_id);
            }
            
            $approved = $this->db->count_all_results('document_submissions');
            
            $result[] = [
                'bulan' => $bulan,
                'total' => $total,
                'approved' => $approved,
                'progress' => $total > 0 ? round(($approved / $total) * 100, 2) : 0
            ];
        }
        
        return $result;
    }

    
}