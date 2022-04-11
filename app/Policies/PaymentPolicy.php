<?php

namespace App\Policies;

use App\Models\User;
use AApp\Models\Payments;
use App\Policies\HasAdmin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;
    use HasAdmin;

    /**
     * Determine whether the user can view the payment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function view(User $user, Payments $payment)
    {
        return $user->is_admin || $user->id === $payment->user_id;
    }

    /**
     * Determine whether the user can create payments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the payment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function update(User $user, Payments $payment)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the payment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Payment  $payment
     * @return mixed
     */
    public function delete(User $user, Payments $payment)
    {
        return $user->is_admin;
    }
}
