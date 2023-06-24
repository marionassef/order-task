<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->model = new Product();
    }
}
