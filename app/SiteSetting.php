<?php

namespace Learncloud;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table       = 'sitesettings';
    protected $fillable    = ['homeone', 'hometwo', 'homethree', 'homefour', 'homefive',
                              'featureone', 'featuretwo', 'featurethree', 'featurefour', 'featurefive', 
                              'profileone', 'profiletwo', 'profilethree', 'profilefour'];

}
