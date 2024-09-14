<?php

namespace App\UI\CLI\Command;

use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use App\Domain\Models\Subscription\Subscription;
use Illuminate\Console\Command;

class DeleteOldSubscriptionCommand extends Command
{
    protected $signature = 'app:delete-subscription';

    public function handle()
    {
        $this->info('Deleting old subscriptions');

        $subscriptions = Subscription::query()
            ->where('status', PayableStatusEnum::new)
            ->where('created_at', '<', now()->subDays())
            ->get();

        foreach ($subscriptions as $subscription) {
            $subscription->delete();
        }

        $this->info('Done');
    }
}
