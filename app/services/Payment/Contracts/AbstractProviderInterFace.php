<?php

namespace App\Services\Payment\Contracts;

abstract class AbstractProviderInterFace
{
   public function __construct(protected RequestInterface $request)
   {

   }

}
