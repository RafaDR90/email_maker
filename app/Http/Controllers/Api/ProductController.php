<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }


    public function searchProductsByRef(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $reference = $request->input('reference');

        // Realiza la consulta para encontrar productos que coincidan con la referencia
        $products = Product::where('referencia', 'like', '%' . $reference . '%')
            ->take(10)
            ->get();
        $acierto=null;


        $error = null;
        return response()->json($products);
    }
}
