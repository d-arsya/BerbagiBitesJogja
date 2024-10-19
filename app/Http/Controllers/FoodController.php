<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $donations = Donation::where('status','aktif')->get();
        $foods = Food::latest()->get();
        return view('pages.food.index',["donations"=>$donations,"foods"=>$foods]);
    }
    public function store(Request $request)
    {
        Food::create($request->all());
        return back();
    }
    public function edit(Food $food)
    {
        $donation = $food->donation();
        $foods = Food::latest()->get();
        return view('pages.food.edit',["donation"=>$donation,"foods"=>$foods,"food"=>$food]);
    }
    public function update(Request $request, Food $food)
    {
        $food->update($request->all());
        return redirect(route('food.index'));
    }
    public function destroy(Food $food)
    {
        $food->delete();
        return back();
    }
}
