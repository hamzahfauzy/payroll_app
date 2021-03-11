<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Period
 *
 * @property $id
 * @property $name
 * @property $month
 * @property $year
 * @property $created_at
 * @property $updated_at
 *
 * @property EmployeePeriod[] $employeePeriods
 * @property EmployeeSallary[] $employeeSallaries
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Period extends Model
{
    
    static $rules = [
		'name' => 'required',
		'month' => 'required',
		'year' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','month','year'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeePeriods()
    {
        return $this->hasMany('App\Models\EmployeePeriod', 'period_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeSallaries()
    {
        return $this->hasMany('App\Models\EmployeeSallary', 'period_id', 'id');
    }
    

}
