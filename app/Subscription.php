<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscription extends Model
{
    protected $fillable = [
        'user_id','subscription_activation_date', 'subscription_end_date', 'is_active',
    ];
}
