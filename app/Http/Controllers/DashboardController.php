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
use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function index()
    {
        // return $engineers = User::withCount(['mainTasks' => function ($query) {
        //     $query->where('status', 'completed');
        // }])->orderBy('main_tasks_count', 'desc')->take(5)->get();
        // return $eng = SectionTask::find(1);
        // return $eng->engineer->user->name;
        $engineersCount = Engineer::where('department_id', Auth::user()->department_id)->count();
        $sectionTasksCount = MainTask::where('department_id', Auth::user()->department_id)->count();
        $pendingTasksCount = MainTask::where('department_id', Auth::user()->department_id)->where('status', 'pending')->count();
        $pendingTasks = MainTask::where('department_id', Auth::user()->department_id)->where('status', 'pending')->latest()->get();
        $completedTasksCount = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->count();
        $completedTasks = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->latest()->get();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $taskCounts = [];
        $pendingTaskCounts = [];
        $completedTaskCounts = [];
        foreach ($months as $month) {
            $taskCounts[] = MainTask::where('department_id', Auth::user()->department_id)
                ->whereMonth('created_at', date('m', strtotime($month)))
                ->count();
            $pendingTaskCounts[] = MainTask::where('department_id', Auth::user()->department_id)
                ->whereMonth('created_at', date('m', strtotime($month)))
                ->where('status', 'pending')
                ->count();
            $completedTaskCounts[] = MainTask::where('department_id', Auth::user()->department_id)
                ->whereMonth('created_at', date('m', strtotime($month)))
                ->where('status', 'completed')
                ->count();
        }
        return view('dashboard.index', compact('sectionTasksCount', 'pendingTasksCount', 'taskCounts', 'pendingTaskCounts', 'pendingTasks', 'completedTaskCounts', 'completedTasks', 'engineersCount', 'completedTasksCount'));
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
    public function reportPage($id)
    {
        $section_task = SectionTask::where('main_tasks_id', $id)
            ->where('department_id', Auth::user()->department_id)
            ->where('status', 'completed')
            ->first();
        if (!$section_task) {
            abort(404);
        }
        return view('dashboard.reportPage', compact('section_task'));
    }
    public function showTasks($status)
    {
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        $currentMonth = Carbon::now()->month;
        switch ($status) {
            case 'pending':
                $tasks = MainTask::where('department_id', Auth::user()->department_id)
                    ->where('status', 'pending')
                    ->whereMonth('created_at', $currentMonth)->latest()->get();
                break;
            case 'completed':

                $tasks = MainTask::where('department_id', Auth::user()->department_id)
                    ->where('status', 'completed')
                    ->whereMonth('created_at', $currentMonth)->latest()->get();
                break;

            case 'all':
                $tasks = MainTask::where('department_id', Auth::user()->department_id)
                    ->whereMonth('created_at', $currentMonth)->latest()->get();
                break;
        }
        return view('dashboard.showTasks', compact('tasks', 'stations', 'engineers'));
    }
    public function searchStation(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        $station = Station::where('SSNAME', $request->station)->first();
        $tasks = MainTask::where('department_id', Auth::user()->department_id)
            ->where('station_id', $station->id)
            ->whereMonth('created_at', $currentMonth)->latest()->get();
        return view('dashboard.showTasks', compact('tasks', 'stations', 'engineers'));
    }
    public function engineerTasks(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        $engineer = User::where('name', $request->engineer)->first();;
        $tasks = MainTask::where('department_id', Auth::user()->department_id)
            ->where('eng_id', $engineer->id)
            ->whereMonth('created_at', $currentMonth)->latest()->latest()->get();
        return view('dashboard.showTasks', compact('tasks', 'stations', 'engineers'));
    }
    public function editTask($id)
    {
        $main_task = MainTask::findOrFail($id);
        $section_task = SectionTask::where('main_tasks_id', $id)->first();
        return view('dashboard.edit_task', compact('main_task', 'section_task'));
    }
    public function archive()
    {
        $currentMonth = Carbon::now()->month;
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        $tasks = MainTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->get();
        return view('dashboard.archive', compact('tasks', 'stations', 'engineers'));
    }
    public function searchArchive(Request $request)
    {
        return SectionTask::find(1)->main_task->station_id;
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        $query = SectionTask::query();
        $station = Station::where('SSNAME', $request->station_code)->pluck('id')->first();
        $engineer = User::where('name', $request->engineer_name)->pluck('id')->first();
        $stations = Station::all();
        $engineers =  Engineer::where('department_id', Auth::user()->department_id)->get();
        if ($request->has('station_code')) {
            $query->where('station_id', 'like', "%{$station}%")->where('department_id', Auth::user()->department_id)->where('status', 'completed');
        }
        if ($request->has('equip')) {
            $taskQuery = MainTask::where('equip_number', 'like', "%{$request->equip}%")
                ->select('id');

            $taskDetails = MainTask::whereIn('task_id', $taskQuery)
                ->where('status', 'completed')
                ->where('department_id', 2)
                ->get();
        }
        if ($request->has('engineer')) {
            $query->where('eng_id', 'like', "%{$engineer}%")->where('department_id', Auth::user()->department_id)->where('status', 'completed');;
        }

        if ($request->has('task_Date')) {
            $query->whereBetween('date', [$request->task_Date, $request->task_Date2])->where('department_id', Auth::user()->department_id)->where('status', 'completed');
        }

        return  $tasks = $query->get();


        return view('dashboard.archive', compact('tasks', 'stations', 'engineers'));
    }
}