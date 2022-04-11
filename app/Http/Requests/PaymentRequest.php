<?php

namespace App\Http\Requests;

use Config;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function rules()
    {
        return [            
            'user_id'           => 'required|exists:users,id',
            'amount_paid'       => 'required|numeric|min:0'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
