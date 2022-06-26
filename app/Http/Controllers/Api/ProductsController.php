<?php

namespace App\Http\Controllers\Api;
use App\Models\Api\Product;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductsController extends Controller
{
    function respond($status, $message, $data, $code)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ],$code);
    }

    public function getAllProducts()
    {
        $products = Product::with('seller')->get();
        return $this->respond(true,'Data retrieved',$products,200);
    }

    public function createNewProduct(Request $request)
    {
        //check if the user is a seller...
        $user = Auth::user();
        if ($user->seller()) {
            $request->validate([
                'name' => 'required|min:3',
                'slug' => 'required',
                'cost' => 'required|numeric|multiple_of:5',
                'amount_available' => 'required|numeric',
            ]);
            DB::beginTransaction();
            try {
                //create product!
                $product = Product::create([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'cost' => $request->cost,
                    'amount_available' => $request->amount_available,
                    'description' => $request->description ?? '',
                    'seller_id' => $user->id
                ]);
                DB::commit();
                return $this->respond(true,'Product created successfully',$product,201);

            } catch (\Exception $e) {
                DB::rollback();
                return $this->respond('error','Something went wrong',$e->getMessage(),422);
            }
        }
        return $this->respond(false,'You are not a seller, you cant create a product',null,422);
    }

    public function updateProduct(Request $request,$id)
    {
        $product = Product::with('seller')->find($id);
        $user = Auth::user();
        if ($product) {
            //check if this product belongs to this user
            if ($product->seller_id == $user->id ) {
                DB::beginTransaction();
                try {
                    $request->validate([
                        'name' => 'sometimes|required|min:3',
                        'slug' => 'sometimes|required',
                        'cost' => 'sometimes|required|numeric',
                        'amount_available' => 'sometimes|required|numeric',
                    ]);
                    $product->update($request->all());
                    DB::commit();
                    return $this->respond(true,'Product Update',$product,201); 
                } catch (\Exception $e) {
                    DB::rollBack();
                    return $this->respond('error','Something went wrong',$e->getMessage(),422);
                }
            }
            return $this->respond(false,'You cannot update this product, its not created by you!',null,422);
        }
        return $this->respond(false,'This product does not exist!',null,404);
    }

    public function getSingleProduct($id)
    {
        $product = Product::with('seller')->find($id);
        if ($product) {
            $this->respond(true,'Product retrieved!',$product,200);
        }
        $this->respond(false,'Product does not exist!',null,404);  
    }

    public function deleteProduct($id)
    {
        $product = Product::with('seller')->find($id);
        if ($product) {
            $product->delete();
            return $this->respond('true','Product Deleted',null,200);
        }
        return $this->respond('error','This product does not exist',null,404);
    }

    public function sellerProducts($id)
    {
        $user = User::find($id);
        if ($user && $user->seller()) {
            $products = Product::where('seller_id',$id)->get();
            return $this->respond('true','Seller Products retrieved',$products,200);
        }
        return $this->respond('error','User does not exist, or user is not a seller',null,404);
    }
}
