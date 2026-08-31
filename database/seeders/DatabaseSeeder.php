<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // OWNER
        User::create([
            'name' => 'Owner KDM',
            'username' => 'owner',
            'email' => 'owner@kdm-mildos.test',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
        ]);

        // SUPERADMIN
        User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'email' => 'superadmin@kdm-mildos.test',
            'password' => Hash::make('admin123'),
            'role' => 'superadmin',
        ]);

        // STAFF
        User::create([
            'name' => 'Karyawan KDM',
            'username' => 'staff',
            'email' => 'staff@kdm-mildos.test',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        // HRD
        User::create([
            'name' => 'HRD KDM',
            'username' => 'hrd',
            'email' => 'hrd@kdm-mildos.test',
            'password' => Hash::make('hrd123'),
            'role' => 'hrd',
        ]);

        // EMPLOYEES & FACE ENROLLMENTS & ATTENDANCE & ACTIVITIES & OFF TIMES
        $this->call([
            EmployeeSeeder::class,
            FaceEnrollmentSeeder::class,
            OffTimeTypeSeeder::class,
            OffTimeSeeder::class,
            AttendanceSeeder::class,
            ActivitySeeder::class,
            ShiftSeeder::class,
            EventSeeder::class,
        ]);
    }
}
