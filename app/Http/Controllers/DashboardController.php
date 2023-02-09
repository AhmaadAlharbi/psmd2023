<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Station;
use App\Models\MainAlarm;
use App\Models\MainTask;
use App\Models\SectionTask;
use App\Models\Department;
use App\Models\Engineer;

class DashBoardController extends Controller
{
    public function index()
    {
        // $eng = SectionTask::find(1);
        // return $eng->engineer->user->name;
        $sectionTasksCount = MainTask::where('department_id', Auth::user()->department_id)->count();
        $pendingTasksCount = MainTask::where('department_id', Auth::user()->department_id)->where('status', 'pending')->count();
        $pendingTasks = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'pending')->get();
        $completedTasksCount = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->count();
        $completedTasks = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->get();
        return view('dashboard.index', compact('sectionTasksCount', 'pendingTasksCount', 'pendingTasks', 'completedTasksCount', 'completedTasks'));
    }
}
