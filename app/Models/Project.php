<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    const STATUS = [
        'non-active' => 0,
        'active' => 1
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function year()
    {
        return $this->hasOne(Year::class, 'id', 'year_id');
    }

    public function major()
    {
        return $this->hasOne(Major::class, 'id', 'major_id');
    }

    public function projectUsers()
    {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id');
    }

    public function lecture()
    {
        return $this->hasOne(Lecture::class, 'id', 'lecture_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'project_id', 'id');
    }

    public function projectSupervisors()
    {
        return $this->hasMany(ProjectSupervisor::class, 'project_id', 'id');
    }

    public function thumb()
    {
        return $this->hasOne(Image::class, 'project_id', 'id');
    }

    public function getCreatedAtAttribute($value) {
        if (!empty($value))
            return $this->attributes['created_at'] = Carbon::parse($value)->format('d/M/Y H:i:s');
    }

    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeStatus($query, $value)
    {
        return $query->where('status', $value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopeSemester($query, $value)
    {
        return $query->where('semester_id', $value);
    }
}
