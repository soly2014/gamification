<?php

namespace Learncloud;

use Illuminate\Database\Eloquent\Model;

class Paycloud extends Model
{
  
  protected $table = 'payclouds';

            protected $fillable = [
                'payment_id',
                'user_id',
                'refunded',
                'payer_id',
                'payer_email',

      ];



}
