<?php

namespace App\Http\Controllers\Filters;

use App\Models\Product;

class OrderbyFilter
{
    public function newest()
    {
        return Product::orderBy('created_at', 'DESC')->get();
    }

    public function mostPopular()
    {
        return Product::all();
    }
        public function default()
    {
        return Product::all();
    }
        public function lowtohigh()
    {
          return Product::orderBy('price', 'asc')->get();
    }
            public function hightolow()
    {
          return Product::orderBy('price', 'DESC')->get();
    }
}
