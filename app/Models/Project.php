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

    public $old;
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
        return $this->belongsTo(User::class,'owner');
    }
    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class,'project')->latest('updated_at');
    }
    public function addTask($body,$user=null)
    {
        return $this->tasks()->create(['body'=>$body,'owner'=>$user??auth()->id(),'status'=>0]);
    }
    public function activity()
    {
        return $this->morphMany(Activity::class,'activitable');
    }
    /**
     *  recodrd activity when something is done 
     *
     * @return void
     */
    public function recordActivity(string $descriptoin,int $owner,array $data=null)
    {
        $this->activity()->create([
            'activitable_type'=>'Project',
            'owner'=>$owner,
            'data'=> $data,
            'activitable_id'=>$this->id,
            'description'=>$descriptoin,
        ]);  
    }
}
