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
    public $old;
    public function path()
    {
        return "project/$this->project/task/$this->id";
    }
    public function getProject()
    {
        return  $this->belongsTo(\App\Models\Project::class,'project') ;
    
    }
    public function activity()
    {
        return $this->morphMany(Activity::class,'activitable');
    }
    public function recordActivity(string $descriptoin,int $owner,array $data=null)
    {
        $this->activity()->create([
            'activitable_type'=>'Task',
            'owner'=>$owner,
            'data'=>$data,
            'activitable_id'=>$this->id,
            'description'=>$descriptoin,
        ]);  
    }
}
