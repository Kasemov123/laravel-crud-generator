<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CardsSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'cards')->first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Cards',
                'slug' => 'cards',
                'description' => 'Card components',
                'is_active' => true,
            ]);
        }

        Storage::disk('public')->makeDirectory('components/cards');

        $cards = [
            ['name' => 'Profile Card', 'slug' => 'profile-card', 'code' => '<div class="max-w-sm bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
    <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600"></div>
    <div class="relative px-6 pb-6">
        <div class="absolute -top-12 left-6">
            <div class="w-24 h-24 bg-gray-300 dark:bg-gray-700 rounded-full border-4 border-white dark:border-gray-900"></div>
        </div>
        <div class="pt-16">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">John Doe</h3>
            <p class="text-gray-600 dark:text-gray-400">Web Developer</p>
            <button type="button" disabled class="mt-4 w-full bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-lg cursor-not-allowed opacity-90">Follow</button>
        </div>
    </div>
</div>'],
            ['name' => 'Product Card', 'slug' => 'product-card', 'code' => '<div class="max-w-sm bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
    <div class="h-48 bg-gray-300 dark:bg-gray-700"></div>
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Product Name</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">High quality product description.</p>
        <div class="mt-4 flex items-center justify-between">
            <span class="text-2xl font-bold text-gray-800 dark:text-gray-100">$99.99</span>
            <button type="button" disabled class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-lg cursor-not-allowed opacity-90">Add to Cart</button>
        </div>
    </div>
</div>'],
            ['name' => 'Pricing Card', 'slug' => 'pricing-card', 'code' => '<div class="max-w-sm bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8 border-2 border-blue-600 dark:border-blue-500">
    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Pro Plan</h3>
    <div class="mt-4">
        <span class="text-4xl font-bold text-gray-800 dark:text-gray-100">$29</span>
        <span class="text-gray-600 dark:text-gray-400">/month</span>
    </div>
    <ul class="mt-6 space-y-3">
        <li class="flex items-center text-gray-700 dark:text-gray-300"><span class="mr-2">✓</span> Unlimited Projects</li>
        <li class="flex items-center text-gray-700 dark:text-gray-300"><span class="mr-2">✓</span> 24/7 Support</li>
    </ul>
    <button type="button" disabled class="mt-6 w-full bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-lg cursor-not-allowed opacity-90">Get Started</button>
</div>'],
            ['name' => 'Stats Card', 'slug' => 'stats-card', 'code' => '<div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Total Users</p>
            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-2">12,345</p>
        </div>
        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
            <span class="text-blue-600 dark:text-blue-400 text-xl">👥</span>
        </div>
    </div>
    <div class="mt-4">
        <span class="text-green-600 dark:text-green-400 text-sm">↑ 12%</span>
        <span class="text-gray-600 dark:text-gray-400 text-sm ml-2">from last month</span>
    </div>
</div>'],
        ];

        foreach ($cards as $card) {
            $filePath = 'components/cards/' . $card['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $card['code']);
            Component::create([
                'category_id' => $category->id,
                'name' => $card['name'],
                'slug' => $card['slug'],
                'description' => $card['name'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}
