<?php

namespace App\Observers;

use App\Models\Task;
use App\Providers\RecordActivity;

class TaskObserver
{
    use RecordActivity;

    /**
     * Handle the Task "created" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $this->activityCreate($task,false,"new task created");
    }
    /**
     * before updating cache virsion to use in log
     *
     * @param Task $task
     * @return void
     */
    public function updating(Task $task)
    {
        $task->oldAttributes=$task->getOriginal();
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        //this id only for testing with factory but in live user couldn't get here unless he is auth
        if(array_key_exists('status',$task->getChanges()))
        {
            //no need for recording data here Only status is changed (request is sent per every change)
            if(array_values($task->getChanges())[0])
                $this->activityCreate($task,false,"task completed");
            else
                $this->activityCreate($task,false,"task marked as in completed");
        }
        else{
            $this->activityCreate($task,true,'project updated');
        }
    }
    
    /**
     * Handle the Task "deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
