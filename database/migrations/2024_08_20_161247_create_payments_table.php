<?php

use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('status')->default(PaymentStatusEnum::pending);
            $table->string('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->decimal('amount', 10, 2);
            $table->morphs('payable');
            $table->string('driver_payment_id')->nullable();
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
