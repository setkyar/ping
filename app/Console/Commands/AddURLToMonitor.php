<?php

namespace App\Console\Commands;

use App\EndPoint;
use Illuminate\Console\Command;

class AddURLToMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:add-url-to-monitor
                                {url : URL to monitor}
                                {--frequency=1 : Frequnecy in minutes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add url to monitor.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('url');
        $frequency = $this->option('frequency');

        EndPoint::create([
            'uri' => $url,
            'frequency' => $frequency,
        ]);

        $this->info('Successfully added the URL to monitor.');

        $headers = ['URI', 'Frequency', 'Added At'];

        $endpoints = EndPoint::all(['uri', 'frequency', 'created_at'])->toArray();

        $this->table($headers, $endpoints);
    }
}
