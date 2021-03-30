<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attendance
 *
 * @property $id
 * @property $name
 * @property $created_at
 * @property $updated_at
 *
 * @property EmployeeAttendance[] $employeeAttendances
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Attendance extends Model
{
    
    static $rules = [
		'name' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeAttendances()
    {
        return $this->hasMany('App\Models\EmployeeAttendance', 'attendance_id', 'id');
    }
    

}
