<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function engineer()
    // {
    //     return $this->hasOne(Engineer::class, 'user_id');
    // }
    public function sectionTasks()
    {
        return $this->hasMany(SectionTask::class, 'by_user');
    }
    public function maintasks()
    {
        return $this->hasMany(MainTask::class, 'by_user', 'id');
    }
    public function engineer()
    {
        return $this->belongsTo(Engineer::class, 'eng_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
