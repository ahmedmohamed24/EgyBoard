<?php

namespace App\Models;

use App\Models\User;
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
     * old attributes to be used after update or delete
     */
    public iterable $oldAttributes;
    /**
     * gets the path of a project may be on slug or id or anything else
     * @return string
     */
    public function path():string
    {
        return "/project/{$this->id}";
    }
    /**
     * one user has many projects 
     * get the project owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function user()
    {
        return $this->belongsTo(User::class,'owner');
    }
    /**
     * one project has many tasks
     * get the tasks related to any project
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class,'project')->latest('updated_at');
    }
    /**
     * adding task to a project
     *
     * @param string $body
     * @param Model|null $user
     * @return  \Illuminate\Database\Eloquent\Model 
     */
    public function addTask($body,$user=null)
    {
        return $this->tasks()->create(['body'=>$body,'owner'=>$user??auth()->id(),'status'=>0]);
    }
    /**
     * polymorphic relation between model and activity
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class,'activitable');
    }
}
