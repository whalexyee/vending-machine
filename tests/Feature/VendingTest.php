<?php

namespace Tests\Feature;

use App\Models\Api\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    

    public function test_deposit()
    {
        $this->actingAs($this->buyer(),'sanctum');
        //Note you can only deposit [5,10,20,50 and 100 denominations];
        $request = [
            'cost' => 100
        ];
        $this->json('POST',route('api.deposit'),$request)->assertStatus(201);
    }

    public function test_buy()
    {
        $this->actingAs($this->buyer(),'sanctum');
        $request = [
            'product_id' => 2,
            'amount' => 1
        ];
        $this->json('POST',route('api.buy'),$request)
        ->assertStatus(201);
    }

    public function test_get_products()
    {
        $this->actingAs($this->seller(),'sanctum');
        $this->json('GET',route('api.all.products'))->assertStatus(201);
    }

    public function test_create_product()
    {
        $this->actingAs($this->seller(),'sanctum');
        $requests = [
            'name' => 'Dummy2',
            'cost' => 500,
            'slug' => 'dummy2',
            'amount_available' => 15
        ];
        $this->json('POST',route('api.create.product'),$requests)->assertStatus(201);
    }

    public function test_single_product()
    {
        $this->actingAs($this->seller(),'sanctum');
        $this->json('GET',route('api.single.product',8))->assertStatus(201);
    }

    public function test_update_product()
    {
        $this->actingAs($this->seller(),'sanctum');
        $requests = [
            'name' => 'dummy changes again',
        ];
        $this->json('PUT',route('api.update.product',8),$requests)->assertStatus(201);
    }

    public function test_delete_product()
    {
        $this->actingAs($this->seller(),'sanctum');
        $this->json('DELETE',route('api.single.product',11))->assertStatus(404);
    }

    public function buyer()
    {
        $user = User::find(3);
        return $user;
    }

    public function seller()
    {
        $user = User::find(4);
        return $user;
    }
    // $this->withoutExceptionHandling();




}
