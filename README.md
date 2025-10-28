# ENIKDA-AI: Analisis Prediktif Kedisiplinan dan Kinerja ASN

Selamat datang di repositori ENIKDA-AI. Dokumen ini menjelaskan latar belakang, tujuan, dan rencana pengembangan aplikasi **ENIKDA (Elektronik Penilaian Kinerja dan Disiplin Aparatur)** dengan modul kecerdasan buatan (AI) untuk analisis prediktif kedisiplinan dan kinerja Aparatur Sipil Negara (ASN).

## Latar Belakang

Aplikasi ENIKDA adalah sistem berbasis web yang sudah berjalan untuk membantu penilaian kinerja dan disiplin aparatur di Kabupaten Sinjai. Namun, dalam implementasinya, ditemukan beberapa masalah utama:

1.  **Duplikasi Input Data Kinerja:** ASN harus melakukan input data kinerja di dua sistem yang berbeda (ENIKDA lokal dan e-Kinerja BKN pusat), yang menyebabkan inefisiensi dan potensi inkonsistensi data.
2.  **Inefisiensi Pengambilan Data Absensi:** Proses pengumpulan data absensi dari mesin rekam kehadiran seringkali masih manual, memakan waktu, dan rentan terhadap kendala teknis seperti kerusakan perangkat.

Untuk mengatasi masalah ini, kami mengusulkan **ENIKDA-AI**, sebuah inisiatif untuk mengintegrasikan, mengotomatisasi, dan menambahkan kemampuan analisis prediktif berbasis AI ke dalam sistem yang sudah ada.

## Solusi & Inovasi AI

ENIKDA-AI adalah modul cerdas yang akan diintegrasikan untuk meningkatkan efisiensi, akurasi, dan kedalaman analisis data kepegawaian. Solusi yang diusulkan mencakup:

-   **Integrasi API eKinerja BKN:** Menghilangkan input ganda dengan sinkronisasi data kinerja secara otomatis ke sistem nasional.
-   **Integrasi API SIMPEGNAS:** Menggantikan proses absensi manual dengan pengambilan data kehadiran otomatis melalui API dan *cron job* berkala.
-   **Perhitungan TPP Otomatis:** Menggunakan data yang terintegrasi untuk menghitung Tambahan Penghasilan Pegawai (TPP) secara lebih cepat dan akurat.
-   **Monitoring Real-Time:** Menyediakan notifikasi otomatis kepada pimpinan melalui Telegram Bot untuk pengawasan kedisiplinan ASN secara *real-time*.
-   **Analisis Kedisiplinan Berbasis AI:** Menganalisis pola kehadiran dan data kinerja historis untuk menghasilkan **prediksi tingkat disiplin** pegawai secara objektif, membantu pimpinan dalam pengambilan keputusan yang berbasis data.

## Rencana Pengembangan Modul AI

Pengembangan MVP (Minimum Viable Product) untuk Modul Analisis Kedisiplinan Berbasis AI akan difokuskan selama periode Hackathon (10-13 November 2025), dengan tahapan sebagai berikut:

| Periode | Tahapan Kegiatan | Deskripsi |
| --- | --- | --- |
| **Agustus 2025** | Analisis Sistem & Identifikasi Kebutuhan | Review arsitektur sistem eksisting, identifikasi titik integrasi, dan kebutuhan data untuk modul AI. |
| **September 2025** | Pengumpulan Data & Penyusunan Dataset | Mengumpulkan data absensi dan e-kinerja minimal 3-6 bulan terakhir, melakukan *data cleaning* dan *feature engineering*. |
| **Oktober 2025 (Minggu 1-2)** | Riset & Pengembangan Model AI | Evaluasi akurasi model, *tuning parameter*, dan menentukan metode klasifikasi atau skoring kedisiplinan ASN. |
| **Oktober 2025 (Minggu 3-4)** | Desain Modul & Persiapan Integrasi | Mendesain arsitektur backend dan tampilan *dashboard* untuk hasil analisis AI. |
| **Awal Nov 2025** | Persiapan Teknis Hackathon | Menyiapkan skrip *cron job*, *environment test*, dan dokumentasi teknis. |
| **10-13 Nov 2025** | **Fase Hackathon** | **Pengembangan MVP Modul Analisis Kedisiplinan Berbasis AI** dan implementasi *cron job* untuk sinkronisasi data. |

## Arsitektur & Teknologi

| Komponen | Teknologi | Deskripsi |
| --- | --- | --- |
| **Server** | Linux | Menjalankan layanan aplikasi dan *cron job*. |
| **Backend** | PHP (CodeIgniter), Python/Bash | Backend utama aplikasi, serta skrip untuk otomasi, sinkronisasi data, dan integrasi AI. |
| **Database** | MySQL | Penyimpanan utama data sinkronisasi dan hasil analisis. |
| **Frontend** | Bootstrap | Tampilan web yang responsif dan mudah diakses. |
| **Notifikasi** | Telegram Bot | Mengirim laporan dan notifikasi hasil analisis kepada pimpinan. |
| **Kontrol Versi** | Git (Github) / Dropbox | Kolaborasi kode sumber dan dokumentasi proyek. |

## Tim Pengembang

-   **Muhammad Rusyaid** (Project Lead & AI Developer)
-   **Abd. Dzuljalali Wal Ikram** (UI/UX Designer & Frontend Developer)
-   **Abdul Rahim** (Backend Developer & Data Engineer)
