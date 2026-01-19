<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TablesSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'tables')->first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Tables',
                'slug' => 'tables',
                'description' => 'Table components',
                'is_active' => true,
            ]);
        }

        Storage::disk('public')->makeDirectory('components/tables');

        $tables = [
            ['name' => 'Simple Table', 'slug' => 'simple-table', 'code' => '<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Name</th>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Email</th>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Role</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-t border-gray-200 dark:border-gray-700">
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">John Doe</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">john@example.com</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">Admin</td>
            </tr>
            <tr class="border-t border-gray-200 dark:border-gray-700">
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">Jane Smith</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">jane@example.com</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">User</td>
            </tr>
        </tbody>
    </table>
</div>'],
            ['name' => 'Striped Table', 'slug' => 'striped-table', 'code' => '<div class="overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Product</th>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Price</th>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Stock</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-gray-50 dark:bg-gray-800">
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">Product 1</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">$99.99</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">In Stock</td>
            </tr>
            <tr class="bg-white dark:bg-gray-900">
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">Product 2</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">$149.99</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">Out of Stock</td>
            </tr>
        </tbody>
    </table>
</div>'],
        ];

        foreach ($tables as $table) {
            $filePath = 'components/tables/' . $table['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $table['code']);
            Component::create([
                'category_id' => $category->id,
                'name' => $table['name'],
                'slug' => $table['slug'],
                'description' => $table['name'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}
