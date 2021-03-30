<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeAttendance
 *
 * @property $id
 * @property $employee_id
 * @property $attendance_id
 * @property $period_id
 * @property $amount
 * @property $created_at
 * @property $updated_at
 *
 * @property Attendance $attendance
 * @property Employee $employee
 * @property Period $period
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EmployeeAttendance extends Model
{
    
    static $rules = [
		'employee_id' => 'required',
		'attendance_id' => 'required',
		'period_id' => 'required',
		'amount' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['employee_id','attendance_id','period_id','amount'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attendance()
    {
        return $this->hasOne('App\Models\Attendance', 'id', 'attendance_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function period()
    {
        return $this->hasOne('App\Models\Period', 'id', 'period_id');
    }
    

}
