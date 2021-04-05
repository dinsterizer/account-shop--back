<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;
use App\ModelTraits\ManageRoleInAccountType;

class AccountType extends Model
{
    use HasFactory, SoftDeletes, ManageRoleInAccountType;

    protected $fillable = [
        'order',
        'name',
        'slug',
        'description',
        'game_id',
        'last_updated_editor_id',
        'creator_id'
    ];

    protected $casts = [
        'order' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'game_id' => 'integer',
        'last_updated_editor_id' => 'integer',
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
            $query->creator_id = auth()->user()->id;
            $query->last_updated_editor_id = auth()->user()->id;
        });

        static::updating(function ($query) {
            $query->last_updated_editor_id = auth()->user()->id;
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
    public function lastUpdatedEditor()
    {
        return $this->belongsTo(User::class, 'last_updated_editor_id');
    }

    /**
     * Relationship one-one with Models\AccountInfo
     *
     * @return Illuminate\Database\Eloquent\Factories\Relationship
     */
    public function accountInfos()
    {
        return $this->hasMany(AccountInfo::class);
    }

    /**
     * Include account infos model user must filling to create game
     * Relationship many-many with Models\Role
     *
     * @param  mixed $game
     * @return App\Models\AccountInfo
     */
    public function currentRoleNeedFillingAccountInfos()
    {
        $result = new Collection;

        if (!auth()->check()) {
            return $result;
        }

        foreach (auth()->user()->roles as $role) {
            $accountInfos = $role->belongsToMany(AccountInfo::class, 'role_need_filling_account_info')
                ->where('account_type_id', $this->id)
                ->get();

            foreach ($accountInfos as $accountInfo) {
                if (!$result->contains($accountInfo)) {
                    $result->push($accountInfo);
                }
            }
        }
        return $result;
    }

    /**
     * Relationship one-one with Models\AccountAction
     *
     * @return Illuminate\Database\Eloquent\Factories\Relationship
     */
    public function accountActions()
    {
        return $this->hasMany(AccountAction::class);
    }

    /**
     * Include account Actions model, user need performing to create game
     * Relationship many-many with Models\Role
     *
     * @param  mixed $game
     * @return App\Models\AccountAction
     */
    public function  currentRoleNeedPerformingAccountActions()
    {
        $result = new Collection;

        if (!auth()->check()) {
            return $result;
        }

        foreach (auth()->user()->roles as $role) {
            $accountActions = $role->belongsToMany(AccountAction::class, 'role_need_performing_account_action')
                ->where('account_type_id', $this->id)
                ->get();

            foreach ($accountActions as $accountAction) {
                if (!$result->contains($accountAction)) {
                    $result->push($accountAction);
                }
            }
        }
        return $result;
    }

    /**
     * Relationship many-many with Models\Role
     *
     * @return Illuminate\Database\Eloquent\Factories\Relationship
     */
    public function rolesCanUsedAccountType()
    {
        return $this->belongsToMany(Role::class, 'role_can_used_account_type')
            ->withPivot('status_code');
    }
}
