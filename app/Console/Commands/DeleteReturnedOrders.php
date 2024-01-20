<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class DeleteReturnedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-returned';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete return orders that are older than 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::where('return_order', 1)->delete();
        $this->info('Return orders deleted.');
        return 0;
    }
}
