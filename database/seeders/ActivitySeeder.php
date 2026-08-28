<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'employee_name' => 'Siti Nurhaliza',
                'type' => 'new_employee',
                'description' => 'Karyawan baru ditambahkan',
                'occurred_at' => now()->subHours(2),
            ],
            [
                'employee_name' => 'Budi Santoso',
                'type' => 'absent',
                'description' => 'Tidak hadir',
                'occurred_at' => now()->subHours(3),
            ],
            [
                'employee_name' => 'Dewi Lestari',
                'type' => 'excused',
                'description' => 'Izin - Sakit',
                'occurred_at' => now()->subHours(5),
            ],
            [
                'employee_name' => 'Rizky Pratama',
                'type' => 'resigned',
                'description' => 'Resign',
                'occurred_at' => now()->subDay(),
            ],
            [
                'employee_name' => 'Ahmad Fauzi',
                'type' => 'blacklisted',
                'description' => 'Diblacklist - Pelanggaran Kontrak Kerja',
                'occurred_at' => now()->subDays(2),
            ],
            [
                'employee_name' => 'Dimas Saputra',
                'type' => 'blacklisted',
                'description' => 'Diblacklist - Pelanggaran Berat',
                'occurred_at' => now()->subDays(3),
            ],
        ];

        foreach ($activities as $act) {
            $employee = Employee::where('name', $act['employee_name'])->first();
            Activity::create([
                'employee_id' => $employee?->id,
                'employee_name' => $act['employee_name'],
                'type' => $act['type'],
                'description' => $act['description'],
                'occurred_at' => $act['occurred_at'],
            ]);
        }
    }
}
