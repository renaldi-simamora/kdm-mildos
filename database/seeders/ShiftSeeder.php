<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shifts = [
            [
                'department' => 'MILDOS RETAIL',
                'name' => 'MILDOS : Office Senin - Jumat',
                'start_time' => '10:00:00',
                'end_time' => '20:00:00',
                'early_tolerance_minutes' => 200,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'MILDOS RETAIL',
                'name' => 'MILDOS : Office Sabtu',
                'start_time' => '10:00:00',
                'end_time' => '19:00:00',
                'early_tolerance_minutes' => 200,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'GYMZONE',
                'name' => 'Office GD Sabtu',
                'start_time' => '11:00:00',
                'end_time' => '17:00:00',
                'early_tolerance_minutes' => 200,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'VALE',
                'name' => 'Operasional VALE',
                'start_time' => '10:00:00',
                'end_time' => '20:00:00',
                'early_tolerance_minutes' => 120,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'JRI PABRIK',
                'name' => 'JRI : Office Senin - Jumat',
                'start_time' => '10:00:00',
                'end_time' => '20:00:00',
                'early_tolerance_minutes' => 200,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'JRI PABRIK',
                'name' => 'JRI : Office Sabtu',
                'start_time' => '10:00:00',
                'end_time' => '19:00:00',
                'early_tolerance_minutes' => 200,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'GYMZONE',
                'name' => 'Office Gymzone Senin - Jumat',
                'start_time' => '10:00:00',
                'end_time' => '20:00:00',
                'early_tolerance_minutes' => 200,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'GYMZONE',
                'name' => 'Office Gymzone Sabtu',
                'start_time' => '10:00:00',
                'end_time' => '19:00:00',
                'early_tolerance_minutes' => 200,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'NUUM PARFUM',
                'name' => 'Retail : Parfum',
                'start_time' => '12:00:00',
                'end_time' => '22:00:00',
                'early_tolerance_minutes' => 120,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'VALE',
                'name' => 'VALE Office',
                'start_time' => '10:00:00',
                'end_time' => '18:00:00',
                'early_tolerance_minutes' => 120,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'MILDOS RETAIL',
                'name' => 'Retail : Shift Berdua',
                'start_time' => '12:00:00',
                'end_time' => '22:00:00',
                'early_tolerance_minutes' => 120,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'MILDOS DISTRI',
                'name' => 'Distribusi Pagi',
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'early_tolerance_minutes' => 30,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'HRD',
                'name' => 'HRD Office',
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'early_tolerance_minutes' => 30,
                'late_tolerance_minutes' => 15,
                'status' => 'Active',
            ],
            [
                'department' => 'FINANCE',
                'name' => 'Finance Office',
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'early_tolerance_minutes' => 30,
                'late_tolerance_minutes' => 15,
                'status' => 'Inactive',
            ],
        ];

        foreach ($shifts as $shift) {
            Shift::create($shift);
        }
    }
}
