<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

/**
 * @return BelongsToMany<User, $this>
 */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_has_roles',
            'id_role',
            'id_user'
        )->withTimestamps();
    }

/**
 * @return BelongsToMany<Permission, $this>
 */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'roles_has_permission',
            'id_role',
            'id_permission'
        )->withTimestamps();
    }
}