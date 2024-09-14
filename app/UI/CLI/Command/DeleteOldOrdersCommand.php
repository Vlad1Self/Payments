<?php

namespace App\UI\CLI\Command;

use App\Domain\Models\Order\Order;
use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use Illuminate\Console\Command;

class DeleteOldOrdersCommand extends Command
{
    protected $signature = 'app:delete-orders';

    public function handle(): void
    {
        $this->info('Deleting old orders');

        $orders = Order::query()
            ->where('status', PayableStatusEnum::new)
            ->where('created_at', '<', now()->subDays())
            ->get();

        foreach ($orders as $order) {
            $order->delete();
        }

        $this->info('Done');
    }
}
