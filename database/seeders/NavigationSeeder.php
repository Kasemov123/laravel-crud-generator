<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class NavigationSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'navigation')->first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Navigation',
                'slug' => 'navigation',
                'description' => 'Navigation components',
                'is_active' => true,
            ]);
        }

        Storage::disk('public')->makeDirectory('components/navigation');

        $navs = [
            ['name' => 'Navbar', 'slug' => 'navbar', 'code' => '<nav class="bg-white dark:bg-gray-900 shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="text-xl font-bold text-gray-800 dark:text-gray-100">Logo</div>
            <div class="flex gap-6">
                <a href="#" class="text-gray-700 dark:text-gray-300 pointer-events-none">Home</a>
                <a href="#" class="text-gray-700 dark:text-gray-300 pointer-events-none">About</a>
                <a href="#" class="text-gray-700 dark:text-gray-300 pointer-events-none">Contact</a>
            </div>
        </div>
    </div>
</nav>'],
            ['name' => 'Breadcrumbs', 'slug' => 'breadcrumbs', 'code' => '<nav class="flex">
    <ol class="inline-flex items-center space-x-1">
        <li><a href="#" class="text-gray-700 dark:text-gray-300 pointer-events-none">Home</a></li>
        <li><span class="text-gray-500 dark:text-gray-500 mx-2">/</span></li>
        <li><a href="#" class="text-gray-700 dark:text-gray-300 pointer-events-none">Products</a></li>
        <li><span class="text-gray-500 dark:text-gray-500 mx-2">/</span></li>
        <li><span class="text-gray-500 dark:text-gray-400">Current</span></li>
    </ol>
</nav>'],
            ['name' => 'Tabs', 'slug' => 'tabs', 'code' => '<div class="border-b border-gray-200 dark:border-gray-700">
    <nav class="flex gap-4">
        <button type="button" disabled class="px-4 py-2 border-b-2 border-blue-600 dark:border-blue-500 text-blue-600 dark:text-blue-400 font-medium cursor-not-allowed">Tab 1</button>
        <button type="button" disabled class="px-4 py-2 text-gray-600 dark:text-gray-400 cursor-not-allowed">Tab 2</button>
        <button type="button" disabled class="px-4 py-2 text-gray-600 dark:text-gray-400 cursor-not-allowed">Tab 3</button>
    </nav>
</div>'],
        ];

        foreach ($navs as $nav) {
            $filePath = 'components/navigation/' . $nav['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $nav['code']);
            Component::create([
                'category_id' => $category->id,
                'name' => $nav['name'],
                'slug' => $nav['slug'],
                'description' => $nav['name'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}
