<?php

namespace Database\Seeders;

use App\Models\AttendanceRequest;
use App\Models\ChangeShiftRequest;
use App\Models\Employee;
use App\Models\OffTimeRequest;
use App\Models\OffTimeType;
use App\Models\OvertimeRequest;
use App\Models\Shift;
use Illuminate\Database\Seeder;

class FormRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $offType = OffTimeType::where('name', 'Izin')->first() ?? OffTimeType::first();
        $shifts = Shift::all();

        if ($employees->isEmpty()) {
            return;
        }

        // 1. Off Time Requests (exact mock data from Screenshot 1)
        $offTimeData = [
            ['name' => 'Nanang Sutrisno', 'dates' => '2026-08-31', 'req_at' => '2026-08-31 10:05:00'],
            ['name' => 'Triandiny Dewi Rachma', 'dates' => '2026-08-30', 'req_at' => '2026-08-30 19:02:00'],
            ['name' => 'Heni Hermiyati', 'dates' => '2026-08-30', 'req_at' => '2026-08-29 08:17:00'],
            ['name' => 'Rahmawati', 'dates' => '2026-08-30', 'req_at' => '2026-08-29 09:07:00'],
            ['name' => 'Nayshika Oktaviani', 'dates' => '2026-08-30', 'req_at' => '2026-08-29 10:15:00'],
            ['name' => 'Herlina Agustiani', 'dates' => '2026-08-30', 'req_at' => '2026-08-29 13:17:00'],
            ['name' => 'Deby Thalia Pattiwael', 'dates' => '2026-08-30', 'req_at' => '2026-08-29 13:20:00'],
            ['name' => 'Surani Novitasari', 'dates' => '2026-08-30', 'req_at' => '2026-08-29 18:54:00'],
            ['name' => 'Hessy Machmudinda Pangesti', 'dates' => '2026-08-30', 'req_at' => '2026-08-29 19:40:00'],
            ['name' => 'Shella Amelia', 'dates' => '2026-08-29', 'req_at' => '2026-08-28 09:01:00'],
            ['name' => 'Alda', 'dates' => '2026-08-29', 'req_at' => '2026-08-28 09:21:00'],
            ['name' => 'Delvi Novita Sari', 'dates' => '2026-08-30', 'req_at' => '2026-08-28 11:40:00'],
            ['name' => 'Nabilla Hendryani Putri', 'dates' => '2026-08-29', 'req_at' => '2026-08-28 16:53:00'],
        ];

        foreach ($offTimeData as $item) {
            $emp = $employees->firstWhere('name', $item['name']) ?? Employee::create([
                'employee_code' => 'MLD'.rand(1000, 9999),
                'name' => $item['name'],
                'email' => strtolower(str_replace(' ', '', $item['name'])).'@kdm-mildos.test',
                'department' => 'MILDOS RETAIL',
                'status' => 'Active',
            ]);

            OffTimeRequest::create([
                'employee_id' => $emp->id,
                'off_time_type_id' => $offType?->id,
                'department' => 'All Employees',
                'start_date' => $item['dates'],
                'end_date' => $item['dates'],
                'requested_at' => $item['req_at'],
                'reason' => 'Pengajuan Izin Tidak Masuk',
                'status' => 'In Review',
            ]);
        }

        // 2. Attendance Requests (exact mock data from Screenshot 2)
        $attendanceReqData = [
            ['name' => 'Rizki Fajar Ramadhan', 'req_date' => '2026-08-27', 'in' => null, 'out' => '20:05:00', 'req_at' => '2026-08-28 09:45:00'],
            ['name' => 'Rina Wati', 'req_date' => '2026-08-11', 'in' => null, 'out' => '20:00:00', 'req_at' => '2026-08-28 10:42:00'],
            ['name' => 'Putri Agustina', 'req_date' => '2026-08-25', 'in' => null, 'out' => '20:32:00', 'req_at' => '2026-08-26 10:06:00'],
            ['name' => 'Resqita Cellyna Putri', 'req_date' => '2026-08-19', 'in' => null, 'out' => '20:00:00', 'req_at' => '2026-08-26 19:45:00'],
            ['name' => 'Teguh Hadi Gunawan', 'req_date' => '2026-08-24', 'in' => '10:00:00', 'out' => '20:00:00', 'req_at' => '2026-08-24 12:21:00'],
            ['name' => 'Renaldi Simamora', 'req_date' => '2026-08-24', 'in' => '09:50:00', 'out' => null, 'req_at' => '2026-08-24 15:50:00'],
            ['name' => 'Wahyu Aji Pamungkas', 'req_date' => '2026-08-21', 'in' => null, 'out' => '20:00:00', 'req_at' => '2026-08-22 11:02:00'],
            ['name' => 'Yunita Azizah Putri', 'req_date' => '2026-08-21', 'in' => '13:00:00', 'out' => '23:00:00', 'req_at' => '2026-08-22 11:56:00'],
            ['name' => 'Apri Hidayat', 'req_date' => '2026-08-22', 'in' => null, 'out' => '19:07:00', 'req_at' => '2026-08-22 19:07:00'],
            ['name' => 'Benyamin Fajar Krisdianto', 'req_date' => '2026-08-21', 'in' => '13:49:00', 'out' => null, 'req_at' => '2026-08-21 13:49:00'],
            ['name' => 'Rahmawati Putri', 'req_date' => '2026-08-19', 'in' => null, 'out' => '22:00:00', 'req_at' => '2026-08-21 19:43:00'],
            ['name' => 'Benyamin Fajar Krisdianto', 'req_date' => '2026-08-21', 'in' => null, 'out' => '20:01:00', 'req_at' => '2026-08-21 20:02:00'],
            ['name' => 'Teguh Hadi Gunawan', 'req_date' => '2026-08-18', 'in' => '10:04:00', 'out' => '20:00:00', 'req_at' => '2026-08-18 10:06:00'],
            ['name' => 'Meta Yurida', 'req_date' => '2026-08-13', 'in' => null, 'out' => '20:00:00', 'req_at' => '2026-08-16 09:06:00'],
        ];

        foreach ($attendanceReqData as $item) {
            $emp = $employees->firstWhere('name', $item['name']) ?? Employee::create([
                'employee_code' => 'MLD'.rand(1000, 9999),
                'name' => $item['name'],
                'email' => strtolower(str_replace(' ', '', $item['name'])).'@kdm-mildos.test',
                'department' => 'MILDOS RETAIL',
                'status' => 'Active',
            ]);

            AttendanceRequest::create([
                'employee_id' => $emp->id,
                'request_date' => $item['req_date'],
                'clock_in' => $item['in'],
                'clock_out' => $item['out'],
                'requested_at' => $item['req_at'],
                'reason' => 'Koreksi Lupa Absensi Finger/Face',
                'status' => 'In Review',
            ]);
        }

        // 3. Change Shift Requests
        $changeShiftData = [
            ['name' => 'Deviana Puspita Sari', 'delegate' => 'Deby Thalia Pattiwael', 'shift_to' => 'Retail : Siang', 'date' => '2026-08-31', 'req_at' => '2026-08-30 14:20:00'],
            ['name' => 'Anggi Ariska', 'delegate' => 'Risma Arista', 'shift_to' => 'Retail : Pagi', 'date' => '2026-09-01', 'req_at' => '2026-08-31 09:15:00'],
        ];

        foreach ($changeShiftData as $item) {
            $emp = $employees->firstWhere('name', $item['name']) ?? $employees->first();
            $delegate = $employees->firstWhere('name', $item['delegate']) ?? $employees->skip(1)->first();

            ChangeShiftRequest::create([
                'employee_id' => $emp->id,
                'delegate_employee_id' => $delegate?->id,
                'shift_id' => $shifts->first()?->id,
                'shift_to' => $item['shift_to'],
                'request_date' => $item['date'],
                'requested_at' => $item['req_at'],
                'reason' => 'Tukar shift jadwal jaga toko',
                'status' => 'In Review',
            ]);
        }

        // 4. Overtime Requests
        $overtimeData = [
            ['name' => 'Wahyu Aji Pamungkas', 'date' => '2026-08-31', 'time' => '18:00 - 21:00', 'hours' => 3.0, 'req_at' => '2026-08-31 16:30:00'],
            ['name' => 'Melani Sinta', 'date' => '2026-08-30', 'time' => '17:00 - 19:00', 'hours' => 2.0, 'req_at' => '2026-08-30 15:00:00'],
        ];

        foreach ($overtimeData as $item) {
            $emp = $employees->firstWhere('name', $item['name']) ?? $employees->first();

            OvertimeRequest::create([
                'employee_id' => $emp->id,
                'request_date' => $item['date'],
                'overtime_time' => $item['time'],
                'total_hours' => $item['hours'],
                'requested_at' => $item['req_at'],
                'reason' => 'Stock opname akhir bulan',
                'status' => 'In Review',
            ]);
        }
    }
}
