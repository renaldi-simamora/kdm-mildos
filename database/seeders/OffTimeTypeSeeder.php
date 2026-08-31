<?php

namespace Database\Seeders;

use App\Models\OffTimeType;
use Illuminate\Database\Seeder;

class OffTimeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Libur',
                'max_off_times' => 4,
                'interval_type' => 'Monthly',
                'superadmin_approval' => false,
                'status' => 'Active',
            ],
            [
                'name' => 'Izin',
                'max_off_times' => 1,
                'interval_type' => 'Monthly',
                'superadmin_approval' => true,
                'status' => 'Active',
            ],
            [
                'name' => 'Sakit',
                'max_off_times' => 1,
                'interval_type' => 'Monthly',
                'superadmin_approval' => true,
                'status' => 'Active',
            ],
            [
                'name' => 'Cuti Maulid Nabi 1448 H',
                'max_off_times' => 1,
                'interval_type' => 'Yearly',
                'superadmin_approval' => false,
                'status' => 'Active',
            ],
            [
                'name' => 'Cuti Tahunan',
                'max_off_times' => 6,
                'interval_type' => 'Yearly',
                'superadmin_approval' => true,
                'status' => 'Inactive',
            ],
            [
                'name' => 'Cuti Menikah',
                'max_off_times' => 7,
                'interval_type' => 'Yearly',
                'superadmin_approval' => true,
                'status' => 'Inactive',
            ],
            [
                'name' => 'Cuti Imlek',
                'max_off_times' => 1,
                'interval_type' => 'Yearly',
                'superadmin_approval' => true,
                'status' => 'Inactive',
            ],
            [
                'name' => 'Cuti Idul Fitri',
                'max_off_times' => 7,
                'interval_type' => 'Yearly',
                'superadmin_approval' => true,
                'status' => 'Inactive',
            ],
            [
                'name' => 'Cuti Idul Adha',
                'max_off_times' => 1,
                'interval_type' => 'Yearly',
                'superadmin_approval' => true,
                'status' => 'Inactive',
            ],
            [
                'name' => 'Cuti Tahun Baru',
                'max_off_times' => 1,
                'interval_type' => 'Yearly',
                'superadmin_approval' => true,
                'status' => 'Inactive',
            ],
            [
                'name' => 'Cuti Lamaran',
                'max_off_times' => 2,
                'interval_type' => 'Yearly',
                'superadmin_approval' => true,
                'status' => 'Inactive',
            ],
            [
                'name' => 'Cuti Hari Kemerdekaan',
                'max_off_times' => 1,
                'interval_type' => 'Yearly',
                'superadmin_approval' => false,
                'status' => 'Inactive',
            ],
        ];

        foreach ($types as $type) {
            OffTimeType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}
