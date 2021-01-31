<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    public function index()
    {
        $activities=auth()->user()->activities;
        return view('activity.index',compact('activities'));
    }
    public function destroy(Activity $activity)
    {
        $this->authorize('deleteActivity',$activity);
        $activity->delete();
        return back()->with('msg','deleted successfully');
    }
}
