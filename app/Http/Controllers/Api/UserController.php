<?php

namespace App\Http\Controllers\Api;
use App\Models\User;

use App\Http\Controllers\Controller;
use App\Models\Api\Product;
use App\Models\UserProductPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function respond($status, $message, $data, $code)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ],$code);
    }

    public function index()
    {
        //get all User...
        $users = User::with('role')->get();
        return $this->respond(true,'All users retrieved',$users,200);
    }

    public function show($id)
    {
        $user = User::with('role')->find($id);
        if ($user) {
            return $this->respond(true,'Single User retrieved',$user,201);
        }
        return $this->respond(false,'User Not Found',null,404);
    }

    public function update(Request $request, $id)
    {
        dd($request->email);
        $user = User::with('role')->find($id);
        if ($user) {
            $role_id = [1,2];
            $request->validate([
                'username' => 'sometimes|required|unique:users,username|string|min:2',
                'email' => 'sometimes|string|unique:users,email|email',
                'password' => 'sometimes|required|string|confirmed',
                'role_id' => 'sometimes|required|in:' . implode(',', $role_id).'|numeric',
            ]);
            DB::beginTransaction();
            try {
                $user->update($request->all());            
                DB::commit();
                return $this->respond(true,'User Record Updated',$user,201);           
            } catch (\Exception $e) {
                DB::rollback();
                return $this->respond('error','SOmething went wrong',$e->getMessage(),422);
            }
        }
        return $this->respond(false,'User Not Found',null,404);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            DB::beginTransaction();
            try {
                $user->delete();           
                DB::commit();
                return $this->respond(true,'User Record deleted',$user,200);          
            } catch (\Exception $e) {
                DB::rollback();
                return $this->respond('error','Something went wrong',$e->getMessage(),422);
            }
        }
        return $this->respond(false,'User Not Found',$user,404);
    }

    public function deposit(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->buyer()) {
            $productData = $request->all();
            $notes = [5,10,20,50,100];
            $rules = [
                'cost' => 'required|in:' . implode(',', $notes).'|numeric|min:5|max:100',
            ];
            $customRules = [
                'cost.in' => 'You can only deposit a denomination of 5, 10, 20, 50 or 100 cents in this vending machine'
            ];
            $validator = Validator::make($productData,$rules,$customRules);
            if ($validator->fails()) {
                return $this->respond(false,'Validation Failed',$validator->errors(),422);
            }
            //Add deposit to the system
            DB::beginTransaction();
            try {
                $currentDeposit = $user->deposit;
                $newDeposit = ($currentDeposit + $request->cost);
                $user->deposit = $newDeposit;
                
                $user->save();
                DB::commit();

                return $this->respond(true,'Deposit made successfully',$user,201);

            } catch (\Exception $e) {
                DB::rollback();
                return $this->respond('error','Something went wrong',$e->getMessage(),422);
            }
        }
        return $this->respond(false,'You must be a buyer',null,422);
    }

    public function buy(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->buyer()) {
            $fields = $request->validate([
                'product_id' => 'required|numeric',
                'amount' => 'required|numeric',
            ]);
            $product = Product::with('seller')->find($request->product_id);
            if ($product) {
                $amountAvailable = $product->amount_available;
                if ((int)$request->amount < (int)$amountAvailable) {
                    $totalCost = ($request->amount * $product->cost);
                    $availableBalance = $user->deposit;
                    if ($availableBalance > $totalCost ) {
                        $change = $availableBalance - $totalCost;
                        $newAmount = $amountAvailable - $request->amount;
                        DB::beginTransaction();
                        try {
                            $purchase = UserProductPurchase::create([
                                'user_id' => $user->id,
                                'product_id' => $product->id,
                                'amount' => $request->amount,
                                'price' => $totalCost
                            ]);
                            //New Deposit!
                            $user->deposit = $change;
                            $user->save();
                            //New Product Amount
                            $product->amount_available = $newAmount;
                            $product->save();

                            DB::commit();
                            return response()->json([
                                'status' => true,
                                'message' => 'Purchase completed',
                                'data' => [
                                    'product' => $product->name,
                                    'product_price' => $product->cost,
                                    'quantity_bought' => $request->amount,
                                    'totalCost' => $purchase->price,
                                    'change' => $change,
                                    'product_details' => $product,
                                ]
                            ],201);

                        } catch (\Exception $e) {
                            DB::rollBack();
                            return $this->respond(false,'Something went wrong',$e->getMessage(),422);
                        }                        
                    }
                    //you dont have emough to buy!
                    return response()->json([
                        'status' => false,
                        'message' => 'Insufficient fund in your wallet!',
                        'data' => [
                            'total_cost' => $totalCost,
                            'available_balance' => $availableBalance
                        ],
                    ],422);
                }
                //amount requested not available
                return response()->json([
                    'status' => false,
                    'message' => 'The number of requested product is not available',
                    'data' => [
                        'available_amount' => $product->amount_available,
                        'amount_requested' => $request->amount,                        
                    ],
                ],422);
            }
            //product cannot be found ...
            return $this->respond(false,'Product cannot be found',null,404);
        }
        return $this->respond(false,'You dont have the role of a Buyer',null,422);

    }

    public function reset(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->buyer()) {
            $user->deposit = 0;
            $user->save();
            return $this->respond(true,'Deposit reset to 0',$user,200);
            return response()->json([
                'status' => true,
                'message' => 'Deposit reset to 0',
                'data' => $user            
            ]);
        }
        return $this->respond(false,'Not a Buyer Account',null,422);
    }
}
