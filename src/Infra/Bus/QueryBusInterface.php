<?php

namespace App\Infra\Bus;

interface QueryBusInterface
{
    public function handleQuery($query);
}
