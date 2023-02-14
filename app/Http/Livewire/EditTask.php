<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Station;
use App\Models\Equip;
use App\Models\MainAlarm;
use App\Models\MainTask;
use App\Models\SectionTask;
use App\Models\Engineer;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class EditTask extends Component
{
    public $task;
    public $task_id;
    use WithFileUploads;
    public $stations = [];
    public $selectedStation;
    public $stationDetails;
    public $station_id;
    public $voltage = [];
    public $main_alarms = [];
    public $selectedVoltage;
    public $equip = [];
    public $selectedEquip;
    public $transformers = [];
    public $selectedTransformer;
    public $engineers = [];
    public $selectedEngineer;
    public $area;
    public $engineerEmail;
    public $duty = false;
    public $main_alarm = 1;
    public $work_type;
    public $date;
    public $problem;
    public $notes;
    public $photos = [];
    public $pic1;
    public $pic2;
    public $selectedEquipTr;
    public $route_id = 2;
    protected $listeners = ['callEngineer' => 'getEngineer'];

    public function __construct($task_id)
    {
        $this->task_id = $task_id;
    }

    public function mount()
    {
        $this->stations = Station::all();
        $this->main_alarms = MainAlarm::where('department_id', 2)->get();
        $this->task = MainTask::find($this->task_id);
        $this->selectedStation = $this->task->station->SSNAME;
        $this->station_id =  $this->task->station->id;
        $this->stationDetails = Station::where('id',  $this->task->station_id)->first();
        $this->main_alarm = $this->task->main_alarm->id;
        $this->selectedEngineer = $this->task->engineer->id;
        $this->area = Engineer::where('user_id', $this->task->eng_id)->value('area');
        $this->engineers = Engineer::where('department_id', 2)->where('area', $this->area)->get();
        $this->problem = $this->task->problem;
        $this->notes = $this->task->notes;
    }

    public function render()
    {
        return view('livewire.edit-task');
    }
    public function getStationInfo()
    {
        $this->engineers = [];
        $this->voltage = [];
        $this->transformers = [];
        $this->equip = [];
        $this->area = 1;
        $this->main_alarm = '';
        $this->engineerEmail = '';
        $this->selectedVoltage = '';
        $this->selectedEquip = '';
        $this->selectedEngineer = '';
        $this->stationDetails = Station::where('SSNAME', $this->selectedStation)->first();
        if ($this->stationDetails !== null) {
            $this->station_id = Station::where('SSNAME', $this->selectedStation)->pluck('id')->first();
            // $this->voltage = Equip::where('station_id', $this->station_id)->distinct()->pluck('voltage_level');

            if (
                $this->stationDetails->control === 'JAHRA CONTROL CENTER'
                || $this->stationDetails->control === 'TOWN CONTROL CENTER'
            ) {
                $this->area = 1;
            } elseif (
                $this->stationDetails->control === 'SHUAIBA CONTROL CENTER'
                || $this->stationDetails->control === 'JABRIYA CONTROL CENTER'
            ) {
                $this->area = 2;
            } else {
                $this->area = 3;
            }
            $this->emit('callEngineer', $this->area);
        }
    }
    public function getEquip()
    {
        $this->equip = [];
        if ($this->selectedVoltage !== '-1') {
            if (!isset($this->route_id)) {
                $this->voltage = [];
            }
            $this->station_id = Station::where('SSNAME', $this->selectedStation)->pluck('id')->first();
            switch ($this->main_alarm) {
                case ('General Alarm 11KV'):
                    $this->voltage = [];
                    array_push($this->voltage, "11KV");
                    $this->equip = Equip::where('station_id', $this->station_id)->where('voltage_level', $this->selectedVoltage)->get();

                    break;
                case ('Auto reclosure'):
                case ('Pilot Cable Fault Alarm'):
                case ('General Alarm 33KV'):
                    $this->voltage = [];
                    array_push($this->voltage, "33KV");
                    $this->equip = Equip::where('station_id', $this->station_id)->where('voltage_level', $this->selectedVoltage)->get();

                    break;
                case ('Dist Prot Main Alaram'):
                case ('Dist.Prot.Main B Alarm'):
                case ('Pilot cable Superv.Supply Fail Alarm'):
                case ('General Alarm 132KV'):
                    $this->voltage = [];
                    array_push($this->voltage, "132KV");
                    $this->equip = Equip::where('station_id', $this->station_id)->where('voltage_level', $this->selectedVoltage)->get();

                    break;
                case ('DC Supply 1 & 2 Fail Alarm'):
                    $this->voltage = [];
                    break;
                case ('General Alarm 300KV'):
                    $this->voltage = [];
                    array_push($this->voltage, "300KV");
                    $this->equip = Equip::where('station_id', $this->station_id)->where('voltage_level', $this->selectedVoltage)->get();

                    break;
                case ('B/Bar Protection Fail Alarm'):
                    $this->voltage = [];
                    array_push($this->voltage, "400KV", "300KV", "132KV", "33KV");
                    $this->equip = Equip::where('station_id', $this->station_id)->where('voltage_level', $this->selectedVoltage)->get();

                    break;
                case ('Transformer Clearance'):
                case ('Transformer out of step Alarm'):
                    $this->voltage = [];
                    $this->equip = [];
                    // $this->voltage = Equip::where('station_id', $this->station_id)->where('equip_name', 'LIKE', '%TR%')->distinct()->pluck('equip_name');
                    // $this->voltage = Equip::selectRaw('substr(equip_name,1,2)')->where('equip_name', 'LIKE', '%TR%')->distinct()->get();
                    $this->transformers = Equip::where('station_id', $this->station_id)->where('equip_name', 'LIKE', '%TR%')->distinct()->pluck('equip_name');
                    $this->equip = Equip::where('station_id', $this->station_id)->where('equip_name', $this->selectedVoltage)->distinct()->pluck('equip_number');
                    break;
                default:
                    $this->equip = [];
                    $this->voltage = Equip::where('station_id', $this->station_id)->distinct()->pluck('voltage_level');
                    $this->equip = Equip::where('station_id', $this->station_id)->where('voltage_level', $this->selectedVoltage)->get();
            }

            // $this->equip = Equip::where('station_id', $this->station_id)->where('voltage_level', $this->selectedVoltage)->get();

            // $this->equip = Equip::where('station_id', $this->station_id)->where('voltage_level', $this->selectedVoltage)->get();

        }
    }
    public function getEngineer()
    {
        if ($this->area == 3) {
            if ($this->duty === false) {
                $this->engineers = Engineer::where('department_id', 2)->where('shift', 0)->get();
            } else {
                $this->engineers = Engineer::where('department_id', 2)->where('shift', 1)->get();
            }
        } else {
            if ($this->duty === false) {
                $this->engineers = Engineer::where('department_id', 2)->where('area', $this->area)->where('shift', 0)->get();
            } else {
                $this->engineers = Engineer::where('department_id', 2)->where('area', $this->area)->where('shift', 1)->get();
            }
        }
    }
    public function getEmail()
    {
        $this->engineerEmail = User::where('id', $this->selectedEngineer)->pluck('email')->first();
    }
    public function update()
    {

        $this->task->update([
            'station_id' =>  $this->station_id,
            'date' => $this->date,
            'problem' => $this->problem,
            'notes' => $this->notes,
            'status' => 'pending',
            'department_id' => Auth::user()->department_id,
            'main_alarm_id' => $this->main_alarm,
            'user_id' => Auth::user()->id,
            'eng_id' => $this->selectedEngineer,
        ]);
        $main_task_id = $this->task->id;
        $section_task = SectionTask::create([
            'main_tasks_id' => $main_task_id,
            'department_id' => Auth::user()->department_id,
            'eng_id' => $this->selectedEngineer,
            'action_take' => null,
            'status' => 'update',
            'engineer-notes' => null,
            'user_id' => Auth::user()->id,
            'previous_task_id' => null,
            'transfer_date_time' => null,
        ]);

        session()->flash('success', 'تم التعديل بنجاح');

        return redirect("/home");
    }
}
