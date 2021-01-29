<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
