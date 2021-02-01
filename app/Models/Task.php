<?php

namespace App\Models;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['getProject'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];
    /**
     * old attributes that is used to log system
     */    
    public iterable $oldAttributes;

    /**
     * get the path of the task
     *
     * @return string 
     */
    public function path()
    {
        return "project/$this->project/task/$this->id";
    }
    /**
     * get the parent project of a given task
     * one project has many tasks
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getProject()
    {
        return $this->belongsTo(\App\Models\Project::class,'project') ;
    
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
