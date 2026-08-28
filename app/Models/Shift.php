<?php

namespace App\Models;

use Database\Factories\ShiftFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    /** @use HasFactory<ShiftFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'department',
        'name',
        'start_time',
        'end_time',
        'early_tolerance_minutes',
        'late_tolerance_minutes',
        'status',
    ];

    /**
     * Search by name or department.
     *
     * @param  Builder<static>  $query
     */
    public function scopeSearch($query, ?string $search): void
    {
        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }
    }
}
