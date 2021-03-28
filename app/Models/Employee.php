<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 *
 * @property $id
 * @property $user_id
 * @property $position_id
 * @property $NIK
 * @property $NPWP
 * @property $name
 * @property $work_around
 * @property $bank_account
 * @property $created_at
 * @property $updated_at
 *
 * @property EmployeePeriod[] $employeePeriods
 * @property EmployeeSallary[] $employeeSallaries
 * @property Position $position
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Employee extends Model
{

    static $rules = [
        'position_id' => 'required',
        'NIK' => 'required|unique:employees',
        'name' => 'required',
        'work_around' => 'required',
        'main_sallary' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'position_id', 'NIK', 'NPWP', 'name', 'work_around', 'bank_account', 'main_sallary'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeePeriods()
    {
        return $this->hasMany('App\Models\EmployeePeriod', 'employee_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeSallaries()
    {
        return $this->hasMany('App\Models\EmployeeSallary', 'employee_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function position()
    {
        return $this->hasOne('App\Models\Position', 'id', 'position_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    function getGajiPokokAttribute()
    {
        return $this->position->sallary+$this->main_sallary;
    }

    function getBiayaJabatanAttribute()
    {
        return $this->position->cost;
    }

    function getTunjanganAttribute()
    {
        $ref_tunjangan = $this->position->allowances;
        $tunjangan = 0;
        foreach ($ref_tunjangan as $t) {
            if ($t->allowance_type == 'Percent')
                $tunjangan += $this->gaji_pokok * $t->amount / 100;
            else
                $tunjangan += $t->amount;
        }

        return $tunjangan;
    }
}
