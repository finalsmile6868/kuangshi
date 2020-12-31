<?php

namespace Finalsmile6868\Kuangshi\Facades;

use Finalsmile6868\Kuangshi\Kuangshi as KuangshiKuangshi;
use Illuminate\Support\Facades\Facade;

class Kuangshi extends Facade{

    protected static function getFacadeAccessor()
    {
        return KuangshiKuangshi::class;
    }
}
