<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function projects()
    {
        return $this->hasMany(Project::class,'owner_id')->orderBy('updated_at','desc');
    }
    public function tasks(){
        return $this->hasManyThrough(Task::class,Project::class,'owner_id','project_id','id','id');
    }
    public function activities()
    {
        return $this->hasMany(\App\Models\Activity::class, 'owner')->orderBy('updated_at','desc');
    }
}
