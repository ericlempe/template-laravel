<?php

namespace App\Traits;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
    public function hasPermissionTo(string $key): bool
    {
        /** @var Collection $permissions */
        $permissions = Cache::get($this->getPermissionCacheKey(), $this->permissions);

        return $permissions->where('key', '=', $key)->isNotEmpty();
    }

    public function givePermissionTo(string $key): void
    {
        $this->permissions()->firstOrCreate(compact('key'));
        Cache::forget($this->getPermissionCacheKey());
        Cache::rememberForever($this->getPermissionCacheKey(), fn () => $this->permissions);
    }

    /**
    * @return string
    */
    public function getPermissionCacheKey(): string
    {
        return "user::{$this->id}::permissions";
    }
}
