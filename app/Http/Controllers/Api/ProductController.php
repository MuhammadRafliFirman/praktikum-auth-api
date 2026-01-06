<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     *	GET /api/products
     *	Mengambil semua data products
     */
    public function index()
    {
        $products = Product::all();


        return response()->json([
            'success' => true,
            'message' => 'List of products',
            'data' => $products
        ], 200);
    }


    /**
     *	GET /api/products/{id}
     *	Mengambil detail product berdasarkan ID

     */
    public function show($id)
    {
        $product = Product::find($id);


        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }


        return response()->json([
            'success' => true,
            'message' => 'Product detail',
            'data' => $product
        ], 200);
    }


    /**
     *	POST /api/products
     *	Membuat product baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }


        $product = Product::create($request->all());


        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }


    /**
     *	PUT /api/products/{id}
     *	Update product berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);


        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }


        $product->update($request->all());


        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }


    /**
     *	DELETE /api/products/{id}
     *	Hapus product berdasarkan ID
     */
    public function destroy($id)
    {

        $product = Product::find($id);


        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }


        $product->delete();


        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
