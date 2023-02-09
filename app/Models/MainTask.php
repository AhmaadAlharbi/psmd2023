<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainTask extends Model
{
    use HasFactory;
    protected $table = 'main_tasks';
    protected $guarded = [];

    public function section_tasks()
    {
        return $this->hasMany(SectionTask::class, 'main_tasks_id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }
    public function main_alarm()
    {
        return $this->belongsTo(MainAlarm::class, 'main_alarm_id');
    }
}
