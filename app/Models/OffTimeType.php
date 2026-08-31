<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OffTimeType extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'max_off_times',
        'interval_type',
        'superadmin_approval',
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
            'superadmin_approval' => 'boolean',
            'max_off_times' => 'integer',
        ];
    }

    /**
     * Get all off times associated with this type.
     *
     * @return HasMany<OffTime, $this>
     */
    public function offTimes(): HasMany
    {
        return $this->hasMany(OffTime::class);
    }

    /**
     * Scope query to search by name.
     *
     * @param  Builder<static>  $query
     */
    public function scopeSearch(Builder $query, ?string $search): void
    {
        if (! empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }
    }

    /**
     * Scope query to filter active off time types.
     *
     * @param  Builder<static>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'Active');
    }
}
