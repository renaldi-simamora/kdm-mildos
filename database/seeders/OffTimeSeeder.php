<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\OffTime;
use App\Models\OffTimeType;
use App\Models\User;
use Illuminate\Database\Seeder;

class OffTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $types = OffTimeType::all();
        $approver = User::where('role', 'superadmin')->first() ?? User::first();

        if ($employees->isEmpty() || $types->isEmpty()) {
            return;
        }

        $sampleLeaves = [
            [
                'employee_index' => 0,
                'type_name' => 'Sakit',
                'start_date' => now()->addDays(2)->format('Y-m-d'),
                'end_date' => now()->addDays(3)->format('Y-m-d'),
                'recurrence_type' => 'None',
                'reason' => 'Sakit demam butuh istirahat',
                'status' => 'Pending',
            ],
            [
                'employee_index' => 1,
                'type_name' => 'Izin',
                'start_date' => now()->addDays(5)->format('Y-m-d'),
                'end_date' => now()->addDays(5)->format('Y-m-d'),
                'recurrence_type' => 'None',
                'reason' => 'Keperluan keluarga mendesak',
                'status' => 'Approved',
            ],
            [
                'employee_index' => 2,
                'type_name' => 'Libur',
                'start_date' => now()->addDays(1)->format('Y-m-d'),
                'end_date' => now()->addDays(1)->format('Y-m-d'),
                'recurrence_type' => 'Weekly',
                'reason' => 'Off day mingguan',
                'status' => 'Approved',
            ],
        ];

        foreach ($sampleLeaves as $leave) {
            $emp = $employees[$leave['employee_index'] % $employees->count()];
            $offType = $types->where('name', $leave['type_name'])->first() ?? $types->first();

            OffTime::create([
                'employee_id' => $emp->id,
                'off_time_type_id' => $offType->id,
                'approver_id' => $leave['status'] === 'Approved' ? $approver?->id : null,
                'location' => $emp->location,
                'recurrence_type' => $leave['recurrence_type'],
                'start_date' => $leave['start_date'],
                'end_date' => $leave['end_date'],
                'reason' => $leave['reason'],
                'status' => $leave['status'],
            ]);
        }
    }
}
