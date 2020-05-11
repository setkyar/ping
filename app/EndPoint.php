<?php

namespace App;

use App\Status;
use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Database\Eloquent\Model;

class EndPoint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uri', 'frequency'];

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function isDue() : bool
    {
        $expression = "*/{$this->frequency} * * * *";

        return CronExpression::factory($expression)->isDue(Carbon::now());
    }
}
