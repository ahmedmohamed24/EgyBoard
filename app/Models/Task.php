<?php

namespace App\Models;

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
    protected $touches = ['project'];
    public function path()
    {
        return "project/$this->project_id/task/$this->id";
    }
    public function project()
    {
        return  $this->belongsTo(\App\Models\Project::class,'project_id') ;
    
    }
    public function activity()
    {
        return $this->morphOne(Activity::class,'activityable');
    }
    /**
    * Undocumented function
    *
    * @param string $descriptoin
    * @return void
    */
    public function recordActivity(string $descriptoin)
    {
        Activity::create([
            'activityable_type'=>'Task',
            'activityable_id'=>$this->id,
            'description'=>$descriptoin,
        ]);  
    }
}
