<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @param  string  $name
     * @return int
     */
    public function firstOrCreate($name)
    {
        return Category::firstOrCreate(['name' => $this->format($name)])['id'];
    }

    /**
     * @param  string  $name
     */
    private static function format($name): string
    {
        if ($name == '餅') {
            return 'もち';
        }

        return str_replace('（鳥取県産）', '', $name);
    }
}
