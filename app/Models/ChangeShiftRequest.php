<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChangeShiftRequest extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'employee_id',
        'delegate_employee_id',
        'shift_id',
        'shift_to',
        'request_date',
        'requested_at',
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
            'request_date' => 'date',
            'requested_at' => 'datetime',
        ];
    }

    /**
     * Get the employee requesting shift change.
     *
     * @return BelongsTo<Employee, $this>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the delegate employee.
     *
     * @return BelongsTo<Employee, $this>
     */
    public function delegateEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'delegate_employee_id');
    }

    /**
     * Get the shift.
     *
     * @return BelongsTo<Shift, $this>
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Scope query to search.
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
                    ->orWhereHas('delegateEmployee', function (Builder $delQuery) use ($search) {
                        $delQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('employee_code', 'like', "%{$search}%");
                    })
                    ->orWhere('shift_to', 'like', "%{$search}%")
                    ->orWhere('reason', 'like', "%{$search}%");
            });
        }
    }
}
