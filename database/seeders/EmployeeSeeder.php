<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'employee_code' => 'MLD0001',
                'name' => 'Deviana Puspita Sari',
                'email' => 'devvps.08@gmail.com',
                'birth_date' => '1993-08-15',
                'job_title' => 'HRD',
                'department' => 'HRD',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0002',
                'name' => 'Deby Thalia Pattiwael',
                'email' => 'Debbythaliapatt@gmail.com',
                'birth_date' => '1995-09-22',
                'job_title' => 'Manager Training',
                'department' => 'HRD',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0003',
                'name' => 'Anggi Ariska',
                'email' => 'anggiariska1601@gmail.com',
                'birth_date' => '1997-01-16',
                'job_title' => 'Finance Retail',
                'department' => 'FINANCE',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0004',
                'name' => 'Wahyu Aji Pamungkas',
                'email' => 'wajip1998@gmail.com',
                'birth_date' => '1998-03-04',
                'job_title' => 'Manager Store',
                'department' => 'MILDOS RETAIL',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0005',
                'name' => 'Risma Arista',
                'email' => 'rismaarista41210@gmail.com',
                'birth_date' => '1996-12-10',
                'job_title' => 'Tim Analisis',
                'department' => 'MILDOS RETAIL',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0006',
                'name' => 'Azhari Guretno Asri',
                'email' => 'azhariguretno@gmail.com',
                'birth_date' => '1990-11-07',
                'job_title' => 'Admin Packing',
                'department' => 'MILDOS DISTRI',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0007',
                'name' => 'Kunti Mutmainah',
                'email' => 'utimutmainah5@gmail.com',
                'birth_date' => '1992-07-19',
                'job_title' => 'Admin Packing',
                'department' => 'MILDOS DISTRI',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0008',
                'name' => 'Rukman Fadli Nulhakim',
                'email' => 'rukman.fadli@gmail.com',
                'birth_date' => '1989-05-30',
                'job_title' => 'Staff Pabrik',
                'department' => 'JRI PABRIK',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0009',
                'name' => 'Nova Silvana',
                'email' => 'nova.silvana@gmail.com',
                'birth_date' => '1994-04-12',
                'job_title' => 'Staff Vale',
                'department' => 'VALE',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0010',
                'name' => 'Zihan Latifah',
                'email' => 'zihan.latifah@gmail.com',
                'birth_date' => '1999-10-03',
                'job_title' => 'Retail Staff',
                'department' => 'MILDOS RETAIL',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0011',
                'name' => 'Melani Sinta',
                'email' => 'melani.sinta@gmail.com',
                'birth_date' => '1998-09-08',
                'job_title' => 'Retail Staff',
                'department' => 'MILDOS RETAIL',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0012',
                'name' => 'Renaldi Simamora',
                'email' => 'renaldi.simamora@gmail.com',
                'birth_date' => '2002-02-25',
                'job_title' => 'IT Software Intern',
                'department' => 'INTERNSHIP',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Internship',
            ],
            [
                'employee_code' => 'MLD0013',
                'name' => 'Apri Hidayat',
                'email' => 'apri.hidayat@gmail.com',
                'birth_date' => '1991-06-14',
                'job_title' => 'Distributor Staff',
                'department' => 'MILDOS DISTRI',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0014',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@gmail.com',
                'birth_date' => '1996-08-31',
                'job_title' => 'Customer Service',
                'department' => 'MILDOS RETAIL',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Active',
            ],
            [
                'employee_code' => 'MLD0015',
                'name' => 'Rizky Pratama',
                'email' => 'rizky.pratama@gmail.com',
                'birth_date' => '1993-09-17',
                'job_title' => 'Staff Logistik',
                'department' => 'MILDOS DISTRI',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Resigned',
            ],
            [
                'employee_code' => 'MLD0016',
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@gmail.com',
                'birth_date' => '1988-12-28',
                'job_title' => 'Staff Gudang',
                'department' => 'JRI PABRIK',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Resigned',
            ],
            [
                'employee_code' => 'MLD0017',
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@gmail.com',
                'birth_date' => '1987-03-20',
                'job_title' => 'Operator Mesin',
                'department' => 'JRI PABRIK',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Blacklisted',
            ],
            [
                'employee_code' => 'MLD0018',
                'name' => 'Dimas Saputra',
                'email' => 'dimas.saputra@gmail.com',
                'birth_date' => '1995-07-05',
                'job_title' => 'Sales Representative',
                'department' => 'MILDOS RETAIL',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Blacklisted',
            ],
            [
                'employee_code' => 'MLD0019',
                'name' => 'Bagas Pratama',
                'email' => 'bagas.pratama@gmail.com',
                'birth_date' => '2003-11-23',
                'job_title' => 'Design Intern',
                'department' => 'INTERNSHIP',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Internship',
            ],
            [
                'employee_code' => 'MLD0020',
                'name' => 'Farhan Malik',
                'email' => 'farhan.malik@gmail.com',
                'birth_date' => '2001-04-18',
                'job_title' => 'Marketing Intern',
                'department' => 'INTERNSHIP',
                'location' => 'Mildos Gading Serpong',
                'status' => 'Internship',
            ],
        ];

        $now = now();
        $staggeredDates = [
            $now->copy()->subMonths(5)->setDay(10),
            $now->copy()->subMonths(5)->setDay(15),
            $now->copy()->subMonths(5)->setDay(20),
            $now->copy()->subMonths(4)->setDay(5),
            $now->copy()->subMonths(4)->setDay(12),
            $now->copy()->subMonths(4)->setDay(18),
            $now->copy()->subMonths(3)->setDay(8),
            $now->copy()->subMonths(3)->setDay(22),
            $now->copy()->subMonths(3)->setDay(25),
            $now->copy()->subMonths(2)->setDay(4),
            $now->copy()->subMonths(2)->setDay(14),
            $now->copy()->subMonths(2)->setDay(28),
            $now->copy()->subMonths(1)->setDay(2),
            $now->copy()->subMonths(1)->setDay(16),
            $now->copy()->subMonths(1)->setDay(20), // Rizky (Resigned)
            $now->copy()->subMonths(1)->setDay(25), // Hendra (Resigned)
            $now->copy()->startOfMonth()->setDay(3),
            $now->copy()->startOfMonth()->setDay(7),
            $now->copy()->startOfMonth()->setDay(12),
            $now->copy()->startOfMonth()->setDay(18),
        ];

        foreach ($employees as $idx => $item) {
            $created = $staggeredDates[$idx] ?? $now;
            $updated = $item['status'] === 'Resigned' ? $created->copy()->addDays(20) : $created;

            $item['created_at'] = $created;
            $item['updated_at'] = $updated;

            Employee::updateOrCreate(
                ['employee_code' => $item['employee_code']],
                $item
            );
        }
    }
}
