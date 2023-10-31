<?php

namespace CyberPunkCodes\FlashMessages\Facades;

use Illuminate\Support\Facades\Facade;

class FlashMessages extends Facade
{
    /**
      * Get the registered name of the component.
      *
      * @return string
      */
     protected static function getFacadeAccessor()
     {
         return \CyberPunkCodes\FlashMessages\FlashMessages::class;
     }
}
