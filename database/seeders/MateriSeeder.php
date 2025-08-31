<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\Tahapan;
use App\Models\Task;
use App\Models\Inisiatif;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        $dataPath = database_path('seeders/data');

        // ambil semua file JSON di folder
        $files = glob($dataPath . '/*.json');

        foreach ($files as $file) {
            $materiData = json_decode(file_get_contents($file), true);

            if (!$materiData) {
                $this->command->error("Gagal membaca file: $file");
                continue;
            }

            // 1. Buat Materi
            $materi = Materi::create([
                'judul' => $materiData['judul'],
                'deskripsi' => $materiData['deskripsi'] ?? 'Belum ada deskripsi',
            ]);

            // 2. Loop Tahapan
            foreach ($materiData['tahapan'] as $t) {
                $tahapan = Tahapan::create([
                    'materi_id' => $materi->id,
                    'judul' => $t['judul'],
                    'deskripsi' => $t['deskripsi'] ?? '',
                ]);

                // 3. Loop Task
                foreach ($t['tasks'] as $task) {
                    $taskModel = Task::create([
                        'materi_id' => $materi->id,
                        'tahapan_id' => $tahapan->id,
                        'judul' => $task['judul'],
                        'tujuan' => $task['tujuan'] ?? '',
                    ]);

                    // 4. Loop Inisiatif
                    foreach ($task['inisiatif'] as $inisiatif) {
                        Inisiatif::create([
                            'task_id' => $taskModel->id,
                            'judul' => $inisiatif['judul'],
                            'dokumen' => $inisiatif['dokumen'] ?? '',
                        ]);
                    }
                }
            }

            $this->command->info("Materi berhasil dimasukkan: " . $materiData['judul']);
        }
    }
}
