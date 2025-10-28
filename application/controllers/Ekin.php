<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ekin extends CI_Controller {

    // =========================================================================
    // KELOLA KONFIGURASI
    // =========================================================================

    // --- Metode CRUD Konfigurasi ada di sini ---

    // =========================================================================
    // KELOLA PERIODE
    // =========================================================================

    public function periode()
    {
        $data['periode_data'] = $this->Ekin_model->get_all_periode();
        $this->load->view('template/header');
        $this->load->view('ekin/periode_list', $data);
        $this->load->view('template/footer');
    }

    public function periode_tambah()
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('ekin/periode_tambah_aksi'),
            'id' => set_value('id'),
            'nama' => set_value('nama'),
            'tahun' => set_value('tahun', date('Y')),
            'periode_awal' => set_value('periode_awal'),
            'periode_akhir' => set_value('periode_akhir'),
            'batas_pengisian' => set_value('batas_pengisian'),
            'jenis_periode' => set_value('jenis_periode'),
            'tipe_periodik' => set_value('tipe_periodik', 'bulanan'),
            'angka_periodik' => set_value('angka_periodik'),
            'title' => 'Tambah Periode',
        );
        $this->load->view('template/header');
        $this->load->view('ekin/periode_form', $data);
        $this->load->view('template/footer');
    }

    public function periode_tambah_aksi()
    {
        $this->_periode_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->periode_tambah();
        } else {
            $this->load->helper('string');
            $data = array(
                'id' => random_string('alnum', 32), // Membuat ID unik
                'nama' => $this->input->post('nama', TRUE),
                'tahun' => $this->input->post('tahun', TRUE),
                'periode_awal' => $this->input->post('periode_awal', TRUE),
                'periode_akhir' => $this->input->post('periode_akhir', TRUE),
                'batas_pengisian' => $this->input->post('batas_pengisian', TRUE),
                'jenis_periode' => $this->input->post('jenis_periode', TRUE),
                'tipe_periodik' => $this->input->post('tipe_periodik', TRUE),
                'angka_periodik' => $this->input->post('angka_periodik', TRUE),
            );

            $this->Ekin_model->insert_periode($data);
            $this->session->set_flashdata('message', 'Periode berhasil ditambahkan');
            redirect(site_url('ekin/periode'));
        }
    }

    public function periode_ubah($id)
    {
        $row = $this->Ekin_model->get_periode_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Ubah',
                'action' => site_url('ekin/periode_ubah_aksi'),
                'id' => set_value('id', $row->id),
                'nama' => set_value('nama', $row->nama),
                'tahun' => set_value('tahun', $row->tahun),
                'periode_awal' => set_value('periode_awal', $row->periode_awal),
                'periode_akhir' => set_value('periode_akhir', $row->periode_akhir),
                'batas_pengisian' => set_value('batas_pengisian', $row->batas_pengisian),
                'jenis_periode' => set_value('jenis_periode', $row->jenis_periode),
                'tipe_periodik' => set_value('tipe_periodik', $row->tipe_periodik),
                'angka_periodik' => set_value('angka_periodik', $row->angka_periodik),
                'title' => 'Ubah Periode',
            );
            $this->load->view('template/header');
            $this->load->view('ekin/periode_form', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('ekin/periode'));
        }
    }

    public function periode_ubah_aksi()
    {
        $this->_periode_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->periode_ubah($this->input->post('id', TRUE));
        } else {
            $data = array(
                'nama' => $this->input->post('nama', TRUE),
                'tahun' => $this->input->post('tahun', TRUE),
                'periode_awal' => $this->input->post('periode_awal', TRUE),
                'periode_akhir' => $this->input->post('periode_akhir', TRUE),
                'batas_pengisian' => $this->input->post('batas_pengisian', TRUE),
                'jenis_periode' => $this->input->post('jenis_periode', TRUE),
                'tipe_periodik' => $this->input->post('tipe_periodik', TRUE),
                'angka_periodik' => $this->input->post('angka_periodik', TRUE),
            );

            $this->Ekin_model->update_periode($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Periode berhasil diperbarui');
            redirect(site_url('ekin/periode'));
        }
    }

    public function periode_hapus($id)
    {
        $row = $this->Ekin_model->get_periode_by_id($id);

        if ($row) {
            $this->Ekin_model->delete_periode($id);
            $this->session->set_flashdata('message', 'Periode berhasil dihapus');
            redirect(site_url('ekin/periode'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('ekin/periode'));
        }
    }

    public function _periode_rules()
    {
        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
        $this->form_validation->set_rules('tahun', 'tahun', 'trim|required|numeric');
        $this->form_validation->set_rules('periode_awal', 'periode awal', 'trim|required');
        $this->form_validation->set_rules('periode_akhir', 'periode akhir', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function sinkron_periode_api()
    {
        $config = $this->_get_api_config();
        if (!$config) {
            $this->session->set_flashdata('message', 'Gagal: Konfigurasi API e-Kinerja tidak ditemukan atau tidak aktif.');
            redirect(site_url('ekin/periode'));
        }

        $url = rtrim($config->address_kinerja, '/') . "/api_kinerja/referensi/periode";
        $json_response = $this->_fetch_from_api($url, $config->token);

        if ($json_response === false) {
            $this->session->set_flashdata('message', 'Gagal mengambil data dari API e-Kinerja.');
            redirect(site_url('ekin/periode'));
        }

        $data = json_decode($json_response, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['data']) || !is_array($data['data'])) {
            $this->session->set_flashdata('message', 'Gagal: Format JSON dari API tidak valid.');
            redirect(site_url('ekin/periode'));
        }

        $periode_api = $data['data'];
        $processed_count = 0;

        if (empty($periode_api)) {
            $this->session->set_flashdata('message', 'Tidak ada data periode baru dari API.');
            redirect(site_url('ekin/periode'));
        }

        $this->db->trans_start();
        foreach ($periode_api as $item) {
            $db_data = [
                'id'              => $item['id'] ?? null,
                'nama'            => $item['nama'] ?? null,
                'tahun'           => empty($item['tahun']) ? date('Y') : $item['tahun'],
                'periode_awal'    => $item['periode_awal'] ?? null,
                'periode_akhir'   => $item['periode_akhir'] ?? null,
                'batas_pengisian' => $item['batas_pengisian'] ?? null,
                'jenis_periode'   => $item['jenis_periode'] ?? null,
                'tipe_periodik'   => $item['tipe_periodik'] ?? null,
                'angka_periodik'  => $item['angka_periodik'] ?? null,
            ];
            // Gunakan replace untuk insert atau update jika ID sudah ada
            $this->db->replace('ekin_ref_periode', $db_data);
            $processed_count++;
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('message', 'Gagal menyimpan data periode ke database.');
        } else {
            $this->session->set_flashdata('message', $processed_count . ' data periode berhasil disinkronkan.');
        }

        redirect(site_url('ekin/periode'));
    }

    // =========================================================================
    // SINKRONISASI MANUAL
    // =========================================================================

    public function sinkronisasi_penilaian_form()
    {
        $data['periode_data'] = $this->Ekin_model->get_all_periode();
        $this->load->view('template/header');
        $this->load->view('ekin/sinkron_form', $data);
        $this->load->view('template/footer');
    }

    public function run_sinkron_penilaian()
    {
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('periode_id', 'Periode', 'required');
        $this->form_validation->set_rules('nip', 'NIP', 'trim|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->sinkronisasi_penilaian_form();
            return;
        }

        $tahun = $this->input->post('tahun', TRUE);
        $periode_id = $this->input->post('periode_id', TRUE);
        $nip = $this->input->post('nip', TRUE);

        $config = $this->_get_api_config();
        if (!$config) {
            $this->session->set_flashdata('message', 'Gagal: Konfigurasi API e-Kinerja tidak ditemukan atau tidak aktif.');
            redirect(site_url('ekin/sinkronisasi_penilaian_form'));
        }

        $base_url = rtrim($config->address_kinerja, '/') . "/api_kinerja/laporan/penilaian/{$tahun}/{$periode_id}";
        $final_url = !empty($nip) ? $base_url . '?nip=' . $nip : $base_url;

        $json_response = $this->_fetch_from_api($final_url, $config->token);

        if ($json_response === false) {
            $this->session->set_flashdata('message', 'Gagal mengambil data dari API e-Kinerja. Periksa kembali parameter Anda.');
            redirect(site_url('ekin/sinkronisasi_penilaian_form'));
        }

        // Panggil metode _save_penilaian yang sudah ada
        $save_result = $this->_save_penilaian($json_response);
        
        // Redirect kembali ke form dengan pesan dari _save_penilaian
        $this->session->set_flashdata('message', $save_result['message']);
        $this->session->set_flashdata('message_type', $save_result['success'] ? 'success' : 'danger');
        redirect(site_url('ekin/sinkronisasi_penilaian_form'));
    }

    // =========================================================================
    // LAPORAN PENILAIAN
    // =========================================================================

    public function penilaian_pegawai_list()
    {
        $data['pegawai_data'] = $this->Ekin_model->get_pegawai_with_penilaian();
        $this->load->view('template/header');
        $this->load->view('ekin/penilaian_pegawai_list', $data);
        $this->load->view('template/footer');
    }

    public function lihat_penilaian($nip = null)
    {
        if (empty($nip)) {
            redirect(site_url('ekin/penilaian_pegawai_list'));
        }

        $penilaian_data = $this->Ekin_model->get_penilaian_by_nip($nip);

        if (empty($penilaian_data)) {
            $this->session->set_flashdata('message', 'Data penilaian untuk NIP ' . $nip . ' tidak ditemukan.');
            redirect(site_url('ekin/penilaian_pegawai_list'));
        }

        $data['penilaian_data'] = $penilaian_data;
        $data['pegawai_nama'] = $penilaian_data[0]->nama . ' (' . $nip . ')';

        $this->load->view('template/header');
        $this->load->view('ekin/penilaian_detail', $data);
        $this->load->view('template/footer');
    }

    public function laporan_per_unit()
    {
        // Ambil data untuk filter
        $data['units'] = $this->Ekin_model->get_all_units();
        $data['periodes'] = $this->Ekin_model->get_all_periode(); // Tetap ambil semua periode jika diperlukan di masa depan

        // Ambil nilai filter dari URL (GET) atau set default
        $selected_unit = $this->input->get('unit_id', TRUE);
        
        // Default to last month if no parameters are set
        $default_date = strtotime('-1 month');
        $default_tahun = date('Y', $default_date);
        $default_bulan = date('n', $default_date);

        $selected_tahun = $this->input->get('tahun', TRUE) ?? $default_tahun;
        $selected_bulan = $this->input->get('bulan', TRUE) ?? $default_bulan;

        $data['selected_unit'] = $selected_unit;
        $data['selected_tahun'] = $selected_tahun;
        $data['selected_bulan'] = $selected_bulan;
        $data['laporan_data'] = []; // Inisialisasi data laporan
        $data['last_update'] = null;
        $data['selected_periode_id'] = null;

        // Jika filter unit, tahun, dan bulan sudah diisi, ambil data laporannya
        if (!empty($selected_unit) && !empty($selected_tahun) && !empty($selected_bulan)) {
            // Cari periode_id berdasarkan tahun dan bulan
            $periode_obj = $this->Ekin_model->get_periode_by_year_and_month($selected_tahun, $selected_bulan);

            if ($periode_obj) {
                $found_periode_id = $periode_obj->id;
                $data['selected_periode_id'] = $found_periode_id;
                $data['laporan_data'] = $this->Ekin_model->get_penilaian_by_unit_and_periode($selected_unit, $found_periode_id);
                $data['last_update'] = $this->Ekin_model->get_last_update_time($selected_unit, $found_periode_id);
            } else {
                $this->session->set_flashdata('message', 'Periode tidak ditemukan untuk tahun dan bulan yang dipilih.');
            }
        }

        $this->load->view('template/header');
        $this->load->view('ekin/laporan_unit_form', $data);
        $this->load->view('template/footer');
    }

    public function get_periode_id($tahun = null, $bulan = null)
    {
        if (empty($tahun) || empty($bulan)) {
            return $this->_send_json_response(400, ['success' => false, 'message' => 'Parameter tahun dan bulan harus diisi.']);
        }

        $periode = $this->Ekin_model->get_periode_by_year_and_month($tahun, $bulan);

        if ($periode) {
            return $this->_send_json_response(200, ['success' => true, 'periode_id' => $periode->id, 'nama_periode' => $periode->nama]);
        } else {
            return $this->_send_json_response(404, ['success' => false, 'message' => 'Periode tidak ditemukan untuk tahun dan bulan tersebut.']);
        }
    }

    public function sinkron_per_pegawai()
    {
        $nip = $this->input->get('nip', TRUE);
        $periode_id = $this->input->get('periode_id', TRUE);
        
        // Params for redirecting back
        $unit_id = $this->input->get('unit_id', TRUE);
        $tahun = $this->input->get('tahun', TRUE);
        $bulan = $this->input->get('bulan', TRUE);
        $redirect_url = site_url('ekin/laporan_per_unit?unit_id=' . $unit_id . '&tahun=' . $tahun . '&bulan=' . $bulan);

        // Set header untuk streaming output
        header('Content-Type: text/html; charset=utf-8');
        echo "<!DOCTYPE html>\n<html>\n<head>\n<title>Sinkronisasi Penilaian Pegawai</title>\n<meta http-equiv=\"refresh\" content=\"5;url=" . $redirect_url . "\">\n<style>body { font-family: monospace; background-color: #222; color: #eee; padding: 20px; }</style>\n</head>\n<body>\n";
        echo "<pre style=\"background-color: #333; color: #0f0; padding: 10px;\">\n";
        
        ob_implicit_flush(true);
        ob_end_flush();

        if (empty($nip) || empty($periode_id)) {
            echo "Gagal: Parameter NIP dan Periode ID harus lengkap.\n";
            echo "</pre>\n</body>\n</html>";
            return;
        }

        echo "Memulai sinkronisasi untuk NIP: {$nip}, Periode ID: {$periode_id}...\n\n";

        $periode_obj = $this->Ekin_model->get_periode_by_id($periode_id);
        if (!$periode_obj) {
            echo "Gagal: Periode tidak ditemukan untuk sinkronisasi.\n";
            echo "</pre>\n</body>\n</html>";
            return;
        }
        $tahun_periode = $periode_obj->tahun;
        echo "Periode ditemukan: {$periode_obj->nama} ({$periode_id})\n";

        $config = $this->_get_api_config();
        if (!$config) {
            echo "Gagal: Konfigurasi API e-Kinerja tidak ditemukan atau tidak aktif.\n";
            echo "</pre>\n</body>\n</html>";
            return;
        }
        echo "Konfigurasi API ditemukan.\n";

        $base_url = rtrim($config->address_kinerja, '/') . "/api_kinerja/laporan/penilaian/{$tahun_periode}/{$periode_id}";
        $final_url = $base_url . '?nip=' . $nip;
        // echo "URL API: {$final_url}\n";
        echo "Mengambil data dari API...\n";
        $json_response = $this->_fetch_from_api($final_url, $config->token);

        if ($json_response === false) {
            echo "Gagal mengambil data dari API e-Kinerja untuk NIP {$nip}.\n";
            echo "</pre>\n</body>\n</html>";
            return;
        }
        echo "Berhasil mengambil data dari API.\n";

        echo "Menyimpan data ke database...\n";
        $save_result = $this->_save_penilaian($json_response);

        if ($save_result['success']) {
            echo "Berhasil sinkronisasi data untuk NIP {$nip}.\n";
            echo "Jumlah data yang diproses: " . $save_result['processed_count'] . "\n";
            
            $status_icon = '✅';
            $telegram_message = "{$status_icon} <b>Sinkronisasi per Pegawai Berhasil</b> {$status_icon}\n\n";
            $telegram_message .= "NIP: <b>{$nip}</b>\n";
            $telegram_message .= "Periode: <b>{$periode_obj->nama}</b>\n";
            $telegram_message .= "Data diproses: <b>{$save_result['processed_count']}</b>\n";
        } else {
            echo "Gagal menyimpan data untuk NIP {$nip}: " . $save_result['message'] . "\n";

            $status_icon = '❌';
            $telegram_message = "{$status_icon} <b>Sinkronisasi per Pegawai Gagal</b> {$status_icon}\n\n";
            $telegram_message .= "NIP: <b>{$nip}</b>\n";
            $telegram_message .= "Periode: <b>{$periode_obj->nama}</b>\n";
            $telegram_message .= "Pesan: {$save_result['message']}\n";
        }
        $this->_send_telegram_message($telegram_message);

        echo "\nSinkronisasi selesai. Anda akan dialihkan kembali dalam 5 detik...\n";
        echo "</pre>\n</body>\n</html>";
    }

    public function sinkron_penilaian_unit_aksi()
    {
        $start_time = microtime(true);
        $unit_id = $this->input->get('unit_id', TRUE);
        $tahun = $this->input->get('tahun', TRUE);
        $bulan = $this->input->get('bulan', TRUE);

        // Set header untuk streaming output
        header('Content-Type: text/html; charset=utf-8');
        echo "<!DOCTYPE html>\n<html>\n<head>\n<title>Sinkronisasi Penilaian Unit</title>\n<meta http-equiv=\"refresh\" content=\"5;url=".site_url('ekin/laporan_per_unit?unit_id=' . $unit_id . '&tahun=' . $tahun . '&bulan=' . $bulan)."\">\n<style>body { font-family: monospace; background-color: #222; color: #eee; padding: 20px; }</style>\n</head>\n<body>\n";
        echo "<pre style=\"background-color: #333; color: #0f0; padding: 10px;\">\n";
        echo "Memulai sinkronisasi penilaian untuk Unit: {$unit_id}, Tahun: {$tahun}, Bulan: {$bulan}...\n\n";
        ob_implicit_flush(true);
        ob_end_flush();

        if (empty($unit_id) || empty($tahun) || empty($bulan)) {
            echo "Gagal: Unit, Tahun, dan Bulan harus dipilih.\n";
            echo "</pre>\n</body>\n</html>";
            return;
        }

        $config = $this->_get_api_config();
        if (!$config) {
            echo "Gagal: Konfigurasi API e-Kinerja tidak ditemukan atau tidak aktif.\n";
            echo "</pre>\n</body>\n</html>";
            return;
        }

        $periode_obj = $this->Ekin_model->get_periode_by_year_and_month($tahun, $bulan);
        if (!$periode_obj) {
            echo "Gagal: Periode tidak ditemukan untuk tahun dan bulan yang dipilih.\n";
            echo "</pre>\n</body>\n</html>";
            return;
        }
        $periode_id = $periode_obj->id;

        // Ambil nama unit
        $unit_data = $this->Unit_model->get_by_id($unit_id);
        $unit_name = $unit_data ? $unit_data->unit_nama : 'Unit Tidak Dikenal';

        $nips_in_unit = $this->Ekin_model->get_nips_by_unit($unit_id);
        if (empty($nips_in_unit)) {
            echo "Tidak ada pegawai ditemukan di unit ini.\n";
            echo "</pre>\n</body>\n</html>";
            // Kirim notifikasi Telegram jika tidak ada pegawai
            $telegram_message = "⚠️ <b>Sinkronisasi Penilaian Unit Gagal</b> ⚠️\n\n";
            $telegram_message .= "Unit: <b>{$unit_name} ({$unit_id})</b>\n";
            $telegram_message .= "Tahun: <b>{$tahun}</b>\n";
            $telegram_message .= "Bulan: <b>{$bulan}</b>\n\n";
            $telegram_message .= "Pesan: Tidak ada pegawai ditemukan di unit ini.\n";
            $this->_send_telegram_message($telegram_message);
            return;
        }

        $total_nips = count($nips_in_unit);
        $processed_nips_count = 0;
        $successful_saves = 0;
        $failed_nips = [];

        foreach ($nips_in_unit as $nip_row) {
            $nip = $nip_row['jabatan_nip'];
            $processed_nips_count++;
            echo "[{$processed_nips_count}/{$total_nips}] Memproses NIP: {$nip} ... ";

            $base_url = rtrim($config->address_kinerja, '/') . "/api_kinerja/laporan/penilaian/{$tahun}/{$periode_id}";
            $final_url = $base_url . '?nip=' . $nip;

            $json_response = $this->_fetch_from_api($final_url, $config->token);

            if ($json_response === false) {
                $failed_nips[] = $nip;
                echo "Gagal mengambil data dari API.\n";
                continue;
            }

            $save_result = $this->_save_penilaian($json_response);
            if ($save_result['success']) {
                $successful_saves += $save_result['processed_count'];
                echo "Berhasil (Disimpan: {$save_result['processed_count']}).\n";
            } else {
                $failed_nips[] = $nip;
                echo "Gagal menyimpan data: {$save_result['message']}.\n";
            }
        }

        $status_icon = empty($failed_nips) ? '✅' : '❌';
        $telegram_message = "{$status_icon} <b>Rekap Sinkronisasi Penilaian Unit</b> {$status_icon}\n\n";
        $telegram_message .= "Unit: <b>{$unit_name} ({$unit_id})</b>\n";
        $telegram_message .= "Tahun: <b>{$tahun}</b>\n";
        $telegram_message .= "Bulan: <b>{$bulan}</b>\n\n";
        $telegram_message .= "Total NIP diproses: {$total_nips}\n";
        $telegram_message .= "Total data penilaian disimpan/diperbarui: {$successful_saves}\n";
        if (!empty($failed_nips)) {
            $telegram_message .= "NIP yang gagal diproses: " . implode(', ', $failed_nips) . "\n";
        } else {
        $end_time = microtime(true);
        $execution_time = round($end_time - $start_time, 2);
        $telegram_message .= "\n\nWaktu eksekusi: <b>{$execution_time} detik</b>";

        $this->_send_telegram_message($telegram_message);
    }
    }







    /**
     * Menampilkan data JSON mentah dari API Periode untuk debugging.
     */
    // public function debug_periode_api()
    // {
    //     $config = $this->_get_api_config();
    //     if (!$config) {
    //         echo "Gagal: Konfigurasi API e-Kinerja tidak ditemukan atau tidak aktif.";
    //         return;
    //     }

    //     $url = rtrim($config->address_kinerja, '/') . "/api_kinerja/referensi/periode";
    //     $json_response = $this->_fetch_from_api($url, $config->token);

    //     if ($json_response === false) {
    //         echo "Gagal mengambil data dari API e-Kinerja. Pastikan token dan alamat API valid.";
    //         return;
    //     }

    //     // Decode dan re-encode untuk pretty print
    //     $data = json_decode($json_response);
        
    //     header('Content-Type: application/json');
    //     echo json_encode($data, JSON_PRETTY_PRINT);
    // }




    public function konfigurasi()
    {
        $data['konfigurasi'] = $this->Ekin_model->get_all();
        $this->load->view('template/header');
        $this->load->view('ekin/konfigurasi_list', $data);
        $this->load->view('template/footer');
    }

    public function konfigurasi_tambah()
    {
        $data = array(
            'button' => 'Tambah',
            'action' => site_url('ekin/konfigurasi_tambah_aksi'),
            'config_id' => set_value('config_id'),
            'environment_name' => set_value('environment_name'),
            'address_kinerja' => set_value('address_kinerja'),
            'token' => set_value('token'),
            'is_active' => set_value('is_active', 0),
            'title' => 'Tambah Konfigurasi API',
        );
        $this->load->view('template/header');
        $this->load->view('ekin/konfigurasi_form', $data);
        $this->load->view('template/footer');
    }

    public function konfigurasi_tambah_aksi()
    {
        $this->_konfigurasi_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->konfigurasi_tambah();
        } else {
            $data = array(
                'environment_name' => $this->input->post('environment_name', TRUE),
                'address_kinerja' => $this->input->post('address_kinerja', TRUE),
                'token' => $this->input->post('token', TRUE),
                'is_active' => $this->input->post('is_active', TRUE),
            );

            $this->Ekin_model->insert($data);
            $this->session->set_flashdata('message', 'Konfigurasi berhasil ditambahkan');
            redirect(site_url('ekin/konfigurasi'));
        }
    }

    public function konfigurasi_copy($id)
    {
        $row = $this->Ekin_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Tambah dari Salinan',
                'action' => site_url('ekin/konfigurasi_tambah_aksi'), // Arahkan ke aksi tambah
                'config_id' => set_value('config_id'), // ID dikosongkan untuk membuat data baru
                'environment_name' => set_value('environment_name', $row->environment_name . ' - Copy'),
                'address_kinerja' => set_value('address_kinerja', $row->address_kinerja),
                'token' => set_value('token', $row->token),
                'is_active' => set_value('is_active', 0), // Set default ke tidak aktif
                'title' => 'Salin Konfigurasi API',
            );
            $this->load->view('template/header');
            $this->load->view('ekin/konfigurasi_form', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('ekin/konfigurasi'));
        }
    }


    public function konfigurasi_ubah($id)
    {
        $row = $this->Ekin_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Ubah',
                'action' => site_url('ekin/konfigurasi_ubah_aksi'),
                'config_id' => set_value('config_id', $row->config_id),
                'environment_name' => set_value('environment_name', $row->environment_name),
                'address_kinerja' => set_value('address_kinerja', $row->address_kinerja),
                'token' => set_value('token', $row->token),
                'is_active' => set_value('is_active', $row->is_active),
                'title' => 'Ubah Konfigurasi API',
            );
            $this->load->view('template/header');
            $this->load->view('ekin/konfigurasi_form', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('ekin/konfigurasi'));
        }
    }

    public function konfigurasi_ubah_aksi()
    {
        $this->_konfigurasi_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->konfigurasi_ubah($this->input->post('config_id', TRUE));
        } else {
            $data = array(
                'environment_name' => $this->input->post('environment_name', TRUE),
                'address_kinerja' => $this->input->post('address_kinerja', TRUE),
                'token' => $this->input->post('token', TRUE),
                'is_active' => $this->input->post('is_active', TRUE),
            );

            $this->Ekin_model->update($this->input->post('config_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Konfigurasi berhasil diperbarui');
            redirect(site_url('ekin/konfigurasi'));
        }
    }

    public function konfigurasi_hapus($id)
    {
        $row = $this->Ekin_model->get_by_id($id);

        if ($row) {
            $this->Ekin_model->delete($id);
            $this->session->set_flashdata('message', 'Konfigurasi berhasil dihapus');
            redirect(site_url('ekin/konfigurasi'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('ekin/konfigurasi'));
        }
    }
    
    public function konfigurasi_set_aktif($id)
    {
        $this->Ekin_model->set_active($id);
        $this->session->set_flashdata('message', 'Konfigurasi berhasil diaktifkan');
        redirect(site_url('ekin/konfigurasi'));
    }

    public function _konfigurasi_rules()
    {
        $this->form_validation->set_rules('environment_name', 'nama environment', 'trim|required');
        $this->form_validation->set_rules('address_kinerja', 'alamat api', 'trim|required');
        $this->form_validation->set_rules('token', 'token', 'trim|required');
        $this->form_validation->set_rules('config_id', 'config_id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }



    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ekin_model');
        $this->load->model('Unit_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    /**
     * Mengambil konfigurasi API terbaru yang aktif dari database.
     * @return object|null
     */
    private function _get_api_config()
    {
        $query = $this->db->from('ekin_konfigurasi_api')
                          ->where('is_active', 1)
                          ->order_by('updated_at', 'DESC')
                          ->limit(1)
                          ->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Orchestrator untuk mengambil data Penilaian dari API dan menyimpannya.
     * URL: /ekin/fetch_and_save_penilaian/[tahun]/[periode_id]
     */
    public function fetch_and_save_penilaian($tahun = null, $periode_id = null)
    {
        if (empty($tahun) || empty($periode_id)) {
            return $this->_send_json_response(400, ['success' => false, 'message' => 'Tahun dan Periode ID harus diisi.']);
        }

        $config = $this->_get_api_config();
        if (!$config) {
            return $this->_send_json_response(500, ['success' => false, 'message' => 'Konfigurasi API e-Kinerja tidak ditemukan atau tidak aktif.']);
        }

        // address_kinerja mungkin berisi path, jadi kita pastikan base URL-nya saja
        $base_address = $config->address_kinerja;
        $url = rtrim($base_address, '/') . "/api_kinerja/laporan/penilaian/{$tahun}/{$periode_id}";

        $json_response = $this->_fetch_from_api($url, $config->token);

        if ($json_response === false) {
            return $this->_send_json_response(500, ['success' => false, 'message' => 'Gagal mengambil data dari API e-Kinerja.']);
        }

        $this->_save_penilaian($json_response);
    }

    /**
     * Orchestrator untuk mengambil data SKP dari API dan menyimpannya.
     * URL: /ekin/fetch_and_save_skp/[tahun]
     */
    public function fetch_and_save_skp($tahun = null)
    {
        if (empty($tahun)) {
            return $this->_send_json_response(400, ['success' => false, 'message' => 'Tahun harus diisi.']);
        }

        $config = $this->_get_api_config();
        if (!$config) {
            return $this->_send_json_response(500, ['success' => false, 'message' => 'Konfigurasi API e-Kinerja tidak ditemukan atau tidak aktif.']);
        }

        $base_address = $config->address_kinerja;
        $url = rtrim($base_address, '/') . "/api_kinerja/laporan/skp/{$tahun}";

        $json_response = $this->_fetch_from_api($url, $config->token);

        if ($json_response === false) {
            return $this->_send_json_response(500, ['success' => false, 'message' => 'Gagal mengambil data dari API e-Kinerja.']);
        }

        $this->_save_skp($json_response);
    }

    /**
     * Fungsi untuk mengambil data dari URL menggunakan cURL.
     * @param string $url
     * @param string $token
     * @return string|false
     */
    private function _fetch_from_api($url, $token)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer ' . $token
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code != 200) {
            // Bisa ditambahkan logging di sini untuk mencatat error dari API
            return false;
        }

        return $response;
    }

    /**
     * Endpoint untuk menerima (PUSH) data JSON Laporan Penilaian.
     */
    public function sinkron_penilaian()
    {
        $json_data = $this->input->raw_input_stream;
        $this->_save_penilaian($json_data);
    }

    /**
     * Endpoint untuk menerima (PUSH) data JSON Laporan SKP.
     */
    public function sinkron_skp()
    {
        $json_data = $this->input->raw_input_stream;
        $this->_save_skp($json_data);
    }

    /**
     * Logika untuk memproses dan menyimpan data Laporan Penilaian.
     * @param string $json_data
     */
    private function _save_penilaian($json_data)
    {
        if (empty($json_data)) {
            return ['success' => false, 'message' => 'Data JSON tidak boleh kosong.', 'processed_count' => 0];
        }

        $data = json_decode($json_data, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['data'])) {
            return ['success' => false, 'message' => 'Format JSON tidak valid atau key "data" tidak ditemukan.', 'processed_count' => 0];
        }

        if (!is_array($data['data'])) {
             return ['success' => true, 'message' => 'Tidak ada data untuk disinkronkan (data bukan array).', 'processed_count' => 0];
        }

        $laporan_penilaian = $data['data'];
        $processed_count = 0;

        if (empty($laporan_penilaian)) {
            return ['success' => true, 'message' => 'Tidak ada data untuk disinkronkan.', 'processed_count' => 0];
        }

        $this->db->trans_start();
        foreach ($laporan_penilaian as $item) {
            $db_data = [
                'skp_penilaian_id'      => $item['skp_penilaian_id'] ?? null,
                'jenis'                 => $item['jenis'] ?? null,
                'id'                    => $item['id'] ?? null,
                'nip'                   => $item['nip'] ?? null,
                'nama'                  => $item['nama'] ?? null,
                'periode_awal_skp'      => $item['periode_awal_skp'] ?? null,
                'periode_akhir_skp'     => $item['periode_akhir_skp'] ?? null,
                'tahun_skp'             => $item['tahun_skp'] ?? null,
                'periode_id'            => $item['periode_id'] ?? null,
                'jenis_pegawai'         => $item['jenis_pegawai'] ?? null,
                'golru'                 => $item['golru'] ?? null,
                'skp_id'                => $item['skp_id'] ?? null,
                'skp_jabatan'           => $item['skp_jabatan'] ?? null,
                'skp_unor'              => $item['skp_unor'] ?? null,
                'skp_unor_id'           => $item['skp_unor_id'] ?? null,
                'skp_unor_induk'        => $item['skp_unor_induk'] ?? null,
                'skp_jenis_jabatan'     => $item['skp_jenis_jabatan'] ?? null,
                'is_skp_plt_plh_pjb'    => $item['is_skp_plt_plh_pjb'] ?? null,
                'hasil_kerja'           => $item['hasil_kerja'] ?? null,
                'perilaku_kerja'        => $item['perilaku_kerja'] ?? null,
                'hasil_akhir'           => $item['hasil_akhir'] ?? null,
                'pegawai_atasan_id'     => $item['pegawai_atasan_id'] ?? null,
                'pegawai_atasan_nip'    => $item['pegawai_atasan_nip'] ?? null,
                'pegawai_atasan_nama'   => $item['pegawai_atasan_nama'] ?? null,
                'pegawai_atasan_jabatan'=> $item['pegawai_atasan_jabatan'] ?? null,
                'pegawai_atasan_unor_id'=> $item['pegawai_atasan_unor_id'] ?? null,
                'pegawai_atasan_unor'   => $item['pegawai_atasan_unor'] ?? null,
                'pegawai_atasan_golru'  => $item['pegawai_atasan_golru'] ?? null,
                'waktu_dinilai'         => $item['waktu_dinilai'] ?? null,
                'pegawai_penilai_id'    => $item['pegawai_penilai_id'] ?? null,
                'created_at'            => $item['created_at'] ?? null,
            ];
            $this->db->replace('ekin_laporan_penilaian', $db_data);
            $processed_count++;
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['success' => false, 'message' => 'Gagal menyimpan data ke database.', 'processed_count' => 0];
        } else {
            return ['success' => true, 'message' => 'Sinkronisasi data penilaian berhasil.', 'processed_count' => $processed_count];
        }
    }

    /**
     * Logika untuk memproses dan menyimpan data Laporan SKP.
     * @param string $json_data
     */
    private function _save_skp($json_data)
    {
        if (empty($json_data)) {
            return $this->_send_json_response(400, ['success' => false, 'message' => 'Data JSON tidak boleh kosong.']);
        }

        $data = json_decode($json_data, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['data'])) {
            return $this->_send_json_response(400, ['success' => false, 'message' => 'Format JSON tidak valid atau key "data" tidak ditemukan.', 'raw_response' => $json_data]);
        }

        if (!is_array($data['data'])) {
             return $this->_send_json_response(200, ['success' => true, 'message' => 'Tidak ada data untuk disinkronkan (data bukan array).', 'processed_count' => 0]);
        }

        $laporan_skp = $data['data'];
        $processed_count = 0;

        if (empty($laporan_skp)) {
            return $this->_send_json_response(200, ['success' => true, 'message' => 'Tidak ada data untuk disinkronkan.', 'processed_count' => 0]);
        }

        $this->db->trans_start();
        foreach ($laporan_skp as $item) {
            $db_data = [
                'skp_id'            => $item['skp_id'] ?? null,
                'id'                => $item['id'] ?? null,
                'jenis'             => $item['jenis'] ?? null,
                'nip'               => $item['nip'] ?? null,
                'nama'              => $item['nama'] ?? null,
                'jabatan'           => $item['jabatan'] ?? null,
                'is_skp'            => $item['is_skp'] ?? null,
                'unit'              => $item['unit'] ?? null,
                'jenis_pegawai'     => $item['jenis_pegawai'] ?? null,
                'skp_status'        => $item['skp_status'] ?? null,
                'skp_model'         => $item['skp_model'] ?? null,
                'skp_unor'          => $item['skp_unor'] ?? null,
                'skp_unor_atasan'   => $item['skp_unor_atasan'] ?? null,
                'skp_unor_induk'    => $item['skp_unor_induk'] ?? null,
                'skp_jabatan'       => $item['skp_jabatan'] ?? null,
                'skp_jenis_jabatan' => $item['skp_jenis_jabatan'] ?? null,
                'periode_awal'      => $item['periode_awal'] ?? null,
                'periode_akhir'     => $item['periode_akhir'] ?? null,
                'is_plt_plh'        => $item['is_plt_plh'] ?? null,
                'created_at'        => $item['created_at'] ?? null,
            ];
            $this->db->replace('ekin_laporan_skp', $db_data);
            $processed_count++;
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return $this->_send_json_response(500, ['success' => false, 'message' => 'Gagal menyimpan data ke database.']);
        } else {
            return $this->_send_json_response(200, ['success' => true, 'message' => 'Sinkronisasi data SKP berhasil.', 'processed_count' => $processed_count]);
        }
    }

    /**
     * Helper untuk mengirim response JSON standar.
     * @param int $status_code
     * @param array $data
     */
    private function _send_json_response($status_code, $data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status_code)
            ->set_output(json_encode($data));
    }

    /**
     * Mengambil konfigurasi Telegram dari .env.
     * @return object|null
     */
    private function _get_telegram_config()
    {
        $token = $_ENV['TELEGRAM_BOT_TOKEN'] ?? null;
        $chat_id = $_ENV['TELEGRAM_CHAT_ID'] ?? null;

        if ($token && $chat_id) {
            return (object) ['token' => $token, 'chat_id' => $chat_id];
        }
        return null;
    }

    /**
     * Mengirim pesan ke Telegram.
     * @param string $message
     * @return bool
     */
    private function _send_telegram_message($message)
    {
        $telegram_config = $this->_get_telegram_config();

        if (!$telegram_config) {
            log_message('error', 'Telegram config not found. Cannot send message.');
            return false;
        }

        $url = "https://api.telegram.org/bot{$telegram_config->token}/sendMessage";
        $data = [
            'chat_id' => $telegram_config->chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code != 200) {
            log_message('error', 'Failed to send Telegram message. HTTP Code: ' . $http_code . ' Response: ' . $response);
            return false;
        }

        return true;
    }
}
