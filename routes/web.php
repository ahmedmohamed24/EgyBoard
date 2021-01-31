<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    //project routes
    Route::post('/project', [App\Http\Controllers\ProjectsController::class,'store'])->name('project.store');
    Route::view('/project/create','projects.create' )->name('project.create');
    Route::get('/project', [App\Http\Controllers\ProjectsController::class,'index'])->name('project.all');
    Route::get('/project/{project}', [App\Http\Controllers\ProjectsController::class,'show'])->name('project.show');
    Route::get('/project/{project}/edit', [\App\Http\Controllers\ProjectsController::class,'edit'])->name('project.edit');
    Route::patch('/project/{project}',[\App\Http\Controllers\ProjectsController::class,'update'])->name('project.update'); 
    Route::patch('/project/{project}/notes',[\App\Http\Controllers\ProjectsController::class,'updateNotes'])->name('project.update.notes'); 
   
    //project tasks routes 
    Route::post('/project/{project}/task',[\App\Http\Controllers\TaskController::class,'store'])->name('task.create'); 
    Route::patch('/project/{project}/task/{task}',[\App\Http\Controllers\TaskController::class,'update'])->name('task.update'); 

    Route::get('/activity',[\App\Http\Controllers\ActivityController::class,'index'])->name('activity.index'); 
    Route::delete('/activity/{activity}',[\App\Http\Controllers\ActivityController::class,'destroy'])->name('activity.delete'); 

    Route::get('/home',function(){ return redirect()->route('project.all');});
    Route::get('/', function(){  return redirect()->route('project.all');})->name('home');
});
