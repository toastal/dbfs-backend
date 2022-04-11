<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Requests\PaymentRequest as Request;
use App\Http\Resources\PaymentResource;
use App\Models\Payments;
use App\Services\Activity\ActivityService;
use App\Services\Payment\PaymentCollection;
use App\Services\Payment\PaymentService;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
class PaymentController extends Controller
{
    /**
     * @param PaymentCollection $payments
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(PaymentCollection $payments)
    {
        $this->authorize('create', Payments::class);

        $collection = PaymentResource::collection($payments->get());

        $collection->additional(['meta' => $payments->getMeta()]);

        return $collection;
    }

    /**
     * @param Request $request
     * @param PaymentService $paymentService
     * @return PaymentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, PaymentService $paymentService)
    {
        $this->authorize('create', Payments::class);

        $payment = $paymentService->create($request->all());

        ActivityService::log($payment->id, "Payment #$payment->id was created.");

        return new PaymentResource($payment);
    }

    /**
     * @param PaymentService $service
     * @param $id
     * @return PaymentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(PaymentService $service, $id)
    {
        $model = $service->find($id);

        $this->authorize('view', $model);

        
        $model->load('user');
        

        return new PaymentResource($model);
    }

    /**
     * @param Request $request
     * @param PaymentService $paymentService
     * @param $id
     * @return PaymentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, PaymentService $paymentService, $id)
    {
        $model = $paymentService->find($id);

        $this->authorize('update', $model);

        $data = $request->only($model->getFillable());

        $model->update($data);

        ActivityService::log($model->id, "Payment #$model->id was updated.");

        return new PaymentResource($model);
    }

    /**
     * @param PaymentService $paymentService
     * @param $id
     * @return PaymentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(PaymentService $paymentService, $id)
    {
        $model = $paymentService->find($id);

        $this->authorize('delete', $model);

        $model->status = Constants::STATUS_DELETED;

        $model->save();

        ActivityService::log($model->id, "Payment #$model->id was deleted.");

        return new PaymentResource($model);
    }
}
