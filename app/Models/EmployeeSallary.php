<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeSallary
 *
 * @property $id
 * @property $employee_id
 * @property $sallary_id
 * @property $period_id
 * @property $amount
 * @property $created_at
 * @property $updated_at
 *
 * @property Employee $employee
 * @property Period $period
 * @property Sallary $sallary
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EmployeeSallary extends Model
{
    
    static $rules = [
		'employee_id' => 'required',
		'sallary_id' => 'required',
		'period_id' => 'required',
		'amount' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['employee_id','sallary_id','period_id','amount'];


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
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sallary()
    {
        return $this->hasOne('App\Models\Sallary', 'id', 'sallary_id');
    }
    

}
