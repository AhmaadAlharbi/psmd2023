<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionTask extends Model
{
    use HasFactory;
    protected $table = 'section_tasks';
    protected $guarded = [];

    public function main_task()
    {
        return $this->belongsTo(MainTask::class, 'main_tasks_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function engineer()
    {
        return $this->belongsTo(Engineer::class, 'eng_id');
        //goes to section task table and see the value of eng_id
    }
}