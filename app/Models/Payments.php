<?php

/**
 * Created by Murali Mariyappan<muralimariyappan13@gmail.com>.
 * Date: Tue, 12:46:50 AM 12 April 2022.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Package
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount_paid
 * @property float $amount_balance
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Payments extends Model
{
    use HasUser;    

    protected $casts = [
        'user_id' => 'int',        
        'amount_paid' => 'float',
        'amount_balance' => 'float',        
    ];

    protected $fillable = [
        'user_id',    
        'amount_paid',    
        'amount_balance',       
        'reason'         
    ];
}
