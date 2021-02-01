<?php

namespace App\Observers;

use App\Models\Task;
use App\Traits\RecordActivity;

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
        $this->activityCreate($task,null,"new task created");
    }
    /**
     * before updating cache virsion to use in log
     *
     * @param Task $task
     * @return void
     */
    public function updating(Task $task)
    {
        $task->old=$task->getOriginal();
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
                $this->activityCreate($task,null,"task completed");
            else
                $this->activityCreate($task,null,"task marked as in completed");
        }
        else{
            $data=$this->getData($task);
            $this->activityCreate($task,['before'=>$data['before'],'after'=>$data['after']],'project updated');
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
