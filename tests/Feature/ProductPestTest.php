<?php
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use App\Models\User;
// use App\Models\Products;
// use function Pest\Laravel\{get, post, put, delete, actingAs};
// use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Storage;
// use Laravel\Sanctum\Sanctum;

// uses(RefreshDatabase::class);

// beforeEach(function () {
//     Storage::fake('public');

//     $this->admin = User::factory()->create(['role' => 'admin']);
//     Sanctum::actingAs($this->admin);
//     $this->product = Products::factory()->create();
// });

// test('admin can view all products', function () {
//     $response = actingAs($this->admin)
//         ->get('/api/v1/products', ['Accept' => 'application/json']);

//         $expectedResponse = [
//             'data' => [
//                 [
//                     'Id' => (string) $this->product->id,
//                     'Type' => 'Products',
//                     'attributes' => [
//                         'Category_id' => $this->product->category_id,
//                         'product_name' => $this->product->product_name,
//                         'product_code' => $this->product->product_code,
//                         'product_qty' => $this->product->product_qty,
//                         'product_tags' => $this->product->product_tags,
//                         'weight' => $this->product->weight,
//                         'selling_price' => $this->product->selling_price,
//                         'discount_price' => $this->product->discount_price,
//                         'short_des' => $this->product->short_des,
//                         'long_des' => $this->product->long_des,
//                         'show_slider' => $this->product->show_slider,
//                         'week_deals' => $this->product->week_deals,
//                         'special_offer' => $this->product->special_offer,
//                         'new_products' => $this->product->new_products,
//                         'discount_products' => $this->product->discount_products,
//                         'status' => $this->product->status,
//                         'Images' => [], // Assuming no images for simplicity; adjust as needed
//                     ],
//                 ],
//             ],
//         ];
    
//         $response->assertStatus(200)
//             ->assertJson($expectedResponse);
// });

// test('admin can view a specific product', function () {
//     $response = actingAs($this->admin)
//         ->get("/api/v1/products/{$this->product->id}", ['Accept' => 'application/json']);

//     $response->assertStatus(200)
//         ->assertJson([
//             'data' => [
//                 'Id' => (string) $this->product->id,
//                 'Type' => 'Products',
//                 'attributes' => [
//                     'product_name' => $this->product->product_name,
//                 ]
//             ]
//         ]);
      
    
//     });

    
  