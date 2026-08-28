<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\FaceEnrollment;
use Illuminate\Database\Seeder;

class FaceEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enrollments = [
            [
                'department' => 'JRI PABRIK',
                'employee_name' => 'Rukman Fadli Nulhakim',
                'status' => 'Pending',
                'notes' => 'Pendaftaran wajah karyawan baru pabrik',
            ],
            [
                'department' => 'VALE',
                'employee_name' => 'Nova Silvana',
                'status' => 'Pending',
                'notes' => 'Pendaftaran wajah divisi Vale',
            ],
            [
                'department' => 'MILDOS RETAIL',
                'employee_name' => 'Zihan Latifah',
                'status' => 'Pending',
                'notes' => 'Re-enrollment data wajah',
            ],
            [
                'department' => 'MILDOS RETAIL',
                'employee_name' => 'Melani Sinta',
                'status' => 'Approved',
                'notes' => 'Verifikasi selesai',
            ],
            [
                'department' => 'MILDOS RETAIL',
                'employee_name' => 'Zihan Latifah',
                'status' => 'Approved',
                'notes' => 'Verifikasi selesai',
            ],
            [
                'department' => 'INTERNSHIP',
                'employee_name' => 'Renaldi Simamora',
                'status' => 'Approved',
                'notes' => 'Pendaftaran mahasiswa magang IT',
            ],
            [
                'department' => 'MILDOS DISTRI',
                'employee_name' => 'Apri Hidayat',
                'status' => 'Pending',
                'notes' => 'Pendaftaran divisi distribusi',
            ],
            [
                'department' => 'MILDOS DISTRI',
                'employee_name' => 'Apri Hidayat',
                'status' => 'Approved',
                'notes' => 'Verifikasi selesai',
            ],
        ];

        foreach ($enrollments as $item) {
            $employee = Employee::where('name', $item['employee_name'])->first();
            FaceEnrollment::create([
                'employee_id' => $employee?->id,
                'department' => $item['department'],
                'employee_name' => $item['employee_name'],
                'status' => $item['status'],
                'notes' => $item['notes'],
            ]);
        }
    }
}
