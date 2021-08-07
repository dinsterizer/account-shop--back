<?php

namespace App\Models;

use App\Casts\RulesCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Config extends Model implements Auditable
{
    use HasFactory,
        \OwenIt\Auditing\Auditable;


    protected $hidden = [
        'audits', #Contain history changes of this model
    ];

    protected $fillable = [
        'key',
        'data',
        'rules_of_data',
        'structure_description',
        'description',
        'public',
    ];

    protected $casts = [
        'data' => 'array',
        'rules_of_data' => RulesCast::class,
        'public' => 'boolean',
    ];

    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->creator_id = $query->creator_id ?? optional(auth()->user())->id;
            $query->latest_updater_id = $query->latest_updater_id ?? optional(auth()->user())->id;
        });

        static::updating(function ($query) {
            $query->latest_updater_id = $query->latest_updater_id ?? optional(auth()->user())->id;
        });
    }

    /**
     * Get user was created this model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get user was updated latest this model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function latestUpdater()
    {
        return $this->belongsTo(User::class, 'latest_updater_id');
    }
}