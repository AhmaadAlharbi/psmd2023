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


class AddTask extends Component
{
    use WithFileUploads;
    public $task;
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
    public $main_alarm;
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
    public function mount()
    {
        $this->stations = Station::all();
        $this->main_alarms = MainAlarm::where('department_id', 2)->get();
        return view('livewire.add-task');
    }
    public function render(Request $request)
    {
        return view('livewire.add-task');
    }
    public function getStationInfo()
    {
        $this->engineers = [];
        $this->voltage = [];
        $this->transformers = [];
        $this->equip = [];
        $this->area = 0;
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
    public function submit()
    {
        $this->date =  Carbon::now();
        $year = (new DateTime)->format("Y");
        $month = (new DateTime)->format("m");
        $day = (new DateTime)->format("d");
        $refNum = $year . "/" . $month . "/" . $day . '-' . rand(1, 10000);
        $main_task = MainTask::create([
            'refNum' => $refNum,
            'station_id' =>  $this->station_id,
            'date' => $this->date,
            'problem' => $this->problem,
            'notes' => $this->notes,
            'status' => 'pending',
            'department_id' => 2,
            'main_alarm_id' => $this->main_alarm,
            'user_id' => 1,
        ]);
        $main_task_id = MainTask::latest()->first()->id;
        $section_task = SectionTask::create([
            'main_tasks_id' => $main_task_id,
            'department_id' => 2,
            'eng_id' => $this->selectedEngineer,
            'action_take' => null,
            'status' => 'pending',
            'engineer-notes' => null,
            'user_id' => 1,
            'previous_task_id' => null,
            'transfer_date_time' => null,


        ]);
        return back();
    }
}
