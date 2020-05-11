<?php

namespace App;

use App\EndPoint;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status_code'];

    public function endpont()
    {
        return $this->belongsTo(EndPoint::class);
    }
}
