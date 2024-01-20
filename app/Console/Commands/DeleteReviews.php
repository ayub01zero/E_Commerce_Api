<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Review;
use Carbon\Carbon;

class DeleteReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reviews:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete reviews after one week';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Delete reviews that are older than a week
        $weekAgo = Carbon::now()->subWeek();
        $deletedRows = Review::where('created_at', '<', $weekAgo)->delete();

        $this->info("Deleted {$deletedRows} reviews that were older than a week.");

        return 0;
        
    }
}
