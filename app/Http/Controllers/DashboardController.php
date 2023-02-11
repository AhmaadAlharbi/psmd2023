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
        $pendingTasks = MainTask::where('department_id', Auth::user()->department_id)->where('status', 'pending')->get();
        $completedTasksCount = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->count();
        $completedTasks = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->get();
        return view('dashboard.index', compact('sectionTasksCount', 'pendingTasksCount', 'pendingTasks', 'completedTasksCount', 'completedTasks'));
    }
    public function add_task()
    {
        return view('dashboard.add_task');
    }
    public function engineerTaskPage($id)
    {
        $tasks = SectionTask::where('main_tasks_id', $id)->first();
        if (!$tasks) {
            abort(404);
        }
        return view('dashboard.engineerTaskPage', compact('tasks'));
    }
    public function submitEngineerReport(Request $request, $id)
    {
        $main_task = MainTask::findOrFail($id);
        $section_task = SectionTask::where('main_tasks_id', $id)->first();
        $main_task->update([
            'status' => 'completed',
        ]);
        SectionTask::create([
            'main_tasks_id' => $id,
            'department_id' => 2,
            'eng_id' => $section_task->eng_id,
            'action_take' => $request->action_take,
            'status' => 'completed',
            'engineer-notes' => $request->notes,
            'user_id' => Auth::user()->id,
            'previous_task_id' => null,
            'transfer_date_time' => null,
        ]);
        return redirect("/home");
    }
}
