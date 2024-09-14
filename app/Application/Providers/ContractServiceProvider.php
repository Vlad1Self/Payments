<?php

namespace App\Application\Providers;

use App\Infrastructure\Repository\Currency\CurrencyCrudContract;
use App\Infrastructure\Repository\Currency\CurrencyCrudRepository;
use App\Infrastructure\Repository\Order\OrderCrudContract;
use App\Infrastructure\Repository\Order\OrderCrudRepository;
use App\Infrastructure\Repository\Payment\PaymentCrudContract;
use App\Infrastructure\Repository\Payment\PaymentCrudRepository;
use App\Infrastructure\Repository\PaymentMethod\PaymentMethodCrudContract;
use App\Infrastructure\Repository\PaymentMethod\PaymentMethodCrudRepository;
use App\Infrastructure\Repository\Subscription\SubscriptionCrudContract;
use App\Infrastructure\Repository\Subscription\SubscriptionCrudRepository;
use App\Infrastructure\Repository\User\UserCrudContract;
use App\Infrastructure\Repository\User\UserCrudRepository;
use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }
    public function boot(): void
    {
        $this->app->bind(OrderCrudContract::class, OrderCrudRepository::class);

        $this->app->bind(UserCrudContract::class, UserCrudRepository::class);

        $this->app->bind(PaymentMethodCrudContract::class, PaymentMethodCrudRepository::class);

        $this->app->bind(CurrencyCrudContract::class, CurrencyCrudRepository::class);

        $this->app->bind(PaymentCrudContract::class, PaymentCrudRepository::class);

        $this->app->bind(SubscriptionCrudContract::class, SubscriptionCrudRepository::class);
    }
}
