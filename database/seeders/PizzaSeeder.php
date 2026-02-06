<?php

namespace Database\Seeders;

use App\Models\Pizza;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    public function run(): void
    {
        $pizzas = [
            [
                'name' => 'Margherita Supreme',
                'description' => 'The timeless classic reborn. Fresh San Marzano tomatoes, creamy mozzarella di bufala, aromatic basil, and our signature olive oil drizzle.',
                'ingredients' => ['San Marzano Tomatoes', 'Mozzarella di Bufala', 'Fresh Basil', 'Extra Virgin Olive Oil'],
                'price' => 349.00,
                'image' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=600&h=600&fit=crop',
                'category' => 'classic',
                'is_featured' => true,
                'is_available' => true,
            ],
            [
                'name' => 'Pepperoni Passion',
                'description' => 'Bold and irresistible. Premium pepperoni, rich tomato sauce, and a blend of Italian cheeses that creates the perfect crispy bite.',
                'ingredients' => ['Premium Pepperoni', 'Italian Cheese Blend', 'Tomato Sauce', 'Oregano'],
                'price' => 399.00,
                'image' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=600&h=600&fit=crop',
                'category' => 'classic',
                'is_featured' => true,
                'is_available' => true,
            ],
            [
                'name' => 'Four Cheese Dream',
                'description' => 'A cheese lover\'s paradise. Gorgonzola, fontina, parmesan, and mozzarella melt together in perfect harmony.',
                'ingredients' => ['Gorgonzola', 'Fontina', 'Parmesan', 'Mozzarella', 'Honey Drizzle'],
                'price' => 449.00,
                'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=600&h=600&fit=crop',
                'category' => 'gourmet',
                'is_featured' => true,
                'is_available' => true,
            ],
            [
                'name' => 'BBQ Chicken Ranch',
                'description' => 'Smoky BBQ meets creamy ranch. Grilled chicken, caramelized onions, and cilantro on a tangy BBQ base.',
                'ingredients' => ['Grilled Chicken', 'BBQ Sauce', 'Ranch Drizzle', 'Caramelized Onions', 'Fresh Cilantro'],
                'price' => 479.00,
                'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600&h=600&fit=crop',
                'category' => 'specialty',
                'is_featured' => false,
                'is_available' => true,
            ],
            [
                'name' => 'Veggie Garden',
                'description' => 'Farm-fresh vegetables on every slice. Bell peppers, mushrooms, olives, artichokes, and sun-dried tomatoes.',
                'ingredients' => ['Bell Peppers', 'Mushrooms', 'Black Olives', 'Artichoke Hearts', 'Sun-dried Tomatoes', 'Feta Cheese'],
                'price' => 429.00,
                'image' => 'https://images.unsplash.com/photo-1511689660979-10d2b1aada49?w=600&h=600&fit=crop',
                'category' => 'vegetarian',
                'is_featured' => false,
                'is_available' => true,
            ],
            [
                'name' => 'Meat Lovers Feast',
                'description' => 'For the carnivore in you. Italian sausage, bacon, ham, pepperoni, and ground beef loaded on a robust tomato base.',
                'ingredients' => ['Italian Sausage', 'Bacon', 'Ham', 'Pepperoni', 'Ground Beef', 'Cheese Blend'],
                'price' => 549.00,
                'image' => 'https://images.unsplash.com/photo-1590947132387-155cc02f3212?w=600&h=600&fit=crop',
                'category' => 'specialty',
                'is_featured' => true,
                'is_available' => true,
            ],
            [
                'name' => 'Hawaiian Sunset',
                'description' => 'Sweet meets savory. Juicy pineapple, smoky ham, and a touch of jalapeño for those who dare.',
                'ingredients' => ['Fresh Pineapple', 'Smoked Ham', 'Jalapeños', 'Mozzarella', 'BBQ Glaze'],
                'price' => 419.00,
                'image' => 'https://images.unsplash.com/photo-1594007654729-407eedc4be65?w=600&h=600&fit=crop',
                'category' => 'specialty',
                'is_featured' => false,
                'is_available' => true,
            ],
            [
                'name' => 'Truffle Mushroom',
                'description' => 'Luxurious and earthy. Wild mushroom medley with truffle oil, garlic cream sauce, and shaved parmesan.',
                'ingredients' => ['Wild Mushrooms', 'Truffle Oil', 'Garlic Cream', 'Shaved Parmesan', 'Fresh Thyme'],
                'price' => 599.00,
                'image' => 'https://images.unsplash.com/photo-1571407970349-bc81e7e96d47?w=600&h=600&fit=crop',
                'category' => 'gourmet',
                'is_featured' => true,
                'is_available' => true,
            ],
            [
                'name' => 'Spicy Diavola',
                'description' => 'Fire on a crust. Spicy salami, chili flakes, hot honey, and jalapeños for the heat seekers.',
                'ingredients' => ['Spicy Salami', 'Chili Flakes', 'Hot Honey', 'Jalapeños', 'Mozzarella'],
                'price' => 459.00,
                'image' => 'https://images.unsplash.com/photo-1588315029754-2dd089d39a1a?w=600&h=600&fit=crop',
                'category' => 'specialty',
                'is_featured' => false,
                'is_available' => true,
            ],
            [
                'name' => 'Mediterranean Bliss',
                'description' => 'A taste of the coast. Kalamata olives, feta, roasted red peppers, spinach, and oregano.',
                'ingredients' => ['Kalamata Olives', 'Feta Cheese', 'Roasted Red Peppers', 'Baby Spinach', 'Greek Oregano'],
                'price' => 469.00,
                'image' => 'https://images.unsplash.com/photo-1604382355076-af4b0eb60143?w=600&h=600&fit=crop',
                'category' => 'vegetarian',
                'is_featured' => false,
                'is_available' => true,
            ],
        ];

        foreach ($pizzas as $pizza) {
            Pizza::create($pizza);
        }
    }
}
