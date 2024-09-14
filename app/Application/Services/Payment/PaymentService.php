<?php

namespace App\Application\Services\Payment;

use App\Application\Services\Payment\DTO\ChoosePaymentMethodDTO;
use App\Application\Services\Payment\DTO\CompletePaymentDTO;
use App\Application\Services\Payment\DTO\GetPaymentMethodDTO;
use App\Application\Services\Payment\DTO\IndexPaymentDTO;
use App\Application\Services\Payment\DTO\ShowPaymentDTO;
use App\Application\Services\Payment\DTO\UpdatePayableStatusDTO;
use App\Application\Services\Payment\DTO\UpdatePaymentMethodDTO;
use App\Application\Services\Payment\DTO\UpdatePaymentStatusDTO;
use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\Payment\Resource\PaymentResource;
use App\Infrastructure\Repository\Payment\PaymentCrudContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

readonly class PaymentService
{
    public function __construct(private PaymentCrudContract $paymentCrudRepository)
    {
    }

    public function index(IndexPaymentDTO $data): LengthAwarePaginator
    {
        try {
            return $this->paymentCrudRepository->index($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function checkout(ShowPaymentDTO $data): Payment
    {
        try {
            $payment = $this->paymentCrudRepository->show($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        if ($payment->status != PaymentStatusEnum::pending) {
            throw new \Exception('Payment not pending', 404);
        }

        return $payment;
    }

    public function choosePaymentMethod(ChoosePaymentMethodDTO $data): Payment
    {
        try {
            $payment = $this->paymentCrudRepository->show(new ShowPaymentDTO(['uuid' => $data->payment_uuid]));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        if ($payment->status != PaymentStatusEnum::pending) {
            throw new \Exception('Payment not pending', 404);
        }

        $payment_method = $this->paymentCrudRepository->getPaymentMethod(new GetPaymentMethodDTO(['payment_method_id' => $data->payment_method_id]));

        if ($payment_method->currency_id != $payment->currency_id) {
            throw new \Exception('This payment method is not available for this currency', 404);
        }

        $data = new UpdatePaymentMethodDTO(['payment' => $payment, 'payment_method_id' => $data->payment_method_id]);

        try {
            return $this->paymentCrudRepository->updatePaymentMethod($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function process(ShowPaymentDTO $data): Payment
    {
        try {
            $payment = $this->paymentCrudRepository->show($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        if ($payment->status != PaymentStatusEnum::pending) {
            throw new \Exception('Payment not pending', 404);
        }

        $data = new UpdatePaymentStatusDTO(['payment' => $payment, 'status' => PaymentStatusEnum::processing]);

        try {
            $payment = $this->paymentCrudRepository->updatePaymentStatus($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        return $payment;
    }

    public function success(ShowPaymentDTO $data): Payment
    {
        try {
            $payment = $this->paymentCrudRepository->show($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        if ($payment->status != PaymentStatusEnum::processing) {
            throw new \Exception('Payment not processing', 404);
        }

        $data_for_payable = new UpdatePayableStatusDTO(['payable_type' => $payment->payable_type, 'payable_id' => $payment->payable_id, 'status' => PayableStatusEnum::completed]);

        $data_for_payment = new UpdatePaymentStatusDTO(['payment' => $payment, 'status' => PaymentStatusEnum::success]);

        DB::transaction(function() use ($data_for_payable, $data_for_payment, &$payment) {

            try {
                $success = $this->paymentCrudRepository->updatePayableStatus($data_for_payable);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                throw $e;
            }

            try {
                $payment = $this->paymentCrudRepository->updatePaymentStatus($data_for_payment);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                throw $e;
            }
        });

        return $payment;
    }

    public function failure(ShowPaymentDTO $data): Payment
    {
        try {
            $payment = $this->paymentCrudRepository->show($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        if ($payment->status != PaymentStatusEnum::processing) {
            throw new \Exception('Payment not processing', 404);
        }

        $data = new UpdatePaymentStatusDTO(['payment' => $payment, 'status' => PaymentStatusEnum::failed]);

        try {
            $payment = $this->paymentCrudRepository->updatePaymentStatus($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        return $payment;
    }
}
