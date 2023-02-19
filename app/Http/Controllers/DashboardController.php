<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Station;
use App\Models\MainAlarm;
use App\Models\Role;
use App\Models\MainTask;
use App\Models\TaskAttachment;
use App\Models\SectionTask;
use App\Models\Department;
use App\Models\Engineer;
use Carbon\Carbon;

class DashBoardController extends Controller
{

    public function index()
    {


        // return  $control = MainTask::find(1)->station->control;
        // return  $station = Station::find(1)->main_task;
        // return Role::find(2)->user;
        // return Auth::user()->role->title;
        $engineersCount = Engineer::where('department_id', Auth::user()->department_id)->count();
        $sectionTasksCount = MainTask::where('department_id', Auth::user()->department_id)->count();
        $pendingTasksCount = MainTask::where('department_id', Auth::user()->department_id)->where('status', 'pending')->count();
        $pendingTasks = MainTask::where('department_id', Auth::user()->department_id)->where('status', 'pending')->latest()->paginate(1, ['*'], 'page2');
        $completedTasksCount = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->count();
        $completedTasks = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->latest()->paginate(2, ['*'], 'page2');
        $mutualTasks = MainTask::where('previous_department_id', Auth::user()->department_id)->count();
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
        return view('dashboard.index', compact('sectionTasksCount', 'mutualTasks', 'pendingTasksCount', 'taskCounts', 'pendingTaskCounts', 'pendingTasks', 'completedTaskCounts', 'completedTasks', 'engineersCount', 'completedTasksCount'));
    }
    public function userIndex()
    {
        $pendingTasksCount = MainTask::where('eng_id', Auth::user()->id)->where('status', 'pending')->count();
        $pendingTasks = MainTask::where('eng_id', Auth::user()->id)->where('status', 'pending')->latest()->paginate(7, ['*'], 'page2');
        $completedTasksCount = SectionTask::where('eng_id', Auth::user()->id)->where('status', 'completed')->count();
        $completedTasks = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->latest()->paginate(7, ['*'], 'page2');
        $archiveCount = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->count();
        return view('dashboard.engineers.index', compact('pendingTasksCount', 'pendingTasks', 'completedTasksCount', 'completedTasks', 'archiveCount'));
    }
    public function add_task()
    {
        return view('dashboard.add_task');
    }
    public function engineerTaskPage($id)
    {
        $tasks = SectionTask::where('main_tasks_id', $id)->first();
        $files = TaskAttachment::where('main_tasks_id', $id)->get();
        if (!$tasks) {
            abort(404);
        }
        return view('dashboard.engineerTaskPage', compact('tasks', 'files'));
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
            'department_id' => Auth::user()->department_id,
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
        $files = TaskAttachment::where('main_tasks_id', $id)->get();

        if (!$section_task) {
            abort(404);
        }
        return view('dashboard.reportPage', compact('files', 'section_task'));
    }
    public function showTasks($status)
    {
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        $currentMonth = Carbon::now()->month;
        $isAdmin = Auth()->user()->role->title == 'Admin';

        $tasks = $isAdmin ? $this->getAdminTasks($status, $currentMonth) : $this->getEngineerTasks($status);

        return view('dashboard.showTasks', compact('tasks', 'stations', 'engineers'));
    }

    private function getAdminTasks($status, $currentMonth)
    {
        switch ($status) {
            case 'pending':
                return MainTask::where('department_id', Auth::user()->department_id)
                    ->where('status', 'pending')
                    ->whereMonth('created_at', $currentMonth)->latest()->paginate(6);

            case 'completed':
                return MainTask::where('department_id', Auth::user()->department_id)
                    ->where('status', 'completed')
                    ->whereMonth('created_at', $currentMonth)->latest()->paginate(6);

            case 'all':
                return MainTask::where('department_id', Auth::user()->department_id)
                    ->whereMonth('created_at', $currentMonth)->latest()->paginate(6);
            case 'mutual-tasks':
                return MainTask::where('previous_department_id', Auth::user()->department_id)
                    ->latest()->paginate(6);
            default:
                abort(403);
        }
    }

    private function getEngineerTasks($status)
    {
        switch ($status) {
            case 'pending':
                return MainTask::where('eng_id', Auth::user()->id)
                    ->where('status', 'pending')
                    ->paginate(6);
            case 'completed':
                return MainTask::where('eng_id', Auth::user()->id)
                    ->where('status', 'completed')
                    ->latest()->paginate(6);
            case 'all':
                return MainTask::where('eng_id', Auth::user()->id)
                    ->latest()->paginate(6);
            default:
                abort(403);
        }
    }

    public function searchStation(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        $station = Station::where('SSNAME', $request->station)->first();
        $tasks = MainTask::where('department_id', Auth::user()->department_id)
            ->where('station_id', $station->id)
            ->whereMonth('created_at', $currentMonth)->latest()->paginate(6);
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
            ->whereMonth('created_at', $currentMonth)->latest()->paginate(6);
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
        $tasks = SectionTask::where('department_id', Auth::user()->department_id)->where('status', 'completed')->paginate(6);
        return view('dashboard.archive', compact('tasks', 'stations', 'engineers'));
    }
    public function searchArchive(Request $request)
    {
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        $query = SectionTask::query();
        $query->where('department_id', Auth::user()->department_id)
            ->where('status', 'completed');

        if ($request->has('station_code') && !empty($request->station_code)) {
            $station = Station::where('SSNAME', $request->station_code)->pluck('id')->first();
            $query->whereHas('main_task', function ($query) use ($station) {
                $query->where('station_id', $station);
            });
        }
        if ($request->has('equip') && $request->equip !== -1  && !empty($request->equip) && $request->equip !== 'Please select Equip') {
            $equip = $request->equip;
            $query->whereHas('main_task', function ($query) use ($equip) {
                $query->where('equip_number', $equip);
            });
        }
        if ($request->has('engineer') && $request->engineer != ''  && !empty($request->engineer)) {
            $engineer = User::where('name', $request->engineer)->pluck('id')->first();
            dd($engineer);
            $query->where('eng_id', $engineer);
        }
        if ($request->has('task_Date') && $request->has('task_Date2')) {
            try {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('task_Date'))->format('Y-m-d');
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('task_Date2'))->format('Y-m-d');
                $query->whereBetween('date', [$startDate, $endDate]);
            } catch (\Exception $e) {
                // handle the error here
            }
        }
        $tasks = $query->paginate(6);
        return view('dashboard.archive', compact('tasks', 'stations', 'engineers'));
    }
}
