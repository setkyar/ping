<?php

namespace App\Console\Commands;

use App\EndPoint;
use Illuminate\Console\Command;

class CheckUpTimeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:check-uptime-status
                                {end_point_id : End point ID to check for the status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check uptime status by ID.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $endPointId = $this->argument('end_point_id');

        $endPoint = EndPoint::with('statuses')
                        ->find($endPointId);

        if(is_null($endPoint)) {
            $this->error("There is no endpoint id {$endPointId}.");

            return;
        }

        if($endPoint->statuses->isEmpty()) {
            $this->error("There is no statuses for this endpoint id {$endPointId}.");

            return;
        }

        $headers = ['ID', 'URI', 'Frequency', 'Status Code', 'Checked Time'];

        $statuses = $this->getEndPointStatues($endPoint);

        $this->table($headers, $statuses);
    }

    private function getEndPointStatues($endPoint)
    {
        $endPointData = [
            'id' => $endPoint->id,
            'URI' => $endPoint->uri,
            'Frequency' => $endPoint->frequency,
        ];

        return $endPoint->statuses
            ->map(function($status) use ($endPointData) {
            $statusData = [
                $status->status_code,
                $status->created_at->diffForHumans(),
            ];

            return array_merge($endPointData, $statusData);
            });
    }
}
