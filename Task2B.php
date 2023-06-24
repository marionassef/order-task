<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Task2B
{
    public function Task2B()
    {
        $products = DB::table('products')
            ->join('purchases', 'products.id', '=', 'purchases.product_id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select('products.name', DB::raw('SUM(purchases.quantity) as total_quantity_sold'), DB::raw('AVG(reviews.rating) as average_rating'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity_sold')
            ->limit(5)
            ->get();

        $arrayOfProducts = [];
        foreach ($products as $product) {
            $productObj = new stdClass();
            $productObj->product_name = $product->name;
            $productObj->total_quantity_sold = $product->total_quantity_sold;
            $productObj->average_rating = $product->average_rating;
            $arrayOfProducts[] = $productObj;
        }
        return $arrayOfProducts;
    }

}
