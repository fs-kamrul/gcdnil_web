<?php

namespace Modules\KamrulDashboard\Packages\Supports\Builders;

use Illuminate\Support\Facades\Auth;
use Modules\KamrulDashboard\Http\Models\User;

trait HasPermissions
{
    /**
     * @var string[]
     */
    protected $permissions = [];

    public function permission(string $permission): self
    {
        $this->permissions[] = $permission;

        return $this;
    }

    public function anyPermissions(array $permissions): self
    {
        $this->permissions = array_merge($this->permissions, $permissions);

        return $this;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function currentUserHasAnyPermissions(): bool
    {
        if (!Auth::guard()->user() instanceof User) {
            return true;
        }

        return empty($this->permissions) || collect($this->permissions)
                ->filter(function (string $permission) {
                    return Auth::guard()->user() instanceof User && Auth::guard()->user()->hasPermission($permission);
                })
                ->isNotEmpty();
    }
}
