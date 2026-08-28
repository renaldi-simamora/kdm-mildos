<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            // Public Holidays Indonesia 2026 (upcoming from Aug onwards)
            [
                'title' => 'Hari Kemerdekaan RI',
                'description' => 'Peringatan Hari Kemerdekaan Republik Indonesia ke-81',
                'start_date' => '2026-08-17',
                'end_date' => '2026-08-17',
                'type' => 'holiday',
                'color' => '#e5484d',
            ],
            [
                'title' => 'Maulid Nabi Muhammad SAW',
                'description' => 'Hari besar Islam - Maulid Nabi Muhammad SAW 1448 H',
                'start_date' => '2026-09-04',
                'end_date' => '2026-09-04',
                'type' => 'holiday',
                'color' => '#19b95b',
            ],
            [
                'title' => 'Rapat HR Bulanan',
                'description' => 'Rapat rutin bulanan tim HR - Review KPI dan agenda September',
                'start_date' => '2026-09-05',
                'end_date' => '2026-09-05',
                'type' => 'hr',
                'color' => '#2f7bf6',
            ],
            [
                'title' => 'Payroll Processing',
                'description' => 'Proses pembayaran gaji karyawan bulan Agustus 2026',
                'start_date' => '2026-09-10',
                'end_date' => '2026-09-12',
                'type' => 'hr',
                'color' => '#8b5cf6',
            ],
            [
                'title' => 'Hari Raya Natal',
                'description' => 'Hari Natal - libur nasional',
                'start_date' => '2026-12-25',
                'end_date' => '2026-12-25',
                'type' => 'holiday',
                'color' => '#e5484d',
            ],
            [
                'title' => 'Cuti Bersama Natal',
                'description' => 'Cuti bersama hari raya Natal 2026',
                'start_date' => '2026-12-26',
                'end_date' => '2026-12-26',
                'type' => 'holiday',
                'color' => '#e8bf00',
            ],
            [
                'title' => 'Tahun Baru 2027',
                'description' => 'Perayaan Tahun Baru 2027 - libur nasional',
                'start_date' => '2027-01-01',
                'end_date' => '2027-01-01',
                'type' => 'holiday',
                'color' => '#e5484d',
            ],
            [
                'title' => 'Review Kontrak Karyawan Q4',
                'description' => 'Review dan pembaruan kontrak karyawan Q4 2026',
                'start_date' => '2026-10-01',
                'end_date' => '2026-10-05',
                'type' => 'hr',
                'color' => '#2f7bf6',
            ],
            [
                'title' => 'Training Karyawan Baru',
                'description' => 'Program orientasi dan training karyawan baru kuartal 4',
                'start_date' => '2026-10-15',
                'end_date' => '2026-10-17',
                'type' => 'company',
                'color' => '#19b95b',
            ],
            [
                'title' => 'Rapat Akhir Tahun HR',
                'description' => 'Evaluasi kinerja tahunan dan perencanaan SDM 2027',
                'start_date' => '2026-12-10',
                'end_date' => '2026-12-10',
                'type' => 'hr',
                'color' => '#2f7bf6',
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(
                ['title' => $event['title'], 'start_date' => $event['start_date']],
                $event
            );
        }
    }
}
