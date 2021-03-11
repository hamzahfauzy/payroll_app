<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Allowance
 *
 * @property $id
 * @property $position_id
 * @property $name
 * @property $amount
 * @property $allowance_type
 * @property $created_at
 * @property $updated_at
 *
 * @property Position $position
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Allowance extends Model
{
    
    static $rules = [
		'position_id' => 'required',
		'name' => 'required',
		'amount' => 'required',
		'allowance_type' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['position_id','name','amount','allowance_type'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function position()
    {
        return $this->hasOne('App\Models\Position', 'id', 'position_id');
    }

    public function getAmountFormatAttribute()
    {
      $amount = number_format($this->amount);
      return $this->allowance_type == 'Fixed' ? 'Rp. '.$amount : $amount.' %';
    }
    

}
