<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function activityable()
    {
        return $this->morphTo();
    }
    public function getOwner()
    {
        return $this->belongsTo(\App\Models\User::class, 'owner');
    }
}
