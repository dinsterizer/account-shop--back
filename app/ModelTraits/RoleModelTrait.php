<?php

namespace App\ModelTraits;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

trait RoleModelTrait
{


    /**
     * -------------------------------------------------------------------------------------------
     * -------------------------------------------------------------------------------------------
     * -------------------------------------------------------------------------------------------
     * -------------------------------------------------------------------------------------------
     * -------------------------------------------------------------------------------------------
     * DIRECT PERMISSION FROM ROLE
     *
     */

    /**
     * Determine whether role has a permission
     *
     * @return boolean
     */
    public function hasPermissionTo($permission)
    {
        if (!$permission instanceof Permission) {
            $permission = Permission::find($permission);
        }

        if (is_null($permission)) {
            return false;
        }

        $userPermissions = $this->_getRolePermissions();
        if ($userPermissions->contains($permission)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether role has one of these permissions
     *
     * @return boolean
     */
    public function hasAnyPermission(...$permissions)
    {
        if (is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermissionTo($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether role has these all permissions
     *
     * @return boolean
     */
    public function hasAllPermissions(...$permissions)
    {
        if (is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermissionTo($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * give for role a permission or many permission
     *
     * @return void
     */
    public function givePermissionTo(...$permissions)
    {
        if (is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        foreach ($permissions as $permission) {
            $this->_attachPermission($permission);
        }

        return true;
    }

    /**
     * revoke these permission form role
     *
     * @return void
     */
    public function revokePermissionTo(...$permissions)
    {
        if (is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        foreach ($permissions as $permission) {
            $this->_detachPermission($permission);
        }

        return true;
    }

    /**
     * Sync these permission form role
     *
     * @return void
     */
    public function syncPermissions(...$permissions)
    {
        return $this->_syncPermissions($permissions);
    }

    /**
     * Return list permission role has
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function _getRolePermissions()
    {
        return $this->permissions;
    }

    /**
     * attach a permission form role
     *
     * @return void
     */
    public function _attachPermission($permission)
    {
        if (!($permission instanceof Permission)) {
            if (is_string($permission) || is_numeric($permission)) {
                $permission = Permission::find($permission);
            } else {
                return false;
            }
        }

        if (is_null($permission)) {
            return false;
        }

        $userPermissions = $this->permissions;
        if ($userPermissions->contains($permission)) {
            return true;
        }

        return $this->permissions()->attach($permission);
    }

    /**
     * Detach a permission form user
     *
     * @return boolean
     */
    protected function _detachPermission($permission)
    {
        if (!($permission instanceof Permission)) {
            if (is_string($permission) || is_numeric($permission)) {
                $permission = Permission::find($permission);
            } else {
                return false;
            }
        }

        if (is_null($permission)) {
            return true;
        }

        $userPermissions = $this->permissions;
        if (!$userPermissions->contains($permission)) {
            return true;
        }

        return $this->permissions()->detach($permission);
    }

    /**
     * Sync permissions form user
     *
     * @return boolean
     */
    protected function _syncPermissions(...$permissions)
    {
        if (is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        foreach ($permissions as $key => $per) {
            if (!($per instanceof Permission)) {
                if (is_string($per) || is_numeric($per)) {
                    $per = Permission::find($per);
                } else {
                    break;
                }
            }

            if (is_null($per)) {
                break;
            } else {
                $permissions[$key] = $per;
            }
        }

        return $this->permissions()->sync($permissions);
    }
}
