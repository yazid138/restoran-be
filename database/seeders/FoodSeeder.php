<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = [
            // Appetizers
            [
                'name' => 'Spring Rolls',
                'description' => 'Crispy vegetable spring rolls with sweet chili sauce',
                'price' => 25000,
                'category' => 'Appetizer',
                'status' => 'available',
            ],
            [
                'name' => 'Chicken Satay',
                'description' => 'Grilled chicken skewers with peanut sauce',
                'price' => 35000,
                'category' => 'Appetizer',
                'status' => 'available',
            ],
            [
                'name' => 'Fried Calamari',
                'description' => 'Crispy fried squid rings with tartar sauce',
                'price' => 40000,
                'category' => 'Appetizer',
                'status' => 'available',
            ],
            [
                'name' => 'Soup of the Day',
                'description' => 'Chef\'s special soup',
                'price' => 20000,
                'category' => 'Appetizer',
                'status' => 'available',
            ],
            [
                'name' => 'Garlic Bread',
                'description' => 'Toasted bread with garlic butter',
                'price' => 15000,
                'category' => 'Appetizer',
                'status' => 'available',
            ],

            // Main Courses
            [
                'name' => 'Nasi Goreng Special',
                'description' => 'Indonesian fried rice with chicken, egg, and vegetables',
                'price' => 45000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Grilled Chicken',
                'description' => 'Marinated grilled chicken with steamed vegetables',
                'price' => 55000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Beef Rendang',
                'description' => 'Slow-cooked beef in coconut curry',
                'price' => 65000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Grilled Fish',
                'description' => 'Fresh fish grilled with lemon butter sauce',
                'price' => 70000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Spaghetti Carbonara',
                'description' => 'Creamy pasta with bacon and parmesan',
                'price' => 50000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Mie Goreng',
                'description' => 'Indonesian fried noodles with vegetables',
                'price' => 40000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Chicken Curry',
                'description' => 'Spicy chicken curry with rice',
                'price' => 48000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Vegetable Stir Fry',
                'description' => 'Mixed vegetables in garlic sauce',
                'price' => 35000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Beef Steak',
                'description' => 'Grilled beef with black pepper sauce',
                'price' => 85000,
                'category' => 'Main Course',
                'status' => 'available',
            ],
            [
                'name' => 'Seafood Platter',
                'description' => 'Mixed seafood with garlic butter',
                'price' => 95000,
                'category' => 'Main Course',
                'status' => 'available',
            ],

            // Beverages
            [
                'name' => 'Es Teh Manis',
                'description' => 'Sweet iced tea',
                'price' => 8000,
                'category' => 'Beverage',
                'status' => 'available',
            ],
            [
                'name' => 'Es Jeruk',
                'description' => 'Fresh orange juice',
                'price' => 12000,
                'category' => 'Beverage',
                'status' => 'available',
            ],
            [
                'name' => 'Cappuccino',
                'description' => 'Italian coffee with steamed milk',
                'price' => 18000,
                'category' => 'Beverage',
                'status' => 'available',
            ],
            [
                'name' => 'Mineral Water',
                'description' => 'Bottled mineral water',
                'price' => 5000,
                'category' => 'Beverage',
                'status' => 'available',
            ],
            [
                'name' => 'Fresh Coconut',
                'description' => 'Young coconut water',
                'price' => 15000,
                'category' => 'Beverage',
                'status' => 'available',
            ],
            [
                'name' => 'Lemon Tea',
                'description' => 'Hot or iced lemon tea',
                'price' => 10000,
                'category' => 'Beverage',
                'status' => 'available',
            ],
            [
                'name' => 'Soft Drink',
                'description' => 'Coca Cola, Sprite, or Fanta',
                'price' => 8000,
                'category' => 'Beverage',
                'status' => 'available',
            ],
            [
                'name' => 'Mango Smoothie',
                'description' => 'Fresh mango blended smoothie',
                'price' => 20000,
                'category' => 'Beverage',
                'status' => 'available',
            ],

            // Desserts
            [
                'name' => 'Ice Cream',
                'description' => 'Vanilla, chocolate, or strawberry',
                'price' => 18000,
                'category' => 'Dessert',
                'status' => 'available',
            ],
            [
                'name' => 'Banana Fritters',
                'description' => 'Fried banana with honey',
                'price' => 15000,
                'category' => 'Dessert',
                'status' => 'available',
            ],
            [
                'name' => 'Chocolate Lava Cake',
                'description' => 'Warm chocolate cake with molten center',
                'price' => 25000,
                'category' => 'Dessert',
                'status' => 'available',
            ],
            [
                'name' => 'Fruit Salad',
                'description' => 'Fresh mixed fruits with yogurt',
                'price' => 20000,
                'category' => 'Dessert',
                'status' => 'available',
            ],
            [
                'name' => 'Tiramisu',
                'description' => 'Italian coffee-flavored dessert',
                'price' => 28000,
                'category' => 'Dessert',
                'status' => 'available',
            ],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}
