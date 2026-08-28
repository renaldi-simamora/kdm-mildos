<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = now()->format('Y-m-d');

        // Create today attendance
        $attendanceTypes = [
            'on_time' => 119,
            'late' => 0,
            'absent' => 4,
            'excused' => 3,
            'off_day' => 2,
        ];

        foreach ($attendanceTypes as $status => $count) {
            for ($i = 0; $i < $count; $i++) {
                Attendance::create([
                    'employee_id' => null,
                    'employee_name' => 'Karyawan '.($i + 1),
                    'date' => $today,
                    'status' => $status,
                    'check_in_time' => $status === 'on_time' ? '08:00:00' : ($status === 'late' ? '08:45:00' : null),
                    'check_out_time' => $status === 'on_time' ? '17:00:00' : null,
                ]);
            }
        }

        // Create past 6 days trend data
        $trendCounts = [
            6 => 112,
            5 => 118,
            4 => 122,
            3 => 117,
            2 => 113,
            1 => 122,
        ];

        foreach ($trendCounts as $daysAgo => $count) {
            $pastDate = now()->subDays($daysAgo)->format('Y-m-d');
            for ($i = 0; $i < $count; $i++) {
                Attendance::create([
                    'employee_id' => null,
                    'employee_name' => 'Karyawan '.($i + 1),
                    'date' => $pastDate,
                    'status' => 'on_time',
                    'check_in_time' => '08:00:00',
                    'check_out_time' => '17:00:00',
                ]);
            }
        }
    }
}
