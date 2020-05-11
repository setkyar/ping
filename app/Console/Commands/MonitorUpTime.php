<?php

namespace App\Console\Commands;

use App\EndPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\ConnectionException;

class MonitorUpTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:monitor-up-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor endpont URLs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $endponts = EndPoint::all();

        foreach($endponts as $endpont)
        {
            if(!$endpont->isDue()) {
                continue;
            }

            $response = Http::get($endpont->uri);

            $endpont->statuses()->create([
                'status_code' => $response->status(),
            ]);
        }
    }
}
