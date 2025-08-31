<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\Tahapan;
use App\Models\Task;

class MateriJsonSeeder extends Seeder
{
    public function run(): void
    {
        // path JSON
        $jsonPath = database_path('seeders/data/materi_A_HRD.json');
        $materiData = json_decode(file_get_contents($jsonPath), true);

        // Insert Materi
        $materi = Materi::firstOrCreate(
            ['judul' => $materiData['judul']],
            ['deskripsi' => $materiData['deskripsi'] ?? null]
        );

        // Insert Tahapan + Task
        foreach ($materiData['tahapan'] as $t) {
            $tahapan = Tahapan::firstOrCreate(
                [
                    'materi_id' => $materi->id,
                    'judul' => $t['judul'],
                ],
                [
                    'deskripsi' => $t['deskripsi'] ?? null
                ]
            );

            foreach ($t['tasks'] as $task) {
                Task::firstOrCreate(
                    [
                        'materi_id' => $materi->id,
                        'tahapan_id' => $tahapan->id,
                        'judul' => $task['judul'],
                    ],
                    [
                        'tujuan' => $task['tujuan'] ?? null
                    ]
                );
            }
        }
    }
}
