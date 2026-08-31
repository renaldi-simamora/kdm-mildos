<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OffTimeRequest extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'employee_id',
        'off_time_type_id',
        'department',
        'start_date',
        'end_date',
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
            'start_date' => 'date',
            'end_date' => 'date',
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
     * Get the off time category/type.
     *
     * @return BelongsTo<OffTimeType, $this>
     */
    public function offTimeType(): BelongsTo
    {
        return $this->belongsTo(OffTimeType::class, 'off_time_type_id');
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
                    ->orWhereHas('offTimeType', function (Builder $typeQuery) use ($search) {
                        $typeQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('reason', 'like', "%{$search}%");
            });
        }
    }
}
