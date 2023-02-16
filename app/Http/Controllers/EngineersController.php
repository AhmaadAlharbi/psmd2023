<?php

namespace App\Http\Controllers;

use App\Models\Engineer;
use Illuminate\Support\Facades\Auth;
use App\Models\MainTask;
use App\Models\Station;
use App\Models\User;
use App\Models\SectionTask;
use Illuminate\Http\Request;
use PDO;

class EngineersController extends Controller
{
    public function engineersList()
    {
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        return view('dashboard.engineers.engineersList', compact('engineers'));
    }
    public function engineerProfile($id)
    {
        $engineer = User::findOrfail($id);
        $tasks = MainTask::where('department_id', Auth::user()->department_id)->where('eng_id', $id)->count();
        $pendingTasks = MainTask::where('department_id', Auth::user()->department_id)->where('eng_id', $id)->where('status', 'pending')->count();
        $completedTasks = MainTask::where('department_id', Auth::user()->department_id)->where('eng_id', $id)->where('status', 'pending')->count();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $taskCounts = [];
        $pendingTaskCounts = [];
        $completedTaskCounts = [];

        foreach ($months as $month) {
            $taskCounts[] = MainTask::where('department_id', Auth::user()->department_id)
                ->where('eng_id', $id)
                ->whereMonth('created_at', date('m', strtotime($month)))
                ->count();

            $pendingTaskCounts[] = MainTask::where('department_id', Auth::user()->department_id)
                ->where('eng_id', $id)
                ->whereMonth('created_at', date('m', strtotime($month)))
                ->where('status', 'pending')
                ->count();

            $completedTaskCounts[] = MainTask::where('department_id', Auth::user()->department_id)
                ->where('eng_id', $id)
                ->whereMonth('created_at', date('m', strtotime($month)))
                ->where('status', 'completed')
                ->count();
        }
        return view('dashboard.engineers.profile', compact('tasks', 'pendingTasks', 'completedTasks', 'months', 'taskCounts', 'pendingTaskCounts', 'completedTaskCounts', 'engineer', 'months', 'taskCounts', 'pendingTaskCounts', 'completedTaskCounts'));
    }
    public function engineerTask($id, $status)
    {
        $stations = Station::all();
        $engineers = Engineer::where('department_id', Auth::user()->department_id)->get();
        switch ($status) {
            case 'pending':
                $tasks = MainTask::where('department_id', Auth::user()->department_id)
                    ->where('status', 'pending')
                    ->where('eng_id', $id)
                    ->latest()
                    ->paginate(6);
                break;
            case 'completed':
                $tasks = MainTask::where('department_id', Auth::user()->department_id)
                    ->where('status', 'completed')
                    ->where('eng_id', $id)
                    ->latest()
                    ->paginate(6);
                break;

            case 'all':
                $tasks = MainTask::where('department_id', Auth::user()->department_id)
                    ->where('eng_id', $id)
                    ->latest()
                    ->paginate(6);
                break;
            default:
                abort(404);
        }
        return view('dashboard.showTasks', compact('tasks', 'stations', 'engineers'));
    }
    public function edit($id)
    {
        $engineer = Engineer::findOrFail($id);
        return view('dashboard.engineers.edit', compact('engineer'));
    }
    public function update(Request $request, $id)
    {
        $engineer = Engineer::findOrFail($id);
        $area = $request->area;
        $shift = $request->shift;
        $engineer->update([
            'area' => $area,
            'shift' => $shift
        ]);
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('dashboard.engineersList');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
