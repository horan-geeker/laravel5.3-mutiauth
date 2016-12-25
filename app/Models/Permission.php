<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_permissions');
    }
}
