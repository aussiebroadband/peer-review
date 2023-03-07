<?php

namespace App\Console\Commands;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Services\NbnApiService;
use Illuminate\Console\Command;

class ProcessApplications extends Command
{
    protected $signature = 'nbn:process-apps';

    protected $description = 'Process apps';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $nbnApi = new NbnApiService(env('NBN_PORTAL_API_KEY'));

        foreach (Application::all() as $app) {
            $plan = $app->plan;

            if (!$app->nbn_order_id) {
                try {
                    $order = $nbnApi->submitOrders($app->id, $plan, $app->address)->json();

                    $app->update([
                        'nbn_order_id' => $order->id,
                        'status' => 'ordered'
                    ]);
                } catch (\Exception $e) {
                    $app->update([
                        'status' => ApplicationStatus::error()
                    ]);
                }

                continue;
            }

            if (ApplicationStatus::make($app->status)->value === ApplicationStatus::ordered()->value) {
                $o = $nbnApi->retrieveOrder($app->nbn_order_id)->json();

                if($o->status == 'success') {
                    $app->update([
                        'status' => ApplicationStatus::completed()
                    ]);
                }
            }
        }
    }
}
