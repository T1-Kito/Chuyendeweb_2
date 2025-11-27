<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rentalDurations = [1, 6, 12, 18, 24];
        $rentalDuration = $this->faker->randomElement($rentalDurations);

        $product = Product::inRandomOrder()->first();
        if (!$product) {
            throw new \Exception('Không có sản phẩm nào trong database. Vui lòng chạy ProductSeeder trước.');
        }

        $pricePerMonth = $product->getPriceByMonths($rentalDuration) ?: 1000000;
        $quantity = $this->faker->numberBetween(1, min(5, $product->stock_quantity ?? 5));

        return [
            'user_id' => User::factory(),
            'product_id' => $product->id,
            'rental_duration' => $rentalDuration,
            'quantity' => $quantity,
            'price_per_month' => $pricePerMonth,
            'total_price' => $pricePerMonth * $quantity,
        ];
    }
}

