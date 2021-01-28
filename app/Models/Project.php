<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * gets the path of a project may be on slug or id or anything else
     * @return string
     */
    public function path():string
    {
        return "/project/{$this->id}";
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class,'owner_id');
    }
    public function tasks(){
        return $this->hasMany(\App\Models\Task::class,'project_id');
    }
    public function addTask($body,$user=null){
        $this->tasks()->create(['body'=>$body,'owner_id'=>$user??auth()->id()]);
    }
}
