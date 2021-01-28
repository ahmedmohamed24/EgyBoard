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
   
    //project tasks routes 
    Route::post('/project/{project}/task',[\App\Http\Controllers\TaskController::class,'store'])->name('task.create'); 

    Route::get('/home',function(){ return redirect()->route('project.all');});
    Route::get('/', function(){  return redirect()->route('project.all');})->name('home');
});
