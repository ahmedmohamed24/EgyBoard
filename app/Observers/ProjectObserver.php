<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $project->recordActivity('new project created');
    }
    /**
     * just before data is updating take an instance of them 
     *
     * @param Project $project
     * @return void
     */
    public function updating(Project $project)
    {
        $project->old=$project->getOriginal();
    }
    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $data=array_diff($project->getChanges(),$project->old);
        foreach($data as $key => $value){
            $after[$key]=$project->getChanges()[$key];
            $before[$key]=$project->old[$key];
        }

        unset($after['created_at']);
        unset($after['updated_at']);
        unset($before['updated_at']);
        unset($before['created_at']);
        $project->recordActivity('project updated',['before'=>$before,'after'=>$after]);
    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }
    
}
