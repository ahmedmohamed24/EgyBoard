<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class,'project_id')->latest('updated_at');
    }
    public function addTask($body,$user=null)
    {
        return $this->tasks()->create(['body'=>$body,'owner_id'=>$user??auth()->id(),'status'=>0]);
    }
    public function activity()
    {
        return $this->morphMany(Activity::class,'activityable');
    }
    /**
     *  recodrd activity when something is done 
     *
     * @return void
     */
    public function recordActivity(string $descriptoin)
    {
        Activity::create([
            'activityable_type'=>'Project',
            'owner'=>auth()->id(),
            'activityable_id'=>$this->id,
            'description'=>$descriptoin,
        ]);  
    }
}
