<?php

namespace App\Models;

use Database\Factories\FaceEnrollmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceEnrollment extends Model
{
    /** @use HasFactory<FaceEnrollmentFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'department',
        'employee_name',
        'status',
        'notes',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function scopeFilterStatus($query, ?string $status)
    {
        if (! empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        return $query;
    }
}
