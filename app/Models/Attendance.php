<?php

namespace App\Models;

use Database\Factories\AttendanceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    /** @use HasFactory<AttendanceFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'employee_id',
        'employee_name',
        'location',
        'shift',
        'date',
        'status',
        'clock_in',
        'clock_out',
        'check_in_time',
        'check_out_time',
        'notes',
        'overtime_hours',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'clock_in' => 'datetime',
            'clock_out' => 'datetime',
            'overtime_hours' => 'integer',
        ];
    }

    /**
     * Get the employee of this attendance record.
     *
     * @return BelongsTo<Employee, $this>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Scope query to search by employee name or code.
     *
     * @param  Builder<static>  $query
     */
    public function scopeSearch(Builder $query, ?string $search): void
    {
        if (! empty($search)) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('shift', 'like', "%{$search}%")
                    ->orWhereHas('employee', function (Builder $empQuery) use ($search) {
                        $empQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('employee_code', 'like', "%{$search}%")
                            ->orWhere('department', 'like', "%{$search}%");
                    });
            });
        }
    }

    /**
     * Scope query by status.
     *
     * @param  Builder<static>  $query
     */
    public function scopeFilterStatus(Builder $query, ?string $status): void
    {
        if (! empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }
    }

    /**
     * Scope query by location.
     *
     * @param  Builder<static>  $query
     */
    public function scopeFilterLocation(Builder $query, ?string $location): void
    {
        if (! empty($location) && $location !== 'all') {
            $query->where('location', $location);
        }
    }

    /**
     * Scope query by date range.
     *
     * @param  Builder<static>  $query
     */
    public function scopeFilterDate(Builder $query, ?string $dateFrom, ?string $dateTo = null): void
    {
        if (! empty($dateFrom) && ! empty($dateTo)) {
            $query->whereBetween('date', [$dateFrom, $dateTo]);
        } elseif (! empty($dateFrom)) {
            $query->whereDate('date', $dateFrom);
        }
    }
}
