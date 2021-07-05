<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ModelTraits\HelperForAccountAction;
use App\Models\Pivot\AccountAccountAction;
use OwenIt\Auditing\Contracts\Auditable;

class AccountAction extends Model implements Auditable
{
    use HasFactory,
        SoftDeletes,
        HelperForAccountAction,
        \OwenIt\Auditing\Auditable;

    /**
     * The attributes & relationships that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'audits', #Contain history changes of this model
    ];

    /**
     * Modify before store data changes in audit
     * Should add attributes in $hidden property above
     *
     * @var array
     * */
    protected $attributeModifiers = [];

    protected $fillable = [
        'order',
        'name',
        'slug',
        'description',
        'video_path',
        'required',
        'display_type',
        'account_type_id',
        'latest_updater_id',
        'creator_id',
    ];

    protected $casts = [
        'order' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'video_path' => 'string',
        'required' => 'boolean',
        'display_type' => 'integer',
        'account_type_id' => 'integer',
        'latest_updater_id' => 'integer',
        'creator_id' => 'integer',
    ];

    /**
     * To set default
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Custom
        static::creating(function ($query) {
            $query->creator_id = optional(auth()->user())->id;
            $query->latest_updater_id = optional(auth()->user())->id;
        });

        static::updating(function ($query) {
            $query->latest_updater_id = optional(auth()->user())->id;
        });
    }

    /**
     * Relationship one-one with User
     * Include infos of model creator
     *
     * @return void
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Relationship one-one with User
     * Include infos of editor last updated model
     *
     * @return void
     */
    public function latestUpdater()
    {
        return $this->belongsTo(User::class, 'latest_updater_id');
    }

    /**
     * Relationship many-many with Models\Role
     *
     * @return Illuminate\Database\Eloquent\Factories\Relationship
     */
    public function requiredRoles()
    {
        return $this->belongsToMany(Role::class, 'account_action_required_roles');
    }

    /**
     * Relationship many-on with App\Models\AccountType
     *
     * @return Illuminate\Database\Eloquent\Factories\Relationship
     */
    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    /**
     * Relationship many-many with App\Models\Account
     *
     * @return Illuminate\Database\Eloquent\Factories\Relationship
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_account_action')
            ->using(AccountAccountAction::class)
            ->withPivot('is_done')
            ->withTimestamps();
    }
}
