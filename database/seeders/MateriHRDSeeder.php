<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\Tahapan;
use App\Models\Task;
use App\Models\Inisiatif;

class MateriHRDSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Materi
        $materi = Materi::create([
            'judul' => 'A. Membangun Bidang HRD (Human Resource Development)',
            'deskripsi' => 'Pengembangan SDM sebagai aset bisnis jangka panjang.'
        ]);

        // ===============================
        // Tahap 1
        // ===============================
        $tahap1 = Tahapan::create([
            'materi_id' => $materi->id,
            'judul' => 'Mindset dan Filosofi Pengelolaan SDM',
            'deskripsi' => 'Mengubah cara pandang agar SDM dilibatkan secara strategis.'
        ]);

        $task1 = Task::create([
            'materi_id' => $materi->id,
            'tahapan_id' => $tahap1->id,
            'judul' => 'Menyadari Bahwa Karyawan adalah Aset Bisnis, Bukan Beban',
            'tujuan' => 'Mengubah mindset manajemen dan pemilik bahwa SDM adalah investasi.'
        ]);

        $inisiatifList = [
            ['Adakan workshop internal tentang people as assets', 'Workshop Material & Attendance List'],
            ['Buat data kontribusi karyawan pada revenue', 'Employee Contribution Report'],
            ['Publikasikan kisah sukses karyawan berprestasi', 'Employee Success Story Sheet'],
            ['Buat program penghargaan bulanan/tahunan', 'Employee Award Policy'],
            ['Tetapkan indikator ROI SDM', 'HR ROI Calculation Template'],
            ['Bandingkan biaya turnover dengan biaya pengembangan', 'Turnover Cost Analysis'],
            ['Adakan sesi sharing dengan karyawan senior', 'Sharing Session Notes'],
            ['Dokumentasikan kontribusi karyawan di proyek penting', 'Project Contribution Log'],
            ['Masukkan pencapaian SDM di laporan manajemen', 'HR Achievement Report'],
            ['Lakukan survei persepsi manajemen tentang SDM', 'HR Perception Survey Result'],
        ];

        foreach ($inisiatifList as $item) {
            Inisiatif::create([
                'task_id' => $task1->id,
                'judul' => $item[0],
                'dokumen' => $item[1],
            ]);
        }

        // ===============================
        // TODO: lanjutkan Tahap 2 - Tahap 5
        // ===============================

        // Tahap 2
        $tahap2 = Tahapan::create([
            'materi_id' => $materi->id,
            'judul' => 'Membangun Sistem Rekrutmen dan Seleksi',
            'deskripsi' => 'Membangun proses rekrutmen yang efektif dan efisien.'
        ]);

        $task2 = Task::create([
            'materi_id' => $materi->id,
            'tahapan_id' => $tahap2->id,
            'judul' => 'Menyusun Proses Rekrutmen yang Efektif',
            'tujuan' => 'Membangun proses rekrutmen yang menarik kandidat berkualitas.'
        ]);

        $inisiatifList2 = [
            ['Buat deskripsi pekerjaan yang jelas', 'Job Description Template'],
            ['Pasang iklan lowongan di platform populer', 'Job Posting List'],
            ['Gunakan media sosial untuk promosi lowongan', 'Social Media Job Ads'],
            ['Libatkan karyawan dalam referensi kandidat', 'Employee Referral Program'],
            ['Adakan sesi informasi perusahaan untuk pelamar', 'Company Info Session Plan'],
            ['Gunakan tes psikometri untuk seleksi awal', 'Psychometric Test Report'],
            ['Lakukan wawancara berbasis kompetensi', 'Competency-Based Interview Guide'],
            ['Buat proses orientasi yang menyenangkan', 'Employee Onboarding Plan'],
            ['Kumpulkan feedback dari pelamar tentang proses rekrutmen', 'Recruitment Feedback Form'],
            ['Evaluasi dan perbaiki proses rekrutmen secara berkala', 'Recruitment Process Improvement Log'],
        ];

        foreach ($inisiatifList2 as $item) {
            Inisiatif::create([
                'task_id' => $task2->id,
                'judul' => $item[0],
                'dokumen' => $item[1],
            ]);
        }

    }
}
