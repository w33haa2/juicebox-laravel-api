<?php

namespace App\Repositories\Contracts;

interface WeatherRepositoryInterface
{
    public function fetch(): array;
}