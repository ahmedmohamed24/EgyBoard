<?php
namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait RecordActivity{
    public function getOwner():int
    {
        if(auth()->check())
            return auth()->id();
        else{
            //hits this only while testing 
            $user=User::factory()->create();
            return $user->id;
        }
    }
    public function getData(Model $model):array{
        $info=array_diff($model->getChanges(),$model->oldAttributes);
        foreach($info as $key => $value){
            $after[$key]=$model->getChanges()[$key];
            $before[$key]=$model->oldAttributes[$key];
        }
        unset($after['created_at'],$after['updated_at'],$before['updated_at'],$before['created_at']);
        return ['before'=>$before,'after'=>$after];
    }
    public function activityCreate(Model $model,bool $isDataExists,string $description)
    {
            $model->activity()->create([
                'activitable_type'=>'Task',
                'owner'=>$this->getOwner(),
                'data'=>$isDataExists?$this->getData($model):null,
                'activitable_id'=>$model->id,
                'description'=>$description,
            ]);
    }
    
}