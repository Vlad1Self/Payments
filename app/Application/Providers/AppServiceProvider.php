<?php

namespace App\Application\Providers;

use App\Domain\Models\Order\Order;
use App\Domain\Models\Subscription\Subscription;
use App\UI\CLI\Command\DeleteOldOrdersCommand;
use App\UI\CLI\Command\DeleteOldPayableCommand;
use App\UI\CLI\Command\DeleteOldSubscriptionCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->commands([
            DeleteOldOrdersCommand::class,
            DeleteOldSubscriptionCommand::class,
            DeleteOldPayableCommand::class
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'order' => Order::class,
            'subscription' => Subscription::class
        ]);
    }
}
