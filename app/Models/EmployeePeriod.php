<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeePeriod
 *
 * @property $id
 * @property $employee_id
 * @property $period_id
 * @property $status
 * @property $payout_at
 * @property $created_at
 * @property $updated_at
 *
 * @property Employee $employee
 * @property Period $period
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EmployeePeriod extends Model
{

    static $rules = [
        'employee_id' => 'required',
        'period_id' => 'required',
        'status' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['employee_id', 'period_id', 'status', 'payout_at'];


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

    public function sallaries()
    {
        return $this->hasMany('App\Models\EmployeeSallary', 'period_id', 'period_id', 'employee_id', 'employee_id');
    }

    public function getPotonganAttribute()
    {
        $ref_potongan = Sallary::where('sallary_type', 'Potongan')->get()->pluck('id');
        return $this->sallaries()->whereIn('sallary_id', $ref_potongan)->sum('amount');
    }

    public function getBonusAttribute()
    {
        $ref_bonus = Sallary::where('sallary_type', 'Bonus')->get()->pluck('id');
        return $this->sallaries()->whereIn('sallary_id', $ref_bonus)->sum('amount');
    }

    public function getSallaryTotalAttribute()
    {
        $gaji_pokok = $this->employee->gaji_pokok;
        $biaya_jabatan = $this->employee->biaya_jabatan;
        $tunjangan = $this->employee->tunjangan;

        $potongan = $this->potongan;
        $bonus = $this->bonus;

        return $gaji_pokok + $tunjangan + $bonus - $potongan - $biaya_jabatan;
    }

    public function getSallaryTotalFormatAttribute()
    {
        return 'Rp. ' . number_format($this->sallary_total);
    }
}
