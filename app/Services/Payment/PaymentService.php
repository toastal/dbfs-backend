<?php
/**
 * Created by PhpStorm.
 * User: Dave
 * Date: 8/19/2018
 * Time: 12:58 PM
 */

namespace App\Services\Payment;

use App\Models\Payments;
use Carbon\Carbon;

/**
 * Class PaymentService
 * @package App\Services\Payment
 */
class PaymentService
{
    /**
     * @var payment
     */
    protected $payment;

    /**
     * paymentService constructor.
     * @param Payment $payment
     */
    public function __construct(Payments $payment)
    {
        $this->payment = $payment;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->payment->findOrFail($id);
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function create($request = [])
    {        
        $model = $this->payment->create([
            'user_id'           => $request['user_id'],
            'amount_paid'       => $request['amount_paid'],
            'amount_balance'    => $request['amount_balance'],
            'reason'            => $request['reason'],
                    
        ]);

        return $model;
    }
}