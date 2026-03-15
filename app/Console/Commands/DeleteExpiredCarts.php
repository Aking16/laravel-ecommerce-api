<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;

class DeleteExpiredCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete carts not updated in the last 1 hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Cart::where('updated_at', '<', now()->subHour())->delete();

        $this->info("Deleted {$count} expired carts.");

        return $this::SUCCESS;
    }
}
