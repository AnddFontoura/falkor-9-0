<?php

namespace App\Http\Service;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected $model;

    public function getOrderedByName(string $orderBy = 'asc')
    {
        return $this->model
            ->orderBy('name', $orderBy)
            ->get();
    }

    public function getOrderedById(string $orderBy = 'asc')
    {
        return $this->model
            ->orderBy('id', $orderBy)
            ->get();
    }
}
