<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Notification;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Station;
use App\Models\Equip;
use App\Models\MainAlarm;
use App\Models\MainTask;
use App\Models\TaskAttachment;
use App\Models\SectionTask;
use App\Models\Engineer;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\TaskReport;

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
    public $departments = [];
    public $selectedDepartment;
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
        $this->selectedVoltage = $this->task->voltage_level;
        $this->work_type = $this->task->work_type;
        $this->main_alarm = optional($this->task->main_alarm)->id;
        $this->selectedEngineer = optional($this->task->engineer)->id;
        // $this->area = optional($this->task->engineer)->area ? $this->task->engineer->area : $this->setArea();
        $this->setArea();
        $this->getEmail();
        $this->engineers = Engineer::where('department_id', Auth::user()->department_id)->where('area', $this->area)->get();
        $this->problem = $this->task->problem;
        $this->notes = $this->task->notes;
        $this->voltage = Equip::where('station_id', $this->task->station->id)->distinct()->pluck('voltage_level');
        $this->selectedEquip = $this->task->equip_number;
        // $this->selectedTransformer = $this->task->equip_number;
        $this->departments = Department::where('name', '!=', Auth::user()->department->name)->get();
        $this->selectedDepartment =  $this->task->department_id;
        $this->equip = Equip::where('station_id', $this->task->station->id)->where('voltage_level', $this->selectedVoltage)->get();
    }

    public function render()
    {
        return view('livewire.edit-task');
    }
    public function getStationInfo()
    {
        // Reset all the properties to their default values.
        $this->resetProperties();

        // Find the Station with the selected name.
        $station = Station::where('SSNAME', $this->selectedStation)->first();

        // If the Station is not found, return.
        if ($station === null) {
            return;
        }

        // Set the details of the found Station.
        $this->setStationDetails($station);

        // Set the Area based on the Department of the authenticated User.
        $this->setArea();

        // Emit an event to call the Engineer selection function.
        $this->emit('callEngineer', $this->area);
    }

    // Reset all the properties to their default values.
    private function resetProperties()
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
    }

    // Set the details of the given Station.
    private function setStationDetails($station)
    {
        $this->stationDetails = $station;
        $this->station_id = $station->id;
    }

    // Set the Area based on the Department of the authenticated User.
    private function setArea()
    {
        switch (Auth::user()->department_id) {
            case 2:
                // Set the Area for Department 2.
                $this->setAreaForDeptTwo();
                break;
            case 5:
                // Set the Area for Department 5.
                $this->setAreaForDeptFive();
                break;
            default:
                $this->area = 1;
        }
    }

    // Set the Area for Department 2.
    private function setAreaForDeptTwo()
    {
        $controlCenter = $this->stationDetails->control;
        if ($controlCenter === 'JAHRA CONTROL CENTER' || $controlCenter === 'TOWN CONTROL CENTER') {
            $this->area = 1;
        } elseif ($controlCenter === 'SHUAIBA CONTROL CENTER' || $controlCenter === 'JABRIYA CONTROL CENTER') {
            $this->area = 2;
        } else {
            $this->area = 3;
        }
    }
    // Set the Area for Department 5.
    private function setAreaForDeptFive()
    {
        $controlCenter = $this->stationDetails->control;

        if ($controlCenter === 'JAHRA CONTROL CENTER' || $controlCenter === 'TOWN CONTROL CENTER') {
            $this->area = 1;
        } elseif ($controlCenter === 'SHUAIBA CONTROL CENTER') {
            $this->area = 2;
        } elseif ($controlCenter === 'JABRIYA CONTROL CENTER') {
            $this->area = 3;
        }
    }
    public function getEquip()
    {
        $this->equip = [];
        $this->transformers = [];
        $this->selectedEquip = ''; // Set equip_name to empty string
        $this->selectedTransformer = ''; // Set equip_name to empty string

        if ($this->selectedVoltage !== '-1') {

            $this->station_id = Station::where('SSNAME', $this->selectedStation)->pluck('id')->first();
            // dd($this->main_alarm);
            switch (MainAlarm::where('id', $this->main_alarm)->value('name')) {
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
                    // dd(MainAlarm::where('id', $this->main_alarm)->value('name'));
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
                $this->engineers = Engineer::where('department_id', Auth::user()->department_id)->where('shift', 0)->get();
            } else {
                $this->engineers = Engineer::where('department_id', Auth::user()->department_id)->where('shift', 1)->get();
            }
        } else {
            if ($this->duty === false) {
                $this->engineers = Engineer::where('department_id', Auth::user()->department_id)->where('area', $this->area)->where('shift', 0)->get();
            } else {
                $this->engineers = Engineer::where('department_id', Auth::user()->department_id)->where('area', $this->area)->where('shift', 1)->get();
            }
        }
    }
    public function getEmail()
    {
        $this->engineerEmail = User::where('id', $this->selectedEngineer)->pluck('email')->first();
    }

    public function update()
    {
        $date = Carbon::now();
        $equip_number = null; // Initialize the variable

        if (!empty($this->selectedEquip)) {
            // If selectedEquip is not empty, set $equip_number to the selected value
            $selectedEquipArr = explode(" - ", $this->selectedEquip);
            $equip_number = $selectedEquipArr[0];
        } elseif (!empty($this->selectedTransformer)) {
            // If selectedTransformer is not empty, set $equip_number to the selected value
            $equip_number = $this->selectedTransformer;
        }

        //check department
        if ($this->selectedDepartment !== Auth::user()->department_id) {
            $previous_department_id = Auth::user()->department_id;
            $this->selectedEngineer = null;
        } else {
            if ($this->task->previous_department_id) {
                $previous_department_id = $this->task->previous_department_id;
            } else {
                $previous_department_id = null;
            }
        }
        //cehck main alarm if it is empty or not before saving to db
        if ($this->main_alarm === '') {
            $this->main_alarm = null;
        }
        //check if engineer select is empty to set it null
        if ($this->selectedEngineer === '') {
            $this->selectedEngineer = null;
        }
        $this->task->update([
            'station_id' =>  $this->station_id,
            'voltage_level' => $this->selectedVoltage,
            'equip_number' => $equip_number,
            'problem' => $this->problem,
            'work_type' => $this->work_type,
            'notes' => $this->notes,
            'status' => 'pending',
            'department_id' => $this->selectedDepartment,
            'main_alarm_id' => $this->main_alarm,
            'user_id' => Auth::user()->id,
            'eng_id' => $this->selectedEngineer,
            'previous_department_id' => $previous_department_id,
        ]);
        $main_task_id = $this->task->id;
        $section_task = SectionTask::create([
            'main_tasks_id' => $main_task_id,
            'department_id' => Auth::user()->department_id,
            'eng_id' => $this->selectedEngineer,
            'date' => $date,
            'action_take' => null,
            'status' => 'update',
            'engineer-notes' => null,
            'user_id' => Auth::user()->id,
            'previous_department_id' => null,
            'transfer_date_time' => null,
        ]);
        foreach ($this->photos as $photo) {
            // $photo->store('photos');
            $name = $photo->getClientOriginalName();
            // $photo->storeAs('public', $name);
            $photo->storeAs('attachments/' . $main_task_id, $name, 'public');
            $attachments = new TaskAttachment();
            $attachments->main_tasks_id = $main_task_id;
            $attachments->department_id = Auth::user()->department_id;
            $attachments->file = $name;
            $attachments->user_id = Auth::user()->id;
            $attachments->save();
        }
        if ($this->selectedEngineer !== null) {
            $user = User::where('email', $this->engineerEmail)->first();
            Notification::send($user, new TaskReport($this->task, $this->photos));
        }
        session()->flash('success', '???? ?????????????? ??????????');

        return redirect("/dashboard/admin");
    }
}
