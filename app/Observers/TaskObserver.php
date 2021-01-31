<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\Activity;

class TaskObserver
{
    
    /**
     * Handle the Task "created" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->recordActivity("new task created");
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
        if(array_key_exists('status',$task->getChanges())){
            //no need for recording data here 
            if(array_values($task->getChanges())[0])
                $task->recordActivity("task completed");
            else
                $task->recordActivity("task marked as in completed");
        }
        else{
            $data=array_diff($task->getChanges(),$task->old);
            foreach($data as $key => $value){
                $before[$key]=$task->old[$key];
                $after[$key]=$task->getChanges()[$key];
            }
            unset($after['created_at']);
            unset($after['updated_at']);
            unset($before['updated_at']);
            unset($before['created_at']);
            $task->recordActivity("task updated",['before'=>$before,'after'=>$after]);

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
