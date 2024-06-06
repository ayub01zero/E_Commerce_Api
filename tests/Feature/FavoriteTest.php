<?php

// use App\Models\User;
// use App\Models\Favorite;
// use App\Models\Products;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Laravel\Sanctum\Sanctum;

// uses(RefreshDatabase::class);

// beforeEach(function () {
//     $this->user = User::factory()->create();
//     Sanctum::actingAs($this->user);
// });

// it('can fetch user favorites', function () {
//     // Create a few favorites for the user
//     $favorites = Favorite::factory()->count(3)->create(['user_id' => $this->user->id]);

//     // Call the index method of the controller
//     $response = $this->getJson('/api/favorite');

//     // Assert that the response status is OK
//     $response->assertStatus(200);

//     // Assert that the JSON structure matches the expected format
//     $response->assertJsonStructure([
//         'data' => [
//             '*' => [
//                 'id',
//                 'Type',
//                 'attributes' => [
//                     'product_id',
//                     'user_id',
//                 ],
//             ],
//         ],
//     ]);

//     // Assert that the response contains the correct data
//     $response->assertJsonFragment([
//         'id' => (string) $favorites->first()->id,
//         'Type' => 'Favorites',
//         'attributes' => [
//             'product_id' => $favorites->first()->product_id,
//             'user_id' => $this->user->id,
//         ],
//     ]);
// });

// it('can add a product to favorites', function () {
//     $product = Products::factory()->create();

//     $response = $this->postJson('/api/favorite', ['productId' => $product->id]);

//     $response->assertStatus(201)
//              ->assertJsonStructure([
//                  'data' => [
//                      'id',
//                      'Type',
//                      'attributes' => [
//                          'product_id',
//                          'user_id',
//                      ],
//                  ],
//              ]);
// });

// it('returns 404 if product is not found', function () {
//     $response = $this->postJson('/api/favorite', ['productId' => 999]);

//     $response->assertStatus(404)
//              ->assertJson([
//                  'message' => 'Product not found',
//              ]);
// });

// it('returns 400 if product is already in favorites', function () {
//     $product = Products::factory()->create();
//     $this->user->favorites()->create(['product_id' => $product->id]);

//     $response = $this->postJson('/api/favorite', ['productId' => $product->id]);

//     $response->assertStatus(400)
//              ->assertJson([
//                  'message' => 'Product already in favorites',
//              ]);
// });

// it('can remove a favorite item', function () {
//     $favorite = Favorite::factory()->create(['user_id' => $this->user->id]);

//     $response = $this->deleteJson('/api/favorite/' . $favorite->id);

//     $response->assertStatus(200)
//              ->assertJson([
//                  'message' => 'Favorite removed successfully',
//              ]);

//     // Ensure the favorite item is removed from the database
//     $this->assertDatabaseMissing('favorites', [
//         'id' => $favorite->id,
//     ]);
// });

// it('returns 404 if favorite item is not found', function () {
//     $response = $this->deleteJson('/api/favorite/999');

//     $response->assertStatus(404)
//              ->assertJson([
//                  'message' => 'Favorite not found',
//              ]);
// });

// it('returns 403 if user is unauthorized to remove the favorite item', function () {
//     $anotherUser = User::factory()->create();
//     $favorite = Favorite::factory()->create(['user_id' => $anotherUser->id]);

//     $response = $this->deleteJson('/api/favorite/' . $favorite->id);

//     $response->assertStatus(403)
//              ->assertJson([
//                  'message' => 'Unauthorized to remove this favorite item.',
//              ]);
// });
