<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRequest extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'employee_id',
        'request_date',
        'clock_in',
        'clock_out',
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
     * Get the employee associated with the request.
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
                $q->whereHas('employee', function (Builder $empQuery) use ($search) {
                    $empQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('employee_code', 'like', "%{$search}%");
                })
                    ->orWhere('reason', 'like', "%{$search}%");
            });
        }
    }
}
