<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $tz = 'Asia/Jakarta';
        $now = Carbon::now($tz);

        // ─── Date Range Parsing ───────────────────────────────────────────
        $rawDates = $request->input('dates');
        $startDate = null;
        $endDate = null;

        if (! empty($rawDates)) {
            if (str_contains($rawDates, ' to ')) {
                $parts = explode(' to ', $rawDates);
                $startDateStr = trim($parts[0]);
                $endDateStr = trim($parts[1] ?? $parts[0]);
            } elseif (str_contains($rawDates, ' - ')) {
                $parts = explode(' - ', $rawDates);
                $startDateStr = trim($parts[0]);
                $endDateStr = trim($parts[1] ?? $parts[0]);
            } else {
                $startDateStr = trim($rawDates);
                $endDateStr = trim($rawDates);
            }

            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDateStr, $tz)->startOfDay();
            } catch (\Throwable) {
                try {
                    $startDate = Carbon::parse($startDateStr, $tz)->startOfDay();
                } catch (\Throwable) {
                    $startDate = null;
                }
            }

            try {
                $endDate = Carbon::createFromFormat('Y-m-d', $endDateStr, $tz)->endOfDay();
            } catch (\Throwable) {
                try {
                    $endDate = Carbon::parse($endDateStr, $tz)->endOfDay();
                } catch (\Throwable) {
                    $endDate = null;
                }
            }
        }

        if (! $startDate || ! $endDate) {
            $latestDateStr = Attendance::max('date') ?? $now->format('Y-m-d');
            $startDate = Carbon::parse($latestDateStr, $tz)->startOfDay();
            $endDate = Carbon::parse($latestDateStr, $tz)->endOfDay();
        }

        if ($startDate->gt($endDate)) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $startDateFormatted = $startDate->format('Y-m-d');
        $endDateFormatted = $endDate->format('Y-m-d');
        $selectedDate = $startDateFormatted === $endDateFormatted
            ? $startDateFormatted
            : "{$startDateFormatted} to {$endDateFormatted}";

        // ─── Employee Counts ──────────────────────────────────────────────
        $activeEmployees = Employee::where('status', 'Active')->count();
        $resignedEmployees = Employee::where('status', 'Resigned')->count();
        $blacklistedEmployees = Employee::where('status', 'Blacklisted')->count();
        $partTimeEmployees = Employee::where('status', 'Part Time')->count();
        $internshipEmployees = Employee::where('status', 'Internship')->count();
        $newEmployees = Employee::where('created_at', '>=', $now->copy()->startOfMonth())->count();

        // ─── Attendance Counts (filtered range) ───────────────────────────
        $attendanceQuery = Attendance::whereDate('date', '>=', $startDateFormatted)
            ->whereDate('date', '<=', $endDateFormatted);

        $onTimeCount = (clone $attendanceQuery)->where('status', 'on_time')->count();
        $lateCount = (clone $attendanceQuery)->where('status', 'late')->count();
        $absentCount = (clone $attendanceQuery)->where('status', 'absent')->count();
        $excusedCount = (clone $attendanceQuery)->where('status', 'excused')->count();
        $offDayCount = (clone $attendanceQuery)->where('status', 'off_day')->count();

        $totalAttendance = $onTimeCount + $lateCount + $absentCount + $excusedCount + $offDayCount;

        $onTimePercent = $totalAttendance > 0 ? round(($onTimeCount / $totalAttendance) * 100, 1) : 0;
        $latePercent = $totalAttendance > 0 ? round(($lateCount / $totalAttendance) * 100, 1) : 0;
        $absentPercent = $totalAttendance > 0 ? round(($absentCount / $totalAttendance) * 100, 1) : 0;
        $excusedPercent = $totalAttendance > 0 ? round(($excusedCount / $totalAttendance) * 100, 1) : 0;
        $offDayPercent = $totalAttendance > 0 ? round(($offDayCount / $totalAttendance) * 100, 1) : 0;

        // ─── Attendance Trend (dynamic based on selected period) ──────────
        $trendDays = [];
        $trendValues = [];
        $diffInDays = $startDate->diffInDays($endDate);

        if ($diffInDays === 0) {
            $trendStart = $startDate->copy()->subDays(6);
            $trendEnd = $startDate->copy();
            $trendPeriodLabel = '7 Hari Terakhir';
        } elseif ($diffInDays <= 30) {
            $trendStart = $startDate->copy();
            $trendEnd = $endDate->copy();
            $trendPeriodLabel = ($diffInDays + 1).' Hari';
        } else {
            $trendStart = $endDate->copy()->subDays(29);
            $trendEnd = $endDate->copy();
            $trendPeriodLabel = '30 Hari Terakhir';
        }

        $curr = $trendStart->copy();
        while ($curr->lte($trendEnd)) {
            $dayStr = $curr->format('Y-m-d');
            $trendDays[] = $curr->locale('id')->isoFormat('D MMM');
            $trendValues[] = Attendance::whereDate('date', $dayStr)->where('status', 'on_time')->count();
            $curr->addDay();
        }

        // ─── Employee Overview Trend (6 months) ───────────────────────────
        $overviewMonths = [];
        $overviewActive = [];
        $overviewNew = [];
        $overviewResigned = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = $now->copy()->subMonths($i);
            $monthStart = $monthDate->copy()->startOfMonth();
            $monthEnd = $monthDate->copy()->endOfMonth();

            $overviewMonths[] = $monthDate->locale('id')->isoFormat('MMM');

            $overviewActive[] = Employee::where('status', 'Active')
                ->whereDate('created_at', '<=', $monthEnd)
                ->count();

            $overviewNew[] = Employee::whereDate('created_at', '>=', $monthStart)
                ->whereDate('created_at', '<=', $monthEnd)
                ->count();

            $overviewResigned[] = Employee::where('status', 'Resigned')
                ->whereDate('updated_at', '>=', $monthStart)
                ->whereDate('updated_at', '<=', $monthEnd)
                ->count();
        }

        // ─── Recent Activities ────────────────────────────────────────────
        $activities = Activity::orderBy('occurred_at', 'desc')->limit(6)->get();

        // ─── Upcoming Birthdays ───────────────────────────────────────────
        // Get all active employees that have a birth_date, compute next occurrence
        $today = $now->copy()->startOfDay();
        $todayMD = $today->format('m-d');

        $birthdayEmployees = Employee::whereNotNull('birth_date')
            ->whereIn('status', ['Active', 'Part Time', 'Internship'])
            ->orderBy('name')
            ->get(['id', 'name', 'department', 'birth_date'])
            ->map(function ($emp) use ($today) {
                try {
                    /** @var Carbon $bd */
                    $bd = $emp->birth_date;
                    // compute this year's birthday
                    $thisYear = $bd->copy()->year($today->year);
                    // if already passed today, use next year
                    $nextBirthday = $thisYear->lt($today) ? $thisYear->addYear() : $thisYear;

                    return [
                        'name' => $emp->name,
                        'department' => $emp->department ?? '-',
                        'birth_date_display' => $bd->format('d/m/Y'),
                        'next_birthday' => $nextBirthday,
                        'days_until' => $today->diffInDays($nextBirthday, false),
                        'is_today' => $nextBirthday->isSameDay($today),
                    ];
                } catch (\Throwable) {
                    return null;
                }
            })
            ->filter()
            ->sortBy('days_until')
            ->take(4)
            ->values();

        // ─── Upcoming Events ──────────────────────────────────────────────
        $todayStr = $today->format('Y-m-d');
        $upcomingEvents = Event::where('start_date', '>=', $todayStr)
            ->orderBy('start_date')
            ->limit(4)
            ->get();

        // ─── "Perlu Perhatian" (Needs Attention) ─────────────────────────
        $todayDate = $now->format('Y-m-d');
        $absentToday = Attendance::whereDate('date', $todayDate)->where('status', 'absent')->count();
        $newThisMonth = Employee::where('created_at', '>=', $now->copy()->startOfMonth())->count();
        $contractEnding = 0; // placeholder — no contract table yet

        // ─── Greeting based on server hour ────────────────────────────────
        $serverHour = (int) $now->format('H');
        if ($serverHour < 11) {
            $greeting = 'Selamat pagi';
        } elseif ($serverHour < 15) {
            $greeting = 'Selamat siang';
        } elseif ($serverHour < 18) {
            $greeting = 'Selamat sore';
        } else {
            $greeting = 'Selamat malam';
        }

        // ─── Server date (for calendar) ───────────────────────────────────
        $serverDate = $now->format('Y-m-d'); // e.g. "2026-08-28"

        return view('dashboard', compact(
            'activeEmployees',
            'resignedEmployees',
            'blacklistedEmployees',
            'partTimeEmployees',
            'internshipEmployees',
            'newEmployees',
            'onTimeCount',
            'lateCount',
            'absentCount',
            'excusedCount',
            'offDayCount',
            'totalAttendance',
            'onTimePercent',
            'latePercent',
            'absentPercent',
            'excusedPercent',
            'offDayPercent',
            'trendDays',
            'trendValues',
            'overviewMonths',
            'overviewActive',
            'overviewNew',
            'overviewResigned',
            'activities',
            'birthdayEmployees',
            'upcomingEvents',
            'absentToday',
            'newThisMonth',
            'contractEnding',
            'selectedDate',
            'serverDate',
            'serverHour',
            'greeting',
            'trendPeriodLabel'
        ));
    }
}
