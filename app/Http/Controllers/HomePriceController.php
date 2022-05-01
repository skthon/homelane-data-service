<?php

namespace App\Http\Controllers;

use App\Models\HomePrice;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\HomePriceDataRequest;

class HomePriceController extends Controller
{
    /**
     * Fetch the home prices data based on the request
     *
     * @param \App\Http\Requests\HomePricesDataRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(HomePriceDataRequest $request): JsonResponse
    {
        $query = HomePrice::whereRaw('1 = 1');

        // Used by query service : BudgetHomes API
        $query->when($request->has('min_price') || $request->has('max_price'), function ($query) use ($request) {
            $query->where('price', '>', $request->get('min_price'))
                ->where('price', '<', $request->get('max_price'));
        });

        // User by query service : SqftHomes API
        $query->when($request->has('min_sqft_living'), function ($query) use ($request) {
            $query->where('sqft_living', '>', $request->get('min_sqft_living', 0));
        });

        // User by query service : AgeHomes API
        $query->when($request->has('min_year'), function ($query) use ($request) {
            $query->where('year_built', '>', $request->get('min_year', 0))
                ->orWhere('year_renovated', '>', $request->get('min_year', 0));
        });

        return response()->json(['data' => $query->get()]);
    }
}
