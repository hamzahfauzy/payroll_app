<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sallary
 *
 * @property $id
 * @property $name
 * @property $sallary_type
 * @property $created_at
 * @property $updated_at
 *
 * @property EmployeeSallary[] $employeeSallaries
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Sallary extends Model
{
    
    static $rules = [
		'name' => 'required',
		'sallary_type' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','sallary_type'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeSallaries()
    {
        return $this->hasMany('App\Models\EmployeeSallary', 'sallary_id', 'id');
    }
    

}
