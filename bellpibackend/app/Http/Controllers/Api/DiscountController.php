<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDiscountPost;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function getCurrentDiscount(){
        $discount=Discount::first();
        return response()->json($discount);
    }
    public function updateDiscount(UpdateDiscountPost $request,Discount $discount){
        $discount->update([
            'minutes' => $request->minutes,
            'percent' => $request->percent,
        ]);
    }
}
