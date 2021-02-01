<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait RecordActivity{
    public function getOwner():int
    {
        if(auth()->check())
            return auth()->id();
        else{
            $user=User::factory()->create();
            return $user->id;
        }
    }
    public function getData(Model $model):array{
        $info=array_diff($model->getChanges(),$model->old);
        foreach($info as $key => $value){
            $after[$key]=$model->getChanges()[$key];
            $before[$key]=$model->old[$key];
        }
        unset($after['created_at']);
        unset($after['updated_at']);
        unset($before['updated_at']);
        unset($before['created_at']);
        $data['after']=$after;
        $data['before']=$before;
        return $data;
    }
    public function activityCreate($model,$data,$description)
    {
            $model->activity()->create([
                'activitable_type'=>'Task',
                'owner'=>$this->getOwner(),
                'data'=>$data,
                'activitable_id'=>$model->id,
                'description'=>$description,
            ]);
    }
}