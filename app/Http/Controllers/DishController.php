<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;

class DishController extends Controller
{
    public function store(Dish $dish, Request $request)
    {
        $dish->create(['name' => $request->name, 'price' => $request->price]);
    }

    public function delete(Dish $dish, Request $request)
    {
        $dish->deleteOrFail($request->id);
    }

    public function index(Dish $dish)
    {
        return $dish->all(['id', 'name', 'price']);
    }
}
