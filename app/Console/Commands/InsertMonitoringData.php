<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Mail\WarningNotification;
use Illuminate\Support\Facades\DB;
use App\Services\MonitoringService;
use Illuminate\Support\Facades\Mail;

class InsertMonitoringData extends Command
{
    protected $signature = 'insert:monitoringdata';
    protected $description = 'Insert monitoring data and generate conditions';

    protected $monitoringService;

    public function __construct(MonitoringService $monitoringService)
    {
        parent::__construct();
        $this->monitoringService = $monitoringService;
    }

    public function handle()
    {
        $result = $this->monitoringService->insertMonitoringData();

        if ($result['status'] == 'error') {
            $this->error($result['message']);
        } else {
            $this->info($result['message']);
        }
    }
}