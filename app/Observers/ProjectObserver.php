<?php

namespace App\Observers;

use App\Models\Project;
use App\Traits\RecordActivity;

class ProjectObserver
{
    use RecordActivity;
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $this->activityCreate($project,null,'new project created');
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
        $data=$this->getData($project); 
        $this->activityCreate($project,['before'=>$data['before'],'after'=>$data['after']],'new project created');
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
