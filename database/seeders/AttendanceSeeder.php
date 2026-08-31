<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::query()->delete();

        $employees = Employee::all();
        $today = now()->format('Y-m-d');

        $locations = [
            'Mildos Pamulang',
            'Mildos Tanjung Duren',
            'Mildos Kelapa Gading',
            'Mildos Pasar Kemis',
            'Mildos Graha Raya',
            'Mildos Gading Serpong',
        ];

        $shifts = [
            'Retail : Siang',
            'Retail : Pagi',
            'Office : Reguler',
            'Factory : Shift 1',
        ];

        // Specific sample attendance logs matching UI screenshots
        $sampleLogs = [
            ['name' => 'Heni Hermiyati', 'location' => 'Mildos Pamulang', 'shift' => 'Retail : Siang', 'status' => 'Present', 'clock_in' => '2026-08-31 13:07:16', 'clock_out' => null],
            ['name' => 'Rahmawati', 'location' => 'Mildos Tanjung Duren', 'shift' => 'Retail : Siang', 'status' => 'Present', 'clock_in' => '2026-08-31 13:06:35', 'clock_out' => null],
            ['name' => 'Masudah', 'location' => 'Mildos Pamulang', 'shift' => 'Retail : Siang', 'status' => 'Present', 'clock_in' => '2026-08-31 13:05:58', 'clock_out' => null],
            ['name' => 'Herlina Agustiani', 'location' => 'Mildos Kelapa Gading', 'shift' => 'Retail : Siang', 'status' => 'Present', 'clock_in' => '2026-08-31 13:05:39', 'clock_out' => null],
            ['name' => 'Gita Nanda Elisia', 'location' => 'Mildos Pasar Kemis', 'shift' => 'Retail : Siang', 'status' => 'Present', 'clock_in' => '2026-08-31 13:05:29', 'clock_out' => null],
            ['name' => 'Melani Sinta', 'location' => 'Mildos Kelapa Gading', 'shift' => 'Retail : Siang', 'status' => 'Present', 'clock_in' => '2026-08-31 13:05:17', 'clock_out' => null],
            ['name' => 'Vania Zahra Ramadhania', 'location' => 'Mildos Tanjung Duren', 'shift' => 'Retail : Siang', 'status' => 'Present', 'clock_in' => '2026-08-31 13:02:55', 'clock_out' => null],
            ['name' => 'Deviana Puspita Sari', 'location' => 'Mildos Gading Serpong', 'shift' => 'Office : Reguler', 'status' => 'Present', 'clock_in' => '2026-08-31 08:00:00', 'clock_out' => '2026-08-31 17:00:00'],
            ['name' => 'Deby Thalia Pattiwael', 'location' => 'Mildos Gading Serpong', 'shift' => 'Office : Reguler', 'status' => 'Late', 'clock_in' => '2026-08-31 08:35:12', 'clock_out' => '2026-08-31 17:00:00'],
            ['name' => 'Anggi Ariska', 'location' => 'Mildos Gading Serpong', 'shift' => 'Office : Reguler', 'status' => 'Present', 'clock_in' => '2026-08-31 07:55:00', 'clock_out' => '2026-08-31 17:00:00'],
            ['name' => 'Wahyu Aji Pamungkas', 'location' => 'Mildos Gading Serpong', 'shift' => 'Office : Reguler', 'status' => 'Excused', 'clock_in' => null, 'clock_out' => null],
            ['name' => 'Risma Arista', 'location' => 'Mildos Gading Serpong', 'shift' => 'Office : Reguler', 'status' => 'Off Day', 'clock_in' => null, 'clock_out' => null],
            ['name' => 'Azhari Guretno Asri', 'location' => 'Mildos Gading Serpong', 'shift' => 'Office : Reguler', 'status' => 'Absent', 'clock_in' => null, 'clock_out' => null],
        ];

        foreach ($sampleLogs as $log) {
            $employee = $employees->firstWhere('name', $log['name']);
            Attendance::create([
                'employee_id' => $employee?->id,
                'employee_name' => $log['name'],
                'location' => $log['location'],
                'shift' => $log['shift'],
                'date' => $today,
                'status' => $log['status'],
                'clock_in' => $log['clock_in'],
                'clock_out' => $log['clock_out'],
                'check_in_time' => $log['clock_in'] ? date('H:i:s', strtotime($log['clock_in'])) : null,
                'check_out_time' => $log['clock_out'] ? date('H:i:s', strtotime($log['clock_out'])) : null,
                'notes' => 'Presensi harian sistem KDM Mildos',
            ]);
        }

        // Additional past attendances for realistic reports and metrics
        foreach ($employees as $index => $employee) {
            for ($days = 1; $days <= 25; $days++) {
                $pastDate = now()->subDays($days)->format('Y-m-d');
                $statuses = ['Present', 'Present', 'Present', 'Present', 'Late', 'Excused'];
                $status = $statuses[($index + $days) % count($statuses)];

                Attendance::create([
                    'employee_id' => $employee->id,
                    'employee_name' => $employee->name,
                    'location' => $employee->location ?? $locations[$index % count($locations)],
                    'shift' => $shifts[$index % count($shifts)],
                    'date' => $pastDate,
                    'status' => $status,
                    'clock_in' => $status === 'Present' ? "{$pastDate} 08:00:00" : ($status === 'Late' ? "{$pastDate} 08:45:00" : null),
                    'clock_out' => $status === 'Present' || $status === 'Late' ? "{$pastDate} 17:00:00" : null,
                    'check_in_time' => $status === 'Present' ? '08:00:00' : ($status === 'Late' ? '08:45:00' : null),
                    'check_out_time' => $status === 'Present' || $status === 'Late' ? '17:00:00' : null,
                    'overtime_hours' => ($days % 5 === 0) ? 2 : 0,
                    'notes' => 'Rekap otomatis sistem',
                ]);
            }
        }
    }
}
