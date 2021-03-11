<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Position
 *
 * @property $id
 * @property $name
 * @property $sallary
 * @property $cost
 * @property $created_at
 * @property $updated_at
 *
 * @property Allowance[] $allowances
 * @property Employee[] $employees
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Position extends Model
{
    
    static $rules = [
		'name' => 'required',
		'sallary' => 'required',
		'cost' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','sallary','cost'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allowances()
    {
        return $this->hasMany('App\Models\Allowance', 'position_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany('App\Models\Employee', 'position_id', 'id');
    }

    public function getSallaryFormatAttribute()
    {
        return 'Rp. '.number_format($this->sallary);
    }

    public function getCostFormatAttribute()
    {
        return 'Rp. '.number_format($this->cost);
    }
    

}
