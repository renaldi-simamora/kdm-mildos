<?php

namespace App\Models;

use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'birth_date',
        'job_title',
        'department',
        'location',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function faceEnrollments()
    {
        return $this->hasMany(FaceEnrollment::class);
    }

    public function offTimes()
    {
        return $this->hasMany(OffTime::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('employee_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
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

    public function scopeFilterDepartment($query, ?string $department)
    {
        if (! empty($department) && $department !== 'all') {
            $query->where('department', $department);
        }

        return $query;
    }
}
