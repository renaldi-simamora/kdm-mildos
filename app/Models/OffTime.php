<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OffTime extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'employee_id',
        'off_time_type_id',
        'approver_id',
        'location',
        'recurrence_type',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Get the employee that requested the off time.
     *
     * @return BelongsTo<Employee, $this>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the category / type of the off time.
     *
     * @return BelongsTo<OffTimeType, $this>
     */
    public function offTimeType(): BelongsTo
    {
        return $this->belongsTo(OffTimeType::class, 'off_time_type_id');
    }

    /**
     * Get the user who approved / processed the off time.
     *
     * @return BelongsTo<User, $this>
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * Scope query to search by employee name or reason.
     *
     * @param  Builder<static>  $query
     */
    public function scopeSearch(Builder $query, ?string $search): void
    {
        if (! empty($search)) {
            $query->where(function (Builder $q) use ($search) {
                $q->whereHas('employee', function (Builder $empQuery) use ($search) {
                    $empQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('employee_code', 'like', "%{$search}%");
                })
                    ->orWhereHas('offTimeType', function (Builder $typeQuery) use ($search) {
                        $typeQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('reason', 'like', "%{$search}%");
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
}
