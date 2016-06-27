<?php

namespace Learncloud;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{

	  protected $table = 'points';

            protected $fillable = [
                'user_id',
                'points',

      ];





}
