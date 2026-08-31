<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance logs with summary metrics and filters.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $location = $request->query('location');
        $date = $request->query('date');

        // Summary Metric Cards
        $metricCounts = [
            'on_time' => Attendance::whereIn('status', ['On Time', 'on_time', 'Present'])->count(),
            'late' => Attendance::whereIn('status', ['Late', 'late'])->count(),
            'absent' => Attendance::whereIn('status', ['Absent', 'absent'])->count(),
            'excused' => Attendance::whereIn('status', ['Excused', 'excused'])->count(),
            'off_day' => Attendance::whereIn('status', ['Off Day', 'off_day'])->count(),
            'pending' => Attendance::whereIn('status', ['Pending', 'pending'])->count(),
        ];

        // Query Attendances with Eager Loading
        $query = Attendance::query()
            ->with(['employee'])
            ->search($search)
            ->filterStatus($status)
            ->filterLocation($location)
            ->filterDate($date)
            ->latest('date')
            ->latest('id');

        $attendances = $query->paginate(15)->withQueryString();

        $locations = Employee::query()
            ->whereNotNull('location')
            ->distinct()
            ->pluck('location');

        return view('attendances.index', [
            'attendances' => $attendances,
            'metricCounts' => $metricCounts,
            'search' => $search,
            'status' => $status,
            'location' => $location,
            'date' => $date,
            'locations' => $locations,
        ]);
    }

    /**
     * Display the aggregated attendance reports per employee / department.
     */
    public function reports(Request $request): View
    {
        $search = $request->query('search');
        $month = $request->query('month', now()->format('Y-m'));

        $employees = Employee::query()
            ->search($search)
            ->with(['attendances' => function ($query) use ($month) {
                if ($month) {
                    $query->where('date', 'like', "{$month}%");
                }
            }])
            ->orderBy('department', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->withQueryString();

        // Calculate summary for each employee
        $reportData = $employees->through(function (Employee $employee) {
            $attendances = $employee->attendances;

            $presentCount = $attendances->whereIn('status', ['Present', 'On Time', 'on_time'])->count();
            $lateCount = $attendances->whereIn('status', ['Late', 'late'])->count();
            $absentCount = $attendances->whereIn('status', ['Absent', 'absent'])->count();
            $excusedCount = $attendances->whereIn('status', ['Excused', 'excused'])->count();
            $overtimeCount = $attendances->sum('overtime_hours');

            return [
                'employee' => $employee,
                'department' => $employee->department ?? 'General',
                'present' => $presentCount,
                'late' => $lateCount,
                'absent' => $absentCount,
                'excused' => $excusedCount,
                'overtime' => $overtimeCount,
            ];
        });

        return view('attendances.reports', [
            'reportData' => $reportData,
            'employees' => $employees,
            'search' => $search,
            'month' => $month,
        ]);
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(StoreAttendanceRequest $request): RedirectResponse
    {
        Attendance::create($request->validated());

        return redirect()->route('attendances.index')
            ->with('success', 'Data presensi berhasil ditambahkan.');
    }

    /**
     * Update the specified attendance record.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance): RedirectResponse
    {
        $attendance->update($request->validated());

        return redirect()->route('attendances.index')
            ->with('success', 'Data presensi berhasil diperbarui.');
    }

    /**
     * Remove the specified attendance record.
     */
    public function destroy(Attendance $attendance): RedirectResponse
    {
        $attendance->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Data presensi berhasil dihapus.');
    }
}
